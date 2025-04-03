<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `push` effect.
 * Iterates over the key-value pairs in the effect definition, resolves each value
 * using `ValueResolver::resolveWithRaw()`, and appends the result to the specified
 * path inside the process container using `$process->push(...)`.
 *
 * - Raw-prefixed keys (e.g. `!tags`) skip evaluation and push literal values.
 * - Non-prefixed keys are evaluated in context and may include DSL expressions.
 * - Target paths are treated as lists and initialized if they do not exist.
 *
 * Context:
 * - Executed via `EffectRunner` during scenario or step logic.
 * - Complements the `merge` effect for additive behavior, but always appends.
 */
class PushHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function execute(Process $process): void
    {
        foreach ($this->map as $key => $expr) {
            $value = ValueResolver::resolveWithRaw($key, $expr, $process);
            $process->push($key, $value);
        }
    }
}
