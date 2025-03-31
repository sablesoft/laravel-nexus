<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class UnsetDefinition implements EffectDefinitionContract
{
    public const KEY = 'unset';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'type' => 'list',
            'title' => 'Unset Variables',
            'description' => 'Removes one or more variables from the process context.',
            'fields' => [
                'type' => 'string',
                'description' => 'The name of the variable to forget',
            ],
            'examples' => [
                ['unset' => ['draft', 'temp', 'previous']],
            ],
        ];
    }

    public static function rules(): array
    {
        return ['*' => 'required|string'];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
