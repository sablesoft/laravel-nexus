<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Handlers\Traits\Condition;
use App\Logic\Process;

/**
 * Runtime handler for the `merge.if` effect.
 * Merges resolved values into existing process arrays or maps under the specified paths.
 * Skip merging if condition result is false
 * Supports both indexed (list-style) and associative merges.
 *
 * Context:
 * - Registered under the key `merge.if` in the EffectHandlerRegistry.
 * - Defined structurally by `MergeIfDefinition`, which outlines rules and examples.
 * - Frequently used to append new entries or extend nested maps in process state.
 *
 * Behavior:
 * - Raw-prefixed keys (e.g. `!tags`) skip evaluation and are treated literally.
 * - Uses `$process->merge(...)` to ensure type-consistent appends or merges.
 */
class MergeIfHandler implements EffectHandlerContract
{
    use Condition;

    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        $targets = array_keys($this->params['values']);
        return 'Merged into: ' . implode(', ', $targets);
    }

    public function execute(Process $process): void
    {
        if ($this->shouldSkip($process)) {
            return;
        }

        foreach ($this->params['values'] as $path => $expr) {
            // todo - remove raw feature:
            $value = ValueResolver::resolveWithRaw($path, $expr, $process);
            $process->merge($value, $path);
        }
    }
}
