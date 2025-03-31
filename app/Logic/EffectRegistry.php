<?php

namespace App\Logic;

use App\Logic\Contracts\EffectContract;
use App\Logic\Effects\Definitions\SetEffectDefinition;
use App\Logic\Effects\Definitions\UnsetEffectDefinition;
use App\Logic\Effects\Definitions\ValidateEffectDefinition;
use App\Logic\Effects\SetEffect;
use App\Logic\Effects\UnsetEffect;
use App\Logic\Effects\ValidateEffect;
use InvalidArgumentException;

class EffectRegistry
{
    protected static array $map = [];

    public static function register(string $key, string $class): void
    {
        self::$map[$key] = $class;
    }

    public static function resolve(array $raw): EffectContract
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
        EffectRegistry::register(SetEffectDefinition::KEY, SetEffect::class);
        EffectRegistry::register(UnsetEffectDefinition::KEY, UnsetEffect::class);
        EffectRegistry::register(ValidateEffectDefinition::KEY, ValidateEffect::class);
    }
}
