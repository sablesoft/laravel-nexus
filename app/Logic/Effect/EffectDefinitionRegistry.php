<?php

namespace App\Logic\Effect;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Effect\Definitions\ChatRefreshDefinition;
use App\Logic\Effect\Definitions\CommentDefinition;
use App\Logic\Effect\Definitions\IfDefinition;
use App\Logic\Effect\Definitions\MemoryCreateDefinition;
use App\Logic\Effect\Definitions\MergeDefinition;
use App\Logic\Effect\Definitions\PushDefinition;
use App\Logic\Effect\Definitions\ReturnDefinition;
use App\Logic\Effect\Definitions\SetDefinition;
use App\Logic\Effect\Definitions\UnsetDefinition;
use App\Logic\Effect\Definitions\ValidateDefinition;
use InvalidArgumentException;

/**
 * Central registry for all effect definitions used within the DSL system.
 * Each definition is a class that describes the structure, schema, and
 * validation logic of a particular effect. This registry provides access
 * to those definitions by their DSL keys and ensures they are available
 * to validators, compilers, and UI helpers.
 *
 * Context:
 * - Definitions are registered during system boot via the `boot()` method.
 * - Used by `EffectsValidator` to validate effect blocks statically.
 * - Consumed by the Codemirror DSL editor to show documentation, autocomplete, and schema hints.
 * - Sourced by the DSL interpreter and schema generator (`toSchema()`).
 */
class EffectDefinitionRegistry
{
    /**
     * Registered effect definitions by key.
     * @var array<string, EffectDefinitionContract>
     */
    protected static array $definitions = [];

    /**
     * Register a new effect definition under the given DSL key.
     */
    public static function register(string $key, EffectDefinitionContract $definition): void
    {
        static::$definitions[$key] = $definition;
    }

    public static function all(): array
    {
        return static::$definitions;
    }

    public static function has(string $key): bool
    {
        return isset(static::$definitions[$key]);
    }

    public static function get(string $key): EffectDefinitionContract
    {
        if (!static::has($key)) {
            throw new InvalidArgumentException("Unknown effect definition: [$key]");
        }

        return static::$definitions[$key];
    }

    /**
     * Register all core definitions at boot time.
     *
     * Called during application initialization to ensure base effects are available.
     */
    public static function boot(): void
    {
        static::register(IfDefinition::KEY, new IfDefinition());
        static::register(SetDefinition::KEY, new SetDefinition());
        static::register(PushDefinition::KEY, new PushDefinition());
        static::register(MergeDefinition::KEY, new MergeDefinition());
        static::register(UnsetDefinition::KEY, new UnsetDefinition());
        static::register(ReturnDefinition::KEY, new ReturnDefinition());
        static::register(CommentDefinition::KEY, new CommentDefinition());
        static::register(ValidateDefinition::KEY, new ValidateDefinition());
        static::register(MemoryCreateDefinition::KEY, new MemoryCreateDefinition());
        static::register(ChatRefreshDefinition::KEY, new ChatRefreshDefinition());
        static::register(ChatCompletionDefinition::KEY, new ChatCompletionDefinition());
    }

    /**
     * Export all definitions in a format suitable for schema generation.
     *
     * Used by editor and validation tools to retrieve DSL structure.
     */
    public static function toSchema(): array
    {
        $result = [];

        foreach (static::$definitions as $key => $definition) {
            $result[$key] = $definition::describe();
        }

        return $result;
    }
}
