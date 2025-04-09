<?php

namespace App\Models\Enums;

enum StateType: string
{
    case Bool = 'bool';
    case Int = 'int';
    case String = 'string';
    case Float = 'float';
    case Enum = 'enum';

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

    public function label(): string
    {
        return match ($this) {
            self::Bool => 'Boolean',
            self::Int => 'Integer',
            self::String => 'String',
            self::Float => 'Float',
            self::Enum => 'Enum',
        };
    }
}
