<?php

namespace App\Enums;

use Symfony\Component\Intl\Languages;

enum Language: string
{
    case En = 'en';
    case Ru = 'ru';
    case Pt = 'pt';

    public function label(?string $forLocale = null): string
    {
        return Languages::getName($this->value, $forLocale ?? app()->getLocale());
    }

    public static function options(?string $forLocale = null): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($lang) => [
                $lang->value => mb_convert_case($lang->label($forLocale), MB_CASE_TITLE, 'UTF-8')
            ])->toArray();
    }

    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }

    public static function defaultCode(): string
    {
        return self::En->value;
    }
}

