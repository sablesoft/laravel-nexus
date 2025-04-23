<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class FunctionRunDefinition implements EffectDefinitionContract
{
    public const KEY = 'function.run';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Run Function with Effects',
            'description' => 'Executes a custom function with list of effects',
            'fields' => [
                'name' => [
                    'type' => 'expression',
                    'description' => 'Required. Either a static function name or variable with function name',
                ],
                'condition' => [
                    'type' => 'expression',
                    'description' => 'Optional. String with el-expression',
                ],
            ],
            'examples' => [
                ['run' => [
                        'name' => 'jump_action',
                        'condition' => 'character.can("jump")'
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
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
