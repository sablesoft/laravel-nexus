<?php

namespace App\Logic\Contracts;

use App\Logic\Process;

/**
 * Defines the contract for executing a DSL effect during logic execution.
 * Each effect has a dedicated handler that implements this interface and is called
 * during the runtime of scenarios, steps, or controls.
 *
 * Environment:
 * - Invoked by the `EffectRunner` service when executing effects.
 * - Registered via the `EffectHandlerRegistry`, which maps each DSL key
 *   to its corresponding handler class.
 * - Receives a `Process` context, which encapsulates runtime data, memory, and state.
 */

interface EffectHandlerContract
{
    /**
     * Execute this effect within the given process context.
     */
    public function execute(Process $process): void;
}

