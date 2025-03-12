<?php

namespace App\Models\Enums;
enum ChatStatus: string
{
    case Created = 'created';
    case Published = 'published';
    case Started = 'started';
    case Ended = 'ended';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function publicValues(): array
    {
        return [
            self::Published->value,
            self::Started->value,
            self::Ended->value,
        ];
    }
}
