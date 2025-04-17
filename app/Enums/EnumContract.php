<?php

namespace App\Enums;

interface EnumContract
{
    public static function options(): array;
    public static function getDefault(): ?self;
}
