<?php

namespace App\Logic;

use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Contracts\HasEffectsContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Traits\EffectsStack;
use App\Logic\Traits\Timing;
use App\Models\Chat;
use App\Models\ChatLog;
use App\Models\Member;
use App\Models\Memory;
use App\Models\Screen;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use RuntimeException;

/**
 * The Process class represents the central logic execution context
 * within the platform. It is used across all logic execution flows (scenarios, steps, commands),
 * and holds both core models (chat, screen, member, memory) and arbitrary user/system data.
 *
 * In addition, Process supports serialization/deserialization, queue execution,
 * execution timing, before/after setup block tracing, and DSL-compatible data access.
 *
 * ---
 * Context:
 * - LogicJob — serializes and restores Process for background logic execution
 * - LogicRunner — manages full execution lifecycle using Process as the persistent logic context
 * - NodeRunner — executes individual logic nodes using Process
 * - EffectRunner — applies before/after config blocks using context from Process
 * - Livewire component Chat\Play — creates Process instances for user interactions (action, input, transfer)
 */
class Process
{
    use Timing, EffectsStack;

    protected array $data = []; // Custom data related to the current logic execution
    public bool $inQueue = false; // Whether the process is currently running via queue
    public bool $skipQueue = false; // Whether to explicitly skip queueing

    /**
     * DSL adapters for core models. Used to expose model data to DSL expressions
     * while protecting the models from invalid access.
     *
     * Custom adapters can be returned via HasDslAdapterContract;
     * otherwise, the default ModelDslAdapter is used.
     */
    public readonly Chat $chat;
    public readonly Memory $memory;
    public readonly Screen $screen;
    public readonly Member $member;

    /**
     * Adapter mapping: each key maps to an Eloquent model.
     * This is used in __construct and unpack for initialization.
     * Every Process instance will always have all four adapters initialized,
     * but they may wrap a blank (new) model if not explicitly provided.
     */
    protected array $adapters = [
        'chat'   => Chat::class,
        'screen' => Screen::class,
        'memory' => Memory::class,
        'member' => Member::class,
    ];

    public function __construct(array $initial = [])
    {
        // Initialize DSL adapters for all required models
        foreach ($this->adapters as $key => $modelClass) {
            $model = $initial[$key] ?? new $modelClass();
            if (!($model instanceof $modelClass)) {
                throw new InvalidArgumentException("Invalid model [$key], expected instance of [$modelClass].");
            }
            $this->{$key} = $model;
            unset($initial[$key]); // Remaining entries are treated as general data
        }

        $this->data = $initial;
    }

    /** Determines whether this process should be queued */
    public function shouldQueue(): bool
    {
        return !$this->skipQueue && !$this->inQueue;
    }

    // Data access helpers (dot notation supported)
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    public function set(string $key, mixed $value): void
    {
        Arr::set($this->data, $key, $value);
    }

    public function forget(string|array $key): void
    {
        foreach ((array) $key as $variable) {
            Arr::forget($this->data, $variable);
        }
    }

    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * @throw RuntimeException
     */
    public function push(string $key, mixed $value): void
    {
        $array = Arr::get($this->data, $key, []);

        if (!is_array($array) || !array_is_list($array)) {
            throw new RuntimeException("Cannot push to [$key]: target is not an indexed array.");
        }

        $array[] = $value;
        Arr::set($this->data, $key, $array);
    }

    public function data(): array
    {
        return $this->data;
    }

    public function merge(array $items, ?string $path = null): void
    {
        $data = $path ? $this->get($path, []) : $this->data;
        $to = $path ? " to [$path]" : '';
        if (!is_array($data)) {
            throw new RuntimeException("Cannot merge data$to: value must be an array.");
        }
        if (!empty($data)) {
            $isIndexed = array_is_list($items);
            $isDataIndexed = array_is_list($data);
            if ($isIndexed !== $isDataIndexed) {
                throw new RuntimeException("Cannot merge data$to: array types do not match (indexed vs associative).");
            }
        }

        $data = array_merge($data, $items);
        if ($path) {
            $this->set($path, $data);
        } else {
            $this->data = $data;
        }
    }

    /**
     * Returns the full context used in DSL evaluations:
     * includes both wrapped models and user data.
     * All values are accessible in logic expressions, though adapters are read-only.
     */
    public function toContext(): array
    {
        $context = [];
        foreach (array_keys($this->adapters) as $key) {
            $model = $this->{$key};
            // Use a custom DSL adapter if available, otherwise fallback to the default adapter
            $context[$key] =($model instanceof HasDslAdapterContract)
                ? $model->getDslAdapter($this)
                : new ModelDslAdapter($this, $model);
        }

        return array_merge($this->data, $context);
    }

    /**
     * Serializes the process into an array for queue transport
     */
    public function pack(): array
    {
        return [
            'data' => $this->data,
            'adapters' => [
                'chat'   => $this->chat->getKey(),
                'screen' => $this->screen->getKey(),
                'memory' => $this->memory->getKey(),
                'member' => $this->member->getKey(),
            ],
            'inQueue'    => $this->inQueue,
            'skipQueue'  => $this->skipQueue,
            'timing'     => $this->packTiming(), // from Timing trait
        ];
    }

    /**
     * Reconstructs a process instance from its serialized form (typically within a LogicJob)
     */
    public static function unpack(array $payload): Process
    {
        $adapters = [
            'chat'   => Chat::findOrNew($payload['adapters']['chat'] ?? null),
            'screen' => Screen::findOrNew($payload['adapters']['screen'] ?? null),
            'memory' => Memory::findOrNew($payload['adapters']['memory'] ?? null),
            'member' => Member::findOrNew($payload['adapters']['member'] ?? null),
        ];

        $instance = new static(array_merge($adapters, $payload['data'] ?? []));

        $instance->inQueue   = $payload['inQueue'] ?? false;
        $instance->skipQueue = $payload['skipQueue'] ?? false;
        $instance->unpackTiming($payload['timing'] ?? []);

        return $instance;
    }

    /**
     * Wraps the execution of a logic block (before/after) in a timer and logger.
     * Used by NodeRunner and LogicRunner when executing HasEffectsContract logic blocks.
     */
    public function handle(string $block, HasEffectsContract $effects, callable $callback): mixed
    {
        $code = $effects->getCode() . '::' . $block;
        $data = match ($block) {
            'before' => $effects->getBefore(),
            'after'  => $effects->getAfter(),
            default  => null
        };

        $this->startTimer($code, $identifier);
        $this->startLog($identifier, $data);
        try {
            return $callback();
        } finally {
            $this->stopTimer($identifier);
            $this->stopLog($identifier, $data);
        }
    }

    public function writeLog(array $raw, ?string $message = null, string $level = 'info'): void
    {
        if (!$message || !$this->chat->getKey()) {
            return;
        }

        $key = array_key_first($raw);
        ChatLog::create([
            'chat_id'    => $this->chat->getKey(),
            'member_id'  => $this->member->getKey(),
            'effect_key' => $key,
            'level'      => $level,
            'message'    => $message,
            'context'    => [
                'raw'    => $raw[$key],
                'data'   => $this->data(),
                'screen' => $this->screen->code,
            ],
        ]);
    }
}
