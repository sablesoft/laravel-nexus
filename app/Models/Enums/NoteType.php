<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum NoteType: string implements EnumContract
{
    use EnumTrait;

    case CardTemplate = 'card-template';
    case Other = 'other';

    public static function getDefault(): self
    {
        return self::Other;
    }

    public static function options(?string $locale = null): array
    {
        return [
            self::CardTemplate->value => __('note-type.card-template', [], $locale),
            self::Other->value => __('note-type.other', [], $locale),
        ];
    }
}
