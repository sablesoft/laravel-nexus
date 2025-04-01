<?php

namespace App\Logic\Effect;

use App\Logic\Contracts\EffectDefinitionContract;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class EffectValidator
{
    /**
     * Validates a list of effects.
     *
     * @param array<int, array<string, mixed>> $effects
     * @param bool $deep Whether to recursively validate nested effect blocks
     * @param string $path Effect key path (for error reporting)
     */
    public static function validate(array $effects, bool $deep = true, string $path = ''): void
    {
        foreach ($effects as $index => $effect) {
            if (!is_array($effect) || count($effect) !== 1) {
                throw new InvalidArgumentException("Invalid effect at [$path#$index]: must have exactly one key.");
            }

            $key = array_key_first($effect);
            $params = $effect[$key];
            $fullKey = $path === '' ? $key : "$path.$key";

            if (!EffectDefinitionRegistry::has($key)) {
                throw new InvalidArgumentException("Unknown effect type: [$fullKey]");
            }

            $definition = EffectDefinitionRegistry::get($key);
            $data = is_array($params)
                ? (Arr::isList($params) ? ['value' => $params] : $params)
                : ['value' => $params];

            static::validateRules($fullKey, $data, $definition::rules());

            if ($deep) {
                static::validateNested($definition, $data, $fullKey);
            }
        }
    }

    protected static function validateRules(string $keyPath, mixed $params, array $rules): void
    {
        if (empty($rules)) {
            return;
        }

        try {
            validator($params, $rules)->validate();
        } catch (\Throwable $e) {
            throw new InvalidArgumentException("Validation failed in [$keyPath]: " . $e->getMessage(), 0, $e);
        }
    }

    protected static function validateNested(EffectDefinitionContract $definition, array $params, string $parentPath): void
    {
        $nested = $definition::nestedEffects($params);

        foreach ($nested as $slot => $effects) {
            $nestedPath = "$parentPath.$slot";
            static::validate($effects, true, $nestedPath);
        }
    }
}
