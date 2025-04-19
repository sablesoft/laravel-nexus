<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;

class ScreenStateDefinition implements EffectDefinitionContract
{
    public const KEY = 'screen.state';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Set Screen States',
            'description' => 'Assigns values to one or more screen-level states. Applies to the current screen or a list of screen codes.',
            'fields' => [
                'targets' => [
                    'type' => 'expression',
                    'description' => 'List of screen codes to target. If omitted or null, applies to the current screen.',
                ],
                'values' => [
                    'type' => 'map',
                    'description' => 'Map of state names and DSL expressions.',
                    'fields' => [
                        '*' => [
                            'type' => 'expression',
                            'description' => 'DSL expression or literal value to assign.',
                        ],
                    ],
                ],
            ],
            'examples' => [
                [
                    'screen.state' => [
                        'values' => [
                            'popup_shown' => true,
                            'choice' => 'B'
                        ]
                    ],
                ],
                [
                    'screen.state' => [
                        'targets' => ['intro', 'warning'],
                        'values' => [
                            'visited' => true
                        ]
                    ]
                ],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'targets' => ['sometimes', new ExpressionOrArrayRule(['*' => 'required|string'])],
            'values' => ['required', new ExpressionOrArrayRule(['*' => 'required'])],
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
