<?php

namespace App\Logic\Effect\Definitions;

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class ReturnDefinition implements EffectDefinitionContract
{
    public const KEY = 'return';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Return from Logic',
            'description' => 'Immediately stops logic execution and returns control to the parent scenario or system.',
            'fields' => [],
            'examples' => [
                ['return' => false],
                ['return' => true],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'value' => 'sometimes|bool',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
