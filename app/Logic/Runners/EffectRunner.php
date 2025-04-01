<?php

namespace App\Logic\Runners;

use App\Logic\Effect\EffectHandlerRegistry;
use App\Logic\Process;

/**
 * Executes a sequence of DSL-defined effects in the context of a logic process.
 * This is the main runtime utility responsible for invoking effect handlers one by one.
 *
 * Environment:
 * - Uses `EffectHandlerRegistry` to resolve raw DSL blocks into executable handlers.
 * - Operates within a `Process` context, which provides runtime state and access to memory.
 * - Called from logic runners (e.g. `NodeRunner`, `SetupRunner`) to apply effects in `before`/`after` blocks.
 */
class EffectRunner
{
    /**
     * Executes a list of effects inside the given process context.
     */
    public static function run(?array $effects, Process $process): void
    {
        if (empty($effects)) {
            return;
        }

        foreach ($effects as $raw) {
            $effect = EffectHandlerRegistry::resolve($raw);
            $effect->execute($process);
        }
    }
}
