<?php

namespace App\Models\Enums;
enum ChatStatus: string
{
    case Created = 'created';
    case Published = 'published';
    case Started = 'started';
    case Closed = 'closed';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
