<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\VariableOrArrayRule;

class ChatStateDefinition implements EffectDefinitionContract
{
    public const KEY = 'chat.state';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Set Chat States',
            'description' => 'Assigns values to one or more chat-level states. Each key is a state name, and each value is a DSL expression or literal.',
            'fields' => [
                '*' => [
                    'type' => 'expression',
                    'description' => 'DSL expression or literal value to assign to the chat state.',
                ],
            ],
            'examples' => [
                ['chat.state' => ['prologueDone' => true, 'prologue' => 1]],
                ['chat.state' => ['flag_found' => 'character.state("some_flag")']],
            ],
        ];
    }

    public static function rules(): array
    {
        return ['*' => ['required', new VariableOrArrayRule(['*' => 'required'])]];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
