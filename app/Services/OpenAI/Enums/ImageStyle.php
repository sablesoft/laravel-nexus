<?php

namespace App\Services\OpenAI\Enums;

enum ImageStyle: string
{
    case Vivid = 'vivid';
    case Natural = 'natural';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return [
            self::Vivid->value => 'Vivid',
            self::Natural->value => 'Natural'
        ];
    }

    public static function getDefault(): self
    {
        return self::Vivid;
    }
}
