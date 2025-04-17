<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum Gender: string implements EnumContract
{
    use EnumTrait;

    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public static function options(?string $locale = null): array
    {
        return [
            self::Male->value => __('gender.male', [], $locale),
            self::Female->value => __('gender.female', [], $locale),
            self::Other->value => __('gender.other', [], $locale),
        ];
    }

    public static function getDefault(): null
    {
        return null;
    }
}
