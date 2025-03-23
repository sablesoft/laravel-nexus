<?php

namespace App\Models\Enums;

enum Command: string
{
    case Back = 'back';
    case Transfer = 'transfer';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
