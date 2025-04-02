<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;

/**
 * Runtime handler for the `unset` effect.
 * Iterates over a list of variable names and removes each from the process container.
 * This is typically used to clean up temporary state between logic steps.
 *
 * Environment:
 * - Instantiated by `EffectHandlerRegistry` for the `"unset"` key.
 * - Works with `UnsetDefinition`, which provides validation and schema metadata.
 * - Uses `$process->forget(...)` to remove variables from memory.
 */
class UnsetHandler implements EffectHandlerContract
{
    /**
     * @param array<int, string> $keys List of variable names to remove
     */
    public function __construct(protected array $keys) {}

    /**
     * Execute the unset logic for the current process.
     */
    public function execute(Process $process): void
    {
        $process->forget($this->keys);
    }
}
