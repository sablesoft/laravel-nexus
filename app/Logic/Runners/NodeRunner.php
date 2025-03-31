<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\NodeContract;
use App\Logic\Facades\LogicRunner;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;

/**
 * NodeRunner is responsible for executing a logic node (NodeContract),
 * which can either be an interface element (Control or Transfer models) on the screen (Screen model),
 * or a step (Step model) inside a scenario (Scenario model).
 *
 * Each node is executed in the following sequence: before -> logic -> after.
 * Any of these blocks may be missing. The before and after blocks are user-defined DSL instructions
 * that can manipulate global system state.
 *
 * The core logic block (logic), if present, is delegated to LogicRunner.
 * This allows a node to act as a wrapper around a full LogicContract entity
 * (e.g. each Step may embed a nested Scenario; similarly, a Control button or input
 *  may launch a complex scenario with multiple steps).
 *
 * ---
 * Environment:
 * - Accessible via the facade App\Logic\Facades\NodeRunner
 * - Called from App\Livewire\Chat\Play when executing control logic on a screen
 * - Invoked by LogicRunner when iterating through a logic’s node list via logic.getNodes()
 */
class NodeRunner
{
    /**
     * Executes the given node: runs through before -> logic -> after phases using the provided Process.
     */
    public function run(NodeContract $node, Process $process): Process
    {
        $process->startEffects($node);
        $process->handle('before', $node, fn() => EffectRunner::run($node->getBefore(), $process));
        if ($node->getLogic()) {
            $process->handle('logic', $node, fn() => LogicRunner::run($node, $process));
            $process->handle('after', $node, fn() => EffectRunner::run($node->getAfter(), $process));
        }
        $process->finishEffects($node);

        return $process;
    }
}
