<?php

namespace App\Models\Enums;

enum ScenarioType: string
{
    case Action = 'action';
    case Input = 'input';
    case Hidden = 'hidden';

    public static function getDefault(): self
    {
        return self::Hidden;
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($result, $case) {
            $value = $case->value;
            $result[$value] = ucfirst($value);
            return $result;
        }, []);
    }
}
