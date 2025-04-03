<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class PushDefinition implements EffectDefinitionContract
{
    public const KEY = 'push';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Push to List',
            'description' => 'Appends a value to the list at the given path in the process container. Initializes the list if it does not exist.',
            'fields' => [
                'path' => [
                    'type' => 'expression',
                    'description' => 'Dot-notated path to the target list in the process container or variable name.',
                ],
                'value' => [
                    'type' => 'expression',
                    'description' => 'Value or expression to be appended to the list.',
                ],
            ],
            'examples' => [
                [
                    'push' => [
                        'path' => '>>logs.entries',
                        'value' => [
                            'level' => 'info',
                            'message' => 'Something happened',
                        ],
                    ],
                ],
                [
                    'push' => [
                        'path' => 'steps_path',
                        'value' => 'step.name',
                    ],
                ],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'path' => 'required|string',
            'value' => 'required',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
