<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\VariableOrBoolRule;

class ScreenWaitingDefinition implements EffectDefinitionContract
{
    public const KEY = 'screen.waiting';

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
            'title' => 'Screen Waiting',
            'description' => 'Mark screen as waiting. Shows or hide a writing pulse box under the screen messages.',
            'fields' => [],
            'examples' => [
                ['screen.waiting' => 'flag'],
                ['screen.waiting' => "screen.state('something') == 3"],
                ['screen.waiting' => true],
                ['screen.waiting' => false],
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
