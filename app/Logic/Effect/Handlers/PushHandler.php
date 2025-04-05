<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * Runtime handler for the `push` effect.
 * Resolves and appends values to arrays inside the process container.
 * Primarily used to add new items to dynamic collections or logs during logic execution.
 *
 * Context:
 * - Registered under the DSL key `"push"` in the EffectHandlerRegistry.
 * - Paired with `PushDefinition`, which provides schema and examples.
 * - Typically used to build lists, logs, steps, and repeatable groupings in memory.
 *
 * Behavior:
 * - Each key is treated as an array path inside the process state.
 * - Each value is resolved with DSL support or passed through if raw-prefixed.
 * - `$process->push()` appends to the array or initializes it if missing.
 */
class PushHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function describeLog(Process $process): ?string
    {
        $targets = array_keys($this->map);
        return 'Pushed to: ' . implode(', ', $targets);
    }

    public function execute(Process $process): void
    {
        foreach ($this->map as $key => $expr) {
            $value = ValueResolver::resolveWithRaw($key, $expr, $process);
            $process->push($key, $value);
        }
    }
}
