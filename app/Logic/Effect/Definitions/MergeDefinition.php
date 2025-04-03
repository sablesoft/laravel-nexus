<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `merge` effect, which appends data to an existing array or map within the process container.
 * This effect is used to extend or enrich existing data structures during logic execution. The keys of the
 * definition correspond to paths in the container, and their values must evaluate to arrays or maps.
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
 *     tags: user.tags              # value of user.tags must be an array
 *     stats: character.stats       # merges value of character.stats into process["stats"]
 *
 * # Merging static arrays using raw key syntax (value not resolved)
 * - merge:
 *     !tags: ['stealth', 'magic']  # will be merged directly
 *     !stats: { hp: 100, mp: 20 }  # keys with raw values added to existing "stats"
 *
 * # Mixing evaluated and raw keys
 * - merge:
 *     tags: collected_tags         # evaluated
 *     !tags: ['exploration']       # raw literal
 * ```
 */
class MergeDefinition implements EffectDefinitionContract
{
    public const KEY = 'merge';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Merge Array or Map',
            'description' => 'Appends list or key-value entries to an existing array in the process container. Both source and target must be of the same type.',
            'fields' => [
                '*' => [
                    'type' => 'expression',
                    'description' => 'Must resolve to either an indexed or associative array.',
                ],
            ],
            'examples' => [
                [
                    'merge' => [
                        'tags' => ['>>stealth', '>>magic'],
                        '!tags' => ['stealth', 'magic'],
                        'stats' => ['hp' => 10, 'mp' => 5],
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
