<?php

namespace App\Models\Enums;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public function label(): string
    {
        return __(ucfirst($this->value));
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($sex) => [
                $sex->value => __(ucfirst($sex->value))
            ])->toArray();
    }

    public static function values(): array
    {
        return array_map(fn(self $case) => $case->value, self::cases());
    }
}
