<?php

namespace App\Services\OpenAI\Enums;

enum ImageQuality: string
{
    case Standard = 'standard';
    case HD = 'hd';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return [
            self::Standard->value => 'Standard',
            self::HD->value => 'HD'
        ];
    }

    public static function getDefault(): self
    {
        return self::Standard;
    }
}
