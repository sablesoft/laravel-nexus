<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\VariableOrArrayRule;

/**
 * Defines the `unset` effect, which removes one or more variables from the process context.
 * This is useful for clearing temporary or intermediate state between steps or branches.
 * Accepts a list of variable names to delete from the internal data container.
 *
 * Environment:
 * - Registered in `EffectDefinitionRegistry` under the key `"unset"`.
 * - Executed by `UnsetHandler`, which performs the deletion using `$process->forget(...)`.
 * - Used in steps, controls, or scenarios that need to reset part of the process state.
 */
class UnsetDefinition implements EffectDefinitionContract
{
    public const KEY = 'unset';

    /**
     * Returns the DSL key for this effect.
     */
    public static function key(): string
    {
        return self::KEY;
    }

    /**
     * Returns schema metadata for documentation, autocomplete, and validation.
     */
    public static function describe(): array
    {
        return [
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

    /**
     * Returns validation rules for compile-time checking.
     */
    public static function rules(): array
    {
        return [
            'value' => ['required', new VariableOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => 'string',
            ])],
        ];
    }

    /**
     * This effect does not support nested blocks.
     */
    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
