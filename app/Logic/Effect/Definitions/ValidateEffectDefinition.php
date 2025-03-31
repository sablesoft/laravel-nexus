<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class ValidateEffectDefinition implements EffectDefinitionContract
{
    public const KEY = 'validate';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'type' => 'map',
            'title' => 'Validate Data',
            'description' => 'Applies validation rules to the current process data. Throws a validation error on failure.',
            'fields' => [
                '*' => [
                    'type' => 'string',
                    'description' => 'Validation rule string (e.g. "required|email")',
                ],
            ],
            'examples' => [
                ['validate' => ['email' => 'required|email', 'age' => 'integer|min:18']],
            ],
        ];
    }
}
