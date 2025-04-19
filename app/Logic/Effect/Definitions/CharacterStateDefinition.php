<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;

class CharacterStateDefinition implements EffectDefinitionContract
{
    public const KEY = 'character.state';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Set Character States',
            'description' => 'Assigns one or more states to one or more characters.',
            'fields' => [
                'targets' => [
                    'type' => 'expression',
                    'description' => 'Target character(s) ID, current character will be used if targets not specified',
                ],
                'values' => [
                    'type' => 'map',
                    'description' => 'Map of state names and DSL expressions.',
                    'fields' => [
                        '*' => [
                            'type' => 'expression',
                            'description' => 'DSL expression or literal value to assign',
                        ]
                    ]
                ],
            ],
            'examples' => [
                ['character.state' => ['values' => ['has_key' => true]]],
                ['character.state' => ['target' => [1, 2], 'values' => ['hint' => 'shown']]],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'target' => ['sometimes', new ExpressionOrArrayRule(['*' => 'required|int'])],
            'values' => ['required', new ExpressionOrArrayRule(['*' => 'required'])],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
