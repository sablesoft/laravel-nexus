<?php

namespace App\Models\Enums;

use App\Enums\EnumContract;
use App\Enums\EnumTrait;

enum StateType: string implements EnumContract
{
    use EnumTrait;

    case Bool = 'bool';
    case Int = 'int';
    case String = 'string';
    case Float = 'float';
    case Enum = 'enum';

    public static function getDefault(): self
    {
        return self::String;
    }

    public static function options(?string $locale = null): array
    {
        return [
            self::Bool->value => 'Boolean',
            self::Int->value => 'Integer',
            self::String->value => 'String',
            self::Float->value => 'Float',
            self::Enum->value => 'Enum',
        ];
    }

    public function isValid(array $state): bool
    {
        $value = $state['value'] ?? null;
        $options = $state['options'] ?? null;

        return match ($this) {
            self::Bool   => is_bool($value),
            self::Int    => is_int($value),
            self::String => is_string($value),
            self::Float  => is_float($value),
            self::Enum   => is_string($value)
                && is_array($options)
                && in_array($value, $options, true),
        };
    }
}
