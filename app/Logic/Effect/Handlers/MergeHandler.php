<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `merge` effect.
 * Iterates over all key-value pairs defined in the DSL block, resolves the value
 * using `ValueResolver::resolveWithRaw`, and merges the result into the target
 * path inside the process container.
 *
 * - Raw-prefixed keys (e.g., `!tags`) prevent evaluation and are treated as static values.
 * - Non-prefixed keys are evaluated in the current process context.
 *
 * Context:
 * - Called by `EffectRunner` during scenario or step execution.
 * - Supports both list-based and associative merges via `$process->merge(...)`.
 * - Works in tandem with `MergeDefinition` for validation and schema support.
 */
class MergeHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function execute(Process $process): void
    {
        foreach ($this->map as $path => $expr) {
            $value = ValueResolver::resolveWithRaw($path, $expr, $process);
            $process->merge($value, $path);
        }
    }
}
