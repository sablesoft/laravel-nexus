<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `set` effect.
 * Assigns one or more resolved values to the process context under specified variable names.
 * All expressions are evaluated using the current process state before assignment.
 *
 * Context:
 * - Instantiated by `EffectHandlerRegistry` when resolving the `set` effect.
 * - Works in conjunction with `SetDefinition`, which defines the schema and rules.
 * - Uses `ValueResolver` to evaluate all DSL expressions or literals.
 * - Updates state through `$process->set(...)`, affecting downstream logic.
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
            $value = ValueResolver::resolve($expr, $process);
            $process->set($key, $value);
        }
    }
}
