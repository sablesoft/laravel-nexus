<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class MergeDefinition implements EffectDefinitionContract
{
    public const KEY = 'merge';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Merge Array or Map',
            'description' => 'Appends list or key-value entries to an existing array in the process container. Both source and target must be of the same type.',
            'fields' => [
                '*' => [
                    'type' => 'expression',
                    'description' => 'Must resolve to either an indexed or associative array.',
                ],
            ],
            'examples' => [
                [
                    'merge' => [
                        'tags' => ['>>stealth', '>>magic'],
                        'stats' => ['hp' => 10, 'mp' => 5],
                    ]
                ]
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            '*' => 'required',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
