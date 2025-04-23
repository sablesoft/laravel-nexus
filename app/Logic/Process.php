<?php

namespace App\Logic;

use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Contracts\HasEffectsContract;
use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Dsl\Adapters\NoteDslAdapter;
use App\Logic\Traits\EffectsStack;
use App\Logic\Traits\Timing;
use App\Models\Chat;
use App\Models\ChatLog;
use App\Models\Character;
use App\Models\Interfaces\HasNotesInterface;
use App\Models\Memory;
use App\Models\Screen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use RuntimeException;

/**
 * The Process class represents the central logic execution context
 * within the platform. It is used across all logic execution flows (scenarios, steps, commands),
 * and holds both core models (chat, screen, character, memory) and arbitrary user/system data.
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

    const STORAGE_TYPE_DATA = 'data';
    const STORAGE_TYPE_FUNCTION = 'function';

    const STORAGE_TYPES = [
        self::STORAGE_TYPE_DATA,
        self::STORAGE_TYPE_FUNCTION
    ];

    /**
     * Adapter mapping: each key maps to an Eloquent model.
     * This is used in __construct and unpack for initialization.
     * Every Process instance will always have all four adapters initialized,
     * but they may wrap a blank (new) model if not explicitly provided.
     */
    const ADAPTERS = [
        'chat'      => Chat::class,
        'screen'    => Screen::class,
        'memory'    => Memory::class,
        'character' => Character::class,
    ];

    protected array $data = []; // Custom data related to the current logic execution
    protected array $function = []; // Custom functions (lists of effects) related to the current logic executions
    public bool $screenBack = false;
    public bool $screenWaiting = false;
    public ?int $screenTransfer = null;

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
    public readonly Character $character;

    public null|HasNotesInterface|NodeContract|LogicContract $note = null;

    public function __construct(array $initial = [])
    {
        // Initialize DSL adapters for all required models
        foreach (self::ADAPTERS as $key => $modelClass) {
            $model = $initial[$key] ?? new $modelClass();
            if (!($model instanceof $modelClass)) {
                throw new InvalidArgumentException("Invalid model [$key], expected instance of [$modelClass].");
            }
            $this->{$key} = $model;
            unset($initial[$key]); // Remaining entries are treated as general data
        }

        $this->data = $initial;
    }

    public function clone(array $initial = []): static
    {
        $original = $this->data;
        foreach (array_keys(self::ADAPTERS) as $key) {
            $original[$key] = $this->$key;
        }
        $initial = array_merge($original, $initial);

        return new static($initial);
    }

    // Storage access helpers (dot notation supported)
    public function get(string $key, mixed $default = null, string $type = 'data'): mixed
    {
        $storage = $this->getStorage($type);
        return Arr::get($storage, $key, $default);
    }

    public function set(string $key, mixed $value, string $type = 'data'): void
    {
        $storage = $this->getStorage($type);
        Arr::set($storage, $key, $value);
        $this->setStorage($type, $storage);
    }

    public function forget(string|array $key, $type = 'data'): void
    {
        $storage = $this->getStorage($type);
        foreach ((array) $key as $variable) {
            Arr::forget($storage, $variable);
        }
        $this->setStorage($type, $storage);
    }

    public function has(string $key, $type = 'data'): bool
    {
        $storage = $this->getStorage($type);
        return Arr::has($storage, $key);
    }

    /**
     * @throw RuntimeException
     */
    public function push(string $key, mixed $value, string $type = 'data'): void
    {
        $storage = $this->getStorage($type);
        $array = Arr::get($storage, $key, []);

        if (!is_array($array) || !array_is_list($array)) {
            throw new RuntimeException("Cannot push to [$key]: target is not an indexed array.");
        }

        $array[] = $value;
        Arr::set($storage, $key, $array);
        $this->setStorage($type, $storage);
    }

    public function merge(array $items, ?string $path = null, string $type = 'data'): void
    {
        $storage = $path ? $this->get($path, [], $type) : $this->$type;
        $to = $path ? " to $type [$path]" : '';
        if (!is_array($storage)) {
            throw new RuntimeException("Cannot merge data$to: value must be an array.");
        }
        if (!empty($storage)) {
            $isIndexed = array_is_list($items);
            $isDataIndexed = array_is_list($storage);
            if ($isIndexed !== $isDataIndexed) {
                throw new RuntimeException("Cannot merge storage$to: array types do not match (indexed vs associative).");
            }
        }

        $storage = array_merge($storage, $items);
        if ($path) {
            $this->set($path, $storage, $type);
        } else {
            $this->$type = $storage;
        }
    }

    public function data(): array
    {
        return $this->data;
    }

    /**
     * Returns the full context used in DSL evaluations:
     * includes both wrapped models and user data.
     * All values are accessible in logic expressions, though adapters are read-only.
     */
    public function toContext(): array
    {
        $context = [];
        foreach (array_keys(self::ADAPTERS) as $key) {
            $model = $this->{$key};
            // Use a custom DSL adapter if available, otherwise fallback to the default adapter
            $context[$key] = ($model instanceof HasDslAdapterContract)
                ? $model->getDslAdapter($this)
                : new ModelDslAdapter($this, $model);
        }
        if ($model = $this->note) {
            $context['note'] = new NoteDslAdapter($this, $model);
        }

        return array_merge($this->data, $context);
    }

    /**
     * Serializes the process into an array for queue transport
     */
    public function pack(): array
    {
        $storage = [];
        foreach (self::STORAGE_TYPES as $type) {
            $storage[$type] = $this->$type;
        }
        return [
            'storage' => $storage,
            'adapters' => [
                'chat'      => $this->chat->getKey(),
                'screen'    => $this->screen->getKey(),
                'memory'    => $this->memory->getKey(),
                'character' => $this->character->getKey(),
            ],
            'note' => $this->note ? $this->note::class .':'. $this->note->getKey() : null,
            'timing'     => $this->packTiming(), // from Timing trait
        ];
    }

    /**
     * Reconstructs a process instance from its serialized form (typically within a LogicJob)
     */
    public static function unpack(array $payload): Process
    {
        $adapters = [];
        foreach (self::ADAPTERS as $field => $className) {
            $adapters[$field] = $className::findOrNew($payload['adapters'][$field] ?? null);
        }

        $instance = new static($adapters);
        foreach (self::STORAGE_TYPES as $type) {
            $instance->setStorage($type, $payload['storage'][$type] ?? []);
        }

        if ($node = $payload['note'] ?? null) {
            $parts = explode(':', $node);
            /** @var Model $class */
            $class = $parts[0];
            $id = $parts[1];
            $instance->note = $class::findOrFail($id);
        }

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
            'character_id'  => $this->character->getKey(),
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

    public function getStorage(string $type): array
    {
        if (!in_array($type, self::STORAGE_TYPES)) {
            throw new InvalidArgumentException('Process storage type is invalid: ' . $type);
        }

        return $this->$type;
    }

    public function setStorage(string $type, array $storage): void
    {
        if (!in_array($type, self::STORAGE_TYPES)) {
            throw new InvalidArgumentException('Process storage type is invalid: ' . $type);
        }

        $this->$type = $storage;
    }
}
