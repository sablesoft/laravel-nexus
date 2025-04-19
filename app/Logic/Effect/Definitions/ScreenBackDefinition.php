<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrBoolRule;

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
            'description' => 'Triggers a back transfer for current screen and character.',
            'fields' => [],
            'examples' => [
                ['screen.back' => 'flag'],
                ['screen.back' => "screen.state('something') == 3"],
                ['screen.back' => true],
                ['screen.back' => false],
            ],
        ];
    }

    /**
     * Validation rules for accepted value types (string or array of strings).
     */
    public static function rules(): array
    {
        return [
            'value' => [new ExpressionOrBoolRule()],
        ];
    }

    /**
     * This effect does not support nested logic blocks.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
