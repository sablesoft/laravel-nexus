<?php

namespace App\Logic;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Effects\Definitions\SetEffectDefinition;
use App\Logic\Effects\Definitions\UnsetEffectDefinition;
use App\Logic\Effects\Definitions\ValidateEffectDefinition;
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
        static::register(SetEffectDefinition::KEY, new SetEffectDefinition());
        static::register(UnsetEffectDefinition::KEY, new UnsetEffectDefinition());
        static::register(ValidateEffectDefinition::KEY, new ValidateEffectDefinition());
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
