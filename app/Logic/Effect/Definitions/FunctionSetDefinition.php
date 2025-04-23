<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class FunctionSetDefinition implements EffectDefinitionContract
{
    public const KEY = 'function.set';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Set Function with Effects',
            'description' => 'Prepare custom function with list of effects',
            'fields' => [
                'name' => [
                    'type' => 'expression',
                    'description' => 'Required. Either a static function name or variable with function name',
                ],
                'condition' => [
                    'type' => 'expression',
                    'description' => 'Optional. String with el-expression',
                ],
                'effects' => [
                    'type' => 'array',
                    'description' => 'Required. Array with function effects',
                ],
            ],
            'examples' => [
                ['run' => [
                        'name' => 'jump_action',
                        'condition' => 'character.can("jump")',
                        'effects' => [
                            ['comment' => 'List of effects there']
                        ]
                    ]
                ],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'name' => 'required|string',
            'condition' => 'sometimes|nullable|string',
            'effects' => 'required|array|min:1',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return $params['effects'];
    }
}
