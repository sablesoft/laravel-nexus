<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `if` effect, which provides conditional branching within DSL logic.
 * Executes a block of `then` effects if the given boolean condition evaluates to true;
 * otherwise, an optional `else` block is executed.
 *
 * This effect enables dynamic and expressive flows within scenarios and logic steps.
 * Supports recursive validation and nesting of inner effects through `nestedEffects()`.
 *
 * Environment:
 * - Registered in `EffectDefinitionRegistry` under the key `"if"`.
 * - Executed by `IfHandler`, which interprets the condition and dispatches inner blocks.
 * - Often used at step or control level to control execution paths.
 */
class IfDefinition implements EffectDefinitionContract
{
    public const KEY = 'if';

    /**
     * Returns the DSL key that identifies this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Provides schema metadata for validation, autocomplete, and documentation.
     */
    public static function describe(): array
    {
        return [
            'title' => 'Conditional Logic',
            'description' => 'Executes `then` effects if the condition is true, otherwise executes `else` effects.',
            'fields' => [
                'condition' => [
                    'type' => 'string',
                    'description' => 'Required boolean expression to evaluate',
                ],
                'then' => [
                    'type' => 'list',
                    'description' => 'Required effects to execute if condition is true',
                ],
                'else' => [
                    'type' => 'list',
                    'description' => 'Optional effects to execute if condition is false',
                ],
            ],
            'examples' => [
                [
                    'if' => [
                        'condition' => 'score > 10',
                        'then' => [['set' => ['flag' => true]]],
                        'else' => [['unset' => ['flag']]],
                    ],
                ],
                [
                    'if' => [
                        'condition' => 'score < 10',
                        'then' => [['set' => ['looser' => true]]],
                    ],
                ],
            ],
        ];
    }

    /**
     * Validation rules for structure and required fields.
     */
    public static function rules(): array
    {
        return [
            'condition' => 'required|string',
            'then' => 'required|array',
            'then.*' => 'array|min:1',
            'else' => 'sometimes|array|min:1',
            'else.*' => 'array',
        ];
    }

    /**
     * Return nested effect blocks for recursive validation.
     */
    public static function nestedEffects(array $params): array
    {
        return [
            'then' => $params['then'],
            'else' => $params['else'] ?? [],
        ];
    }
}
