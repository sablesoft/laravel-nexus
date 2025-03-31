<?php

namespace App\Logic;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Contracts\SetupContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Traits\SetupStack;
use App\Logic\Traits\Timing;
use App\Models\Chat;
use App\Models\Member;
use App\Models\Memory;
use App\Models\Screen;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * The Process class represents the central logic execution context
 * within the platform. It is used across all logic execution flows (scenarios, steps, commands),
 * and holds both core models (chat, screen, member, memory) and arbitrary user/system data.
 *
 * In addition, Process supports serialization/deserialization, queue execution,
 * execution timing, before/after setup block tracing, and DSL-compatible data access.
 *
 * ---
 * Environment:
 * - LogicJob — serializes and restores Process for background logic execution
 * - LogicRunner — manages full execution lifecycle using Process as the persistent logic context
 * - NodeRunner — executes individual logic nodes using Process
 * - SetupRunner — applies before/after config blocks using context from Process
 * - Livewire component Chat\Play — creates Process instances for user interactions (action, input, transfer)
 */
class Process
{
    use Timing, SetupStack;

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
    public readonly DslAdapterContract $chat;
    public readonly DslAdapterContract $memory;
    public readonly DslAdapterContract $screen;
    public readonly DslAdapterContract $member;

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

            // Use a custom DSL adapter if available, otherwise fallback to the default adapter
            $this->{$key} = ($model instanceof HasDslAdapterContract)
                ? $model->getDslAdapter($this)
                : new ModelDslAdapter($this, $model);

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

    public function forget(string $key): void
    {
        Arr::forget($this->data, $key);
    }

    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    public function data(): array
    {
        return $this->data;
    }

    public function merge(array $newData): void
    {
        $this->data = array_merge($this->data, $newData);
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
            $context[$key] = $this->{$key};
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
                'chat'   => $this->chat->id(),
                'screen' => $this->screen->id(),
                'memory' => $this->memory->id(),
                'member' => $this->member->id(),
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
     * Used by NodeRunner and LogicRunner when executing SetupContract logic blocks.
     */
    public function handle(string $block, SetupContract $setup, callable $callback): mixed
    {
        $code = $setup->getCode() . '::' . $block;
        $data = match ($block) {
            'before' => $setup->getBefore(),
            'after'  => $setup->getAfter(),
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
}
