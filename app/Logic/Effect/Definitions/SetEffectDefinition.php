<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class SetEffectDefinition implements EffectDefinitionContract
{
    public const KEY = 'set';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'type' => 'map',
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
}
