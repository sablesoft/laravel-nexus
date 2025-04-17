<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum ControlType: string implements EnumContract
{
    use EnumTrait;

    case Action = 'action';
    case Input = 'input';

    public static function getDefault(): self
    {
        return self::Action;
    }

    public static function options(?string $locale = null): array
    {
        return [
            self::Action->value => __('control-type.action', [], $locale),
            self::Input->value => __('control-type.input', [], $locale),
        ];
    }
}
