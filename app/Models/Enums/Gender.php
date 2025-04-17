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

    public static function options(): array
    {
        return [
            self::Male->value => __('gender.male'),
            self::Female->value => __('gender.female'),
            self::Other->value => __('gender.other'),
        ];
    }

    public static function getDefault(): null
    {
        return null;
    }
}
