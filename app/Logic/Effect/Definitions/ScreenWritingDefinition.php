<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\VariableOrBoolRule;

class ScreenWritingDefinition implements EffectDefinitionContract
{
    public const KEY = 'screen.writing';

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
            'title' => 'Screen Writing',
            'description' => 'Shows or hide a writing pulse box under the screen messages.',
            'fields' => [],
            'examples' => [
                ['screen.writing' => 'flag'],
                ['screen.writing' => "screen.state('something') == 3"],
                ['screen.writing' => true],
                ['screen.writing' => false],
            ],
        ];
    }

    /**
     * Validation rules for accepted value types (string or array of strings).
     */
    public static function rules(): array
    {
        return [
            'value' => [new VariableOrBoolRule()],
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
