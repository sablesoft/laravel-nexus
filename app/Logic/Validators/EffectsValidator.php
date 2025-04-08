<?php

namespace App\Logic\Validators;

use App\Logic\Contracts\DslValidatorContract;
use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Effect\EffectDefinitionRegistry;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * Provides centralized validation for all DSL-defined effects.
 * Validates both structure and data types using Laravel-style rules,
 * and recursively checks nested effect blocks (e.g., `if`, `switch`, etc.).
 *
 * This is a compile-time utility invoked before scenario execution to ensure
 * that the DSL content is safe, valid, and semantically correct.
 *
 * Context:
 * - Consumes effect metadata from `EffectDefinitionRegistry`.
 * - Validates effect parameters based on `rules()` and `nestedEffects()` of each definition.
 * - Used in Codemirror editor live checks and backend DSL compilers.
 */
class EffectsValidator implements DslValidatorContract
{
    /**
     * Validates a list of effects.
     */
    public static function validate(mixed $dsl): void
    {
        if (!is_array($dsl)) {
            throw new InvalidArgumentException("Effects must be an array.");
        }

        static::_validate($dsl);
    }

    protected static function _validate(array $dsl, string $path = ''): void
    {
        foreach ($dsl as $index => $effect) {
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
            static::validateNested($definition, $data, $fullKey);
        }
    }

    /**
     * Apply validation rules to the effect parameters.
     */
    protected static function validateRules(string $keyPath, mixed $params, array $rules): void
    {
        if (empty($rules)) {
            return;
        }

        try {
            validator(static::trimKeyPrefixes($params), $rules)->validate();
        } catch (\Throwable $e) {
            throw new InvalidArgumentException("Validation failed in [$keyPath]: " . $e->getMessage(), 0, $e);
        }
    }

    protected static function trimKeyPrefixes(array $params): array
    {
        $result = [];

        foreach ($params as $key => $value) {
            $cleanKey = is_string($key) ? ltrim($key, config('dsl.raw_prefix')): $key;
            $result[$cleanKey] = is_array($value)
                ? static::trimKeyPrefixes($value)
                : $value;
        }

        return $result;
    }

    /**
     * Recursively validate nested effect blocks, if defined.
     */
    protected static function validateNested(EffectDefinitionContract $definition, array $params, string $parentPath): void
    {
        $nested = $definition::nestedEffects($params);

        foreach ($nested as $slot => $effects) {
            $nestedPath = "$parentPath.$slot";
            static::_validate($effects, $nestedPath);
        }
    }
}
