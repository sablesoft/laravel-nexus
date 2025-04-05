<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `merge` effect.
 * Merges resolved values into existing process arrays or maps under the specified paths.
 * Supports both indexed (list-style) and associative merges.
 *
 * Context:
 * - Registered under the key `"merge"` in the EffectHandlerRegistry.
 * - Defined structurally by `MergeDefinition`, which outlines rules and examples.
 * - Frequently used to append new entries or extend nested maps in process state.
 *
 * Behavior:
 * - Raw-prefixed keys (e.g. `!tags`) skip evaluation and are treated literally.
 * - Uses `$process->merge(...)` to ensure type-consistent appends or merges.
 */
class MergeHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function describeLog(Process $process): ?string
    {
        $targets = array_keys($this->map);
        return 'Merged into: ' . implode(', ', $targets);
    }

    public function execute(Process $process): void
    {
        foreach ($this->map as $path => $expr) {
            $value = ValueResolver::resolveWithRaw($path, $expr, $process);
            $process->merge($value, $path);
        }
    }
}
