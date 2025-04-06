<?php

namespace App\Logic\Validators;

use App\Logic\Contracts\DslValidatorContract;
use InvalidArgumentException;

class StatesValidator implements DslValidatorContract
{
    protected const SUPPORTED_TYPES = ['bool', 'int', 'string', 'enum'];

    public static function validate(array $dsl): void
    {
        if (empty($dsl)) {
            return;
        }
        if (!array_key_exists('has', $dsl)) {
            throw new InvalidArgumentException("States must contain a 'has' root block.");
        }
        $states = $dsl['has'];
        if (!is_array($states) || array_is_list($states)) {
            throw new InvalidArgumentException("The 'has' block must be an associative array.");
        }

        foreach ($states as $name => $definition) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name)) {
                throw new InvalidArgumentException("Invalid state name: '{$name}'. Must be variable-like.");
            }
            if (!is_array($definition) || array_is_list($definition)) {
                throw new InvalidArgumentException("State '{$name}' must be an object with keys: 'type' and 'value'.");
            }
            $type = $definition['type'] ?? null;
            if (!is_string($type) || !in_array($type, self::SUPPORTED_TYPES, true)) {
                throw new InvalidArgumentException("Invalid type for state '{$name}'. Supported types: " . implode(', ', self::SUPPORTED_TYPES));
            }
            if (!array_key_exists('value', $definition)) {
                throw new InvalidArgumentException("State '{$name}' must define a default 'value'.");
            }
            if ($type === 'enum') {
                $value = $definition['value'] ?? null;
                if (!isset($definition['options']) || !is_array($definition['options']) || !array_is_list($definition['options'])) {
                    throw new InvalidArgumentException("State '{$name}' of type 'enum' must define a list of 'options'.");
                }
                if (!in_array($value, $definition['options'], true)) {
                    throw new InvalidArgumentException("The default value '{$value}' for enum state '{$name}' must be one of the defined options.");
                }
            }
        }
    }
}
