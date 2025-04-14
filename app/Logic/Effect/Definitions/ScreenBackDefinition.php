<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

class ScreenBackDefinition implements EffectDefinitionContract
{
    public const KEY = 'screen.back';

    /**
     * Returns the DSL key that identifies this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Describes the structure and usage of the effect for the editor and validators.
     */
    public static function describe(): array
    {
        return [
            'title' => 'Screen Back',
            'description' => 'Triggers a back transfer for current screen and member.',
            'fields' => [],
            'examples' => [
                ['screen.back' => null],
            ],
        ];
    }

    /**
     * Validation rules for accepted value types (string or array of strings).
     */
    public static function rules(): array
    {
        return [];
    }

    /**
     * This effect does not support nested logic blocks.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
