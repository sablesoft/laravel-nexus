<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `set` effect.
 * Assigns resolved values to variables inside the process container.
 *
 * Context:
 * - Registered under the key `"set"` in the EffectHandlerRegistry.
 * - Driven by `SetDefinition`, which defines structure and schema.
 * - Used for variable assignment, flags, and temporary state changes during execution.
 *
 * Behavior:
 * - Resolves each value in context (unless marked as raw with `!` prefix).
 * - Supports dot-notation keys for nested assignments.
 * - Stores results using `$process->set(...)`.
 */
class SetHandler implements EffectHandlerContract
{
    /**
     * @param array<string, mixed> $vars Key-value pairs from the effect block
     */
    public function __construct(protected array $vars) {}

    public function describeLog(Process $process): ?string
    {
        $keys = array_keys($this->vars);
        return 'Set variables: ' . implode(', ', $keys);
    }

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
