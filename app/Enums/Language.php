<?php

namespace App\Enums;

use Symfony\Component\Intl\Languages;

enum Language: string implements EnumContract
{
    case En = 'en';
    case Ru = 'ru';
    case Pt = 'pt';

    public function label(?string $locale = null): string
    {
        return Languages::getName($this->value, $locale ?? app()->getLocale());
    }

    public static function options(?string $locale = null): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($lang) => [
                $lang->value => mb_convert_case($lang->label($locale), MB_CASE_TITLE, 'UTF-8')
            ])->toArray();
    }

    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }

    public static function getDefault(): ?self
    {
        return self::En;
    }

    public static function defaultCode(): string
    {
        return self::En->value;
    }
}

