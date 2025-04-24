<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;
use App\Logic\Rules\ExpressionOrArrayRule;

/**
 * Defines the `merge.if` effect, which appends data to an existing array or map within the process container.
 * This effect is used to extend or enrich existing data structures during logic execution. The keys of the
 * definition correspond to paths in the container, and their values must evaluate to arrays or maps.
 *
 * Skip merging if condition result is false
 *
 * If a key is prefixed with one or more raw prefixes (`!`), its value is treated as a literal and not evaluated
 * as a DSL expression. This is useful when merging static data directly.
 *
 * Context:
 * - Registered under the key `"merge"` in `EffectDefinitionRegistry`.
 * - Executed by `MergeHandler`, which resolves all values via `ValueResolver::resolveWithRaw(...)` and
 *   calls `$process->merge(...)` for each target path.
 * - Useful for accumulating values like tags, logs, or attributes during a scenario.
 *
 * Examples:
 * ```yaml
 * # Merging evaluated expressions (resolve DSL on right-hand side)
 * - merge:
 *     condition: character.state('ready')
 *     values:
 *       tags: tagsArray              # value of tagsArray must be an array
 *       stats: characterStats       # merges value of characterStats into process data
 *
 * # Merging static arrays using raw key syntax (value not resolved)
 * - merge.if:
 *     condition: level > 3
 *     values:
 *       '!tags': ['stealth', 'magic']  # will be merged directly
 *       '!stats': { hp: 100, mp: 20 }  # keys with raw values added to existing "stats"
 *
 * # Mixing evaluated and raw keys
 * - merge.if:
 *     condition: exploration == true
 *     values:
 *       tags: collected_tags         # evaluated
 *       !tags: ['exploration']       # raw literal
 * ```
 */
class MergeIfDefinition implements EffectDefinitionContract
{
    public const KEY = 'merge.if';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Merge Array or Map With Condition',
            'description' => 'Appends list or key-value entries to an existing array in the process container. Both source and target must be of the same type.',
            'fields' => [
                'condition' => [
                    'type' => 'expression',
                    'description' => 'EL-expression to evaluate'
                ],
                'values' => [
                    'type' => 'expression',
                    'description' => 'Must resolve to an associative array.',
                ],
            ],
            'examples' => [
                [
                    'merge' => [
                        'condition' => 'level > 3',
                        'values' => [
                            'tags' => ['>>stealth', '>>magic'],
                            '!tags' => ['stealth', 'magic'],
                            'stats' => ['hp' => 10, 'mp' => 5]
                        ]
                    ]
                ]
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'condition' => 'required|string',
            'values' => [
                'required', new ExpressionOrArrayRule([
                    '*' => 'required'
                ])
            ]
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
