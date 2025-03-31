<?php

namespace App\Logic\Effect;

use InvalidArgumentException;

class EffectValidator
{
    /**
     * @param array<int, array<string, mixed>> $effects
     */
    public static function validate(array $effects): void
    {
        foreach ($effects as $index => $effect) {
            if (!is_array($effect) || count($effect) !== 1) {
                throw new InvalidArgumentException("Invalid effect at index [$index]: must have exactly one key.");
            }

            $key = array_key_first($effect);
            $value = $effect[$key];

            if (!EffectDefinitionRegistry::has($key)) {
                throw new InvalidArgumentException("Unknown effect type: [$key]");
            }

            $definition = EffectDefinitionRegistry::get($key);
            $schema = $definition::describe();

            static::validateStructure($key, $value, $schema);
        }
    }

    protected static function validateStructure(string $key, mixed $value, array $schema): void
    {
        $type = $schema['type'] ?? 'map';

        match ($type) {
            'map' => is_array($value) ?: throw new InvalidArgumentException("Effect [$key] must be a map."),
            'list' => is_array($value) ?: throw new InvalidArgumentException("Effect [$key] must be a list."),
            'scalar' => (!is_array($value)) ?: throw new InvalidArgumentException("Effect [$key] must be a scalar."),
            default => throw new InvalidArgumentException("Unknown type [$type] in effect definition for [$key]."),
        };

        // Более строгую проверку полей можно внедрить позже
    }
}
