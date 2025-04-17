<?php

namespace App\Enums;

interface EnumContract
{
    public function label(?string $locale = null): string;
    public static function values(): array;
    public static function options(?string $locale = null): array;
    public static function getDefault(): ?self;
}
