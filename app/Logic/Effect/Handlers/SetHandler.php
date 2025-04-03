<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `set` effect.
 * Iterates over key-value pairs from the DSL definition, resolves each value using
 * `ValueResolver::resolveWithRaw()`, and assigns the result into the process container
 * using `$process->set(...)`.
 *
 * - Keys represent variable paths (can be nested using dot notation).
 * - If a key starts with the raw prefix (`!`), the value is used directly without evaluation.
 * - Otherwise, expressions, variables, and interpolated strings are resolved dynamically.
 *
 * Context:
 * - Called by `EffectRunner` when executing a step, control, or scenario.
 * - Provides a fundamental mechanism for variable mutation and state tracking.
 */
class SetHandler implements EffectHandlerContract
{
    /**
     * @param array<string, mixed> $vars Key-value pairs from the effect block
     */
    public function __construct(protected array $vars) {}

    /**
     * Execute the effect in the current process context.
     *
     * Each key is a variable name, and its associated value is resolved using DSL evaluation.
     */
    public function execute(Process $process): void
    {
        foreach ($this->vars as $key => $expr) {
            $value = ValueResolver::resolveWithRaw($key, $expr, $process);
            $process->set($key, $value);
        }
    }
}
