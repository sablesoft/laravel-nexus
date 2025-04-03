<?php

namespace App\Logic\Effect\Definitions;

use App\Logic\Contracts\EffectDefinitionContract;

/**
 * Defines the `return` effect, which interrupts the current logic execution
 * and exits early from the scenario, step, or node where it is used.
 * This effect is a control mechanism to short-circuit remaining logic based on a condition.
 *
 * The `return` effect can optionally include a boolean value that determines the
 * return type:
 * - `true` (default): performs a full return from the entire logic chain (LogicContract or NodeContract).
 * - `false`: exits only the current DSL block (e.g., inside an `if`, `then`, or `else`) but allows outer logic to continue.
 *
 * Internally, this effect throws a `ReturnException`, which is first caught by `EffectRunner`,
 * and then (if not suppressed) by `NodeRunner` or `LogicRunner`, depending on the context.
 *
 * Context:
 * - Registered under the key `"return"` in `EffectDefinitionRegistry`.
 * - Executed by `ReturnHandler`, which throws a `ReturnException`.
 * - Used in conditional flows or early-exit scenarios to stop logic dynamically.
 *
 * Examples:
 * ```yaml
 * # Fully exit a scenario or nested logic block
 * - return: true
 *
 * # Exit only current step or node (outer logic will resume)
 * - return: false
 *
 * # Implicit true return
 * - return: ~
 * ```
 */
class ReturnDefinition implements EffectDefinitionContract
{
    public const KEY = 'return';

    public static function key(): string
    {
        return self::KEY;
    }

    public static function describe(): array
    {
        return [
            'title' => 'Return from Logic',
            'description' => 'Immediately stops logic execution and returns control to the parent scenario or system.',
            'fields' => [],
            'examples' => [
                ['return' => false],
                ['return' => true],
            ],
        ];
    }

    public static function rules(): array
    {
        return [
            'value' => 'sometimes|bool',
        ];
    }

    public static function nestedEffects(array $params): array
    {
        return [];
    }
}
