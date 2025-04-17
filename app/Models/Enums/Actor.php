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

    public static function options(): array
    {
        return [
            self::Player->value => __('actor.player'),
            self::System->value => __('actor.system'),
        ];
    }
}
