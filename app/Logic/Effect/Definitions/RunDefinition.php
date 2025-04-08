<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class RunDefinition implements EffectDefinitionContract
{
    public const KEY = 'run';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Run Effects Block',
            'description' => 'Executes a list of effects, either passed directly or resolved from a variable.',
            'fields' => [
                '*' => [
                    'type' => 'any',
                    'description' => 'Either a string path to effects or an array of inline effects.',
                ],
            ],
            'examples' => [
                ['run' => 'array_get("handlers.jump")'],
                ['run' => 'handlers[action]'],
            ],
        ];
    }

    public static function rules(): array
    {
        return ['*' => 'array|string'];
    }

    public static function nestedEffects(array $params): array
    {
        // Optional optimization: if inline block is detected, return it for validation
        if (is_array($params)) {
            $first = array_key_first($params);
            $value = $params[$first] ?? null;
            if (is_array($value) && array_is_list($value)) {
                return [$first => $value];
            }
        }

        return [];
    }
}
