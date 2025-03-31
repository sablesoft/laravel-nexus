<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class IfDefinition implements EffectDefinitionContract
{
    public const KEY = 'if';

    public static function key(): string
    {
        return self::KEY;
    }

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

    public static function rules(): array
    {
        return [
            'condition' => 'required|string',
            'then' => 'required|array',
            'then.*' => 'array',
            'else' => 'sometimes|array',
            'else.*' => 'array',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [
            'then' => $params['then'],
            'else' => $params['else'] ?? [],
        ];
    }
}
