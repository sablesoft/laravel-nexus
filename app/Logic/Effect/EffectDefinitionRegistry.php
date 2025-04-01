<?php

namespace App\Logic\Effect;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Effect\Definitions\IfDefinition;
use App\Logic\Effect\Definitions\MemoryCreateDefinition;
use App\Logic\Effect\Definitions\ChatRefreshDefinition;
use App\Logic\Effect\Definitions\SetDefinition;
use App\Logic\Effect\Definitions\UnsetDefinition;
use App\Logic\Effect\Definitions\ValidateDefinition;
use InvalidArgumentException;

class EffectDefinitionRegistry
{
    /**
     * @var array<string, EffectDefinitionContract>
     */
    protected static array $definitions = [];

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

    public static function boot(): void
    {
        static::register(IfDefinition::KEY, new IfDefinition());
        static::register(SetDefinition::KEY, new SetDefinition());
        static::register(UnsetDefinition::KEY, new UnsetDefinition());
        static::register(ValidateDefinition::KEY, new ValidateDefinition());
        static::register(MemoryCreateDefinition::KEY, new MemoryCreateDefinition());
        static::register(ChatRefreshDefinition::KEY, new ChatRefreshDefinition());
    }

    public static function toSchema(): array
    {
        $result = [];

        foreach (static::$definitions as $key => $definition) {
            $result[$key] = $definition::describe();
        }

        return $result;
    }
}
