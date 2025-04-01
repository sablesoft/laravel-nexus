<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `set` effect, which assigns one or more values to process variables.
 * This is one of the most fundamental DSL effects, used to mutate state within the logic flow.
 * Each field in the input map corresponds to a variable name and is assigned a value resolved
 * from a DSL expression or literal.
 *
 * Environment:
 * - Registered via `EffectDefinitionRegistry` using the key `"set"`.
 * - Executed by `SetHandler`, which stores the resolved values into the process container.
 * - Often used in `before`/`after` blocks, as well as in conditional branches.
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
        return ['*' => 'required|nullable'];
    }

    /**
     * This effect does not support nested blocks.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
