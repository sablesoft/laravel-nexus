<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `set` effect, which assigns values to variables in the process container.
 * Each key in the DSL block represents a variable path, and each value is a DSL expression
 * or a literal. Values are resolved at runtime and written directly into the container.
 *
 * - Keys can be dot-notated paths (e.g., `user.score`) to assign deeply nested values.
 * - If a key is prefixed with one or more raw prefixes (`!`), the value is stored as-is and not evaluated.
 * - Otherwise, the value is passed through the DSL evaluator and supports expressions, variables, and interpolation.
 *
 * Context:
 * - Registered under the key `"set"` in `EffectDefinitionRegistry`.
 * - Executed by `SetHandler`, which uses `ValueResolver::resolveWithRaw()` for assignment.
 * - A core effect commonly used for state mutation, flags, temporary variables, etc.
 *
 * Examples:
 * ```yaml
 * # Assign constant and dynamic values
 * - set:
 *     score: 100
 *     name: user.name
 *
 * # Assign boolean literal
 * - set:
 *     flag: true
 *
 * # Assign a string with interpolation
 * - set:
 *     greeting: '>>Hello, {{ user.name }}!'
 *
 * # Assign a raw literal value without evaluation
 * - set:
 *     !config.raw: { enabled: true, level: 'debug' }
 * ```
 */
class SetDefinition implements EffectDefinitionContract
{
    public const KEY = 'set';

    /**
     * Return the DSL key that triggers this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Describe the structure and purpose of the effect for UI and validation tools.
     */
    public static function describe(): array
    {
        return [
            'title' => 'Set Variables',
            'description' => 'Assigns one or more values to process variables. Each key represents a variable name, and each value is a DSL expression or literal.',
            'fields' => [
                '*' => [
                    'type' => 'expression',
                    'description' => 'Expression or literal value to assign',
                ],
            ],
            'examples' => [
                ['set' => ['score' => 100, 'name' => 'player.name']],
                ['set' => ['flag' => true]],
            ],
        ];
    }

    /**
     * Laravel-style validation rules applied to the input map.
     */
    public static function rules(): array
    {
        return ['*' => 'nullable'];
    }

    /**
     * This effect does not support nested blocks.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
