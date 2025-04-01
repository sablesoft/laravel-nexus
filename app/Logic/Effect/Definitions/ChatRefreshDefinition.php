<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\StringOrArrayRule;

/**
 * Defines the `chat.refresh` effect, which emits a broadcast event to refresh
 * one or more screens within the current chat. If no target is provided,
 * all connected screens will be refreshed.
 *
 * This is typically used to trigger live UI updates for other participants
 * after data changes or control interactions.
 *
 * Environment:
 * - Registered under the key `"chat.refresh"` in `EffectDefinitionRegistry`.
 * - Executed by `ChatRefreshHandler`, which broadcasts via Laravel Reverb.
 * - Supports both a single screen name or a list of screen names as input.
 */
class ChatRefreshDefinition implements EffectDefinitionContract
{
    public const KEY = 'chat.refresh';

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
            'title' => 'Refresh Chat',
            'description' => 'Triggers a chat refresh for selected screens. If parameter omitted, all screens are refreshed.',
            'fields' => [],
            'examples' => [
                ['chat.refresh' => 'screens'],
                ['chat.refresh' => ['>>main', '>>lobby']],
            ],
        ];
    }

    /**
     * Validation rules for accepted value types (string or array of strings).
     */
    public static function rules(): array
    {
        return [
            'value' => ['sometimes', 'nullable', new StringOrArrayRule([
                'value' => 'array|min:1',
                'value.*' => 'string'
            ])],
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
