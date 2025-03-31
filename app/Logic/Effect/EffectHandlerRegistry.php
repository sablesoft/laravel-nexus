<?php

namespace App\Logic\Effect;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Effect\Definitions\SetEffectDefinition;
use App\Logic\Effect\Definitions\UnsetEffectDefinition;
use App\Logic\Effect\Definitions\ValidateEffectDefinition;
use App\Logic\Effect\Handlers\SetEffectHandler;
use App\Logic\Effect\Handlers\UnsetEffectHandler;
use App\Logic\Effect\Handlers\ValidateEffectHandler;
use InvalidArgumentException;

class EffectHandlerRegistry
{
    protected static array $map = [];

    public static function register(string $key, string $class): void
    {
        self::$map[$key] = $class;
    }

    public static function resolve(array $raw): EffectHandlerContract
    {
        $key = array_key_first($raw);
        $data = $raw[$key];

        if (!isset(self::$map[$key])) {
            throw new InvalidArgumentException("Unknown effect type: [$key]");
        }

        $class = self::$map[$key];

        return new $class(is_array($data) ? $data : [$data]);
    }

    public static function boot(): void
    {
        EffectHandlerRegistry::register(SetEffectDefinition::KEY, SetEffectHandler::class);
        EffectHandlerRegistry::register(UnsetEffectDefinition::KEY, UnsetEffectHandler::class);
        EffectHandlerRegistry::register(ValidateEffectDefinition::KEY, ValidateEffectHandler::class);
    }
}
