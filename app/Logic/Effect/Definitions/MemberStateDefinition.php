<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class MemberStateDefinition implements EffectDefinitionContract
{
    public const KEY = 'member.state';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Set Member States',
            'description' => 'Assigns one or more states to one or more chat members.',
            'fields' => [
                'targets' => [
                    'type' => 'expression',
                    'description' => 'Target member(s) ID, current member will be used if targets not specified',
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
                ['member.state' => ['values' => ['has_key' => true]]],
                ['member.state' => ['target' => [1, 2], 'values' => ['hint' => 'shown']]],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'target' => 'sometimes|array',
            'values' => 'required|array',
            'values.*' => 'required', // null is not allowed
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
