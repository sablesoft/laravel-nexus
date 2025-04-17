<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum Actor: string implements EnumContract
{
    use EnumTrait;

    case Player = 'player';
    case System = 'system';

    public static function getDefault(): self
    {
        return self::System;
    }

    public static function options(?string $locale = null): array
    {
        return [
            self::Player->value => __('actor.player', [], $locale),
            self::System->value => __('actor.system', [], $locale),
        ];
    }
}
