<?php

namespace App\Enums;

trait EnumTrait
{
    public function label(): string
    {
        return self::options()[$this->value];
    }

    public static function values(): array
    {
        return array_keys(self::options());
    }
}
