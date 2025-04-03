<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `push` effect, which appends values to existing lists (indexed arrays)
 * within the process container. Each entry in the definition represents a path to
 * an array in the container and a value to be pushed at runtime.
 *
 * This effect is useful when collecting results, logging events, or incrementally
 * building a list of items during scenario execution.
 *
 * - If the key is prefixed with one or more `!`, the value is treated as a literal and not evaluated.
 * - Without prefix, the value is dynamically resolved via DSL.
 * - Target paths must refer to arrays or be auto-initialized as arrays by the process container.
 *
 * Context:
 * - Registered under the key `"push"` in `EffectDefinitionRegistry`.
 * - Executed by `PushHandler`, which resolves values using `ValueResolver::resolveWithRaw()`
 *   and calls `$process->push()` for each.
 *
 * Examples:
 * ```yaml
 * # Push static and dynamic values to arrays
 * - push:
 *     steps: '>>start'               # literal string
 *     events.log:                   # nested array structure
 *       type: '>>info'
 *       message: '>>Initialized'
 *
 * # Push a variable resolved at runtime
 * - push:
 *     messages: latest_message
 *
 * # Push raw literal value (not evaluated)
 * - push:
 *     !tags: ['combat', 'stealth']
 * ```
 */
class PushDefinition implements EffectDefinitionContract
{
    public const KEY = 'push';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Push to Array',
            'description' => 'Adds a value to the end of a list inside the process container. Target must be an indexed array.',
            'fields' => [
                '*' => [
                    'type' => 'expression',
                    'description' => 'Value to append. Must resolve to a single item.',
                ],
            ],
            'examples' => [
                [
                    'push' => [
                        'steps' => '>>start',
                        'events.log' => [
                            'type' => '>>info',
                            'message' => '>>Ready',
                        ],
                        'messages' => 'message_entry'
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
