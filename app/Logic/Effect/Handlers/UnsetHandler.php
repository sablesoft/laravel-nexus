<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;

/**
 * Runtime handler for the `unset` effect.
 * Removes one or more variables from the process state.
 * Often used to clean up temporary or intermediate values between logic steps.
 *
 * Context:
 * - Registered under the key `"unset"` in the EffectHandlerRegistry.
 * - Defined structurally by `UnsetDefinition`, which allows an array of variable names.
 * - Uses `$process->forget(...)` for mutation.
 *
 * Behavior:
 * - Accepts an array of variable names (strings).
 * - Deletes each from the current process memory.
 */
class UnsetHandler implements EffectHandlerContract
{
    /**
     * @param array<int, string> $keys List of variable names to remove
     */
    public function __construct(protected array $keys) {}

    public function describeLog(Process $process): ?string
    {
        return 'Unset variables: ' . implode(', ', $this->keys);
    }

    /**
     * Execute the unset logic for the current process.
     */
    public function execute(Process $process): void
    {
        $process->forget($this->keys);
    }
}
