<?php

namespace App\Enums;

trait EnumTrait
{
    public function label(?string $locale = null): string
    {
        return self::options($locale)[$this->value];
    }

    public static function values(): array
    {
        return array_keys(self::options());
    }
}
