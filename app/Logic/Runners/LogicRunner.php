<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Exception\ReturnException;
use App\Logic\Facades\NodeRunner;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;

/**
 * LogicRunner is the centralized executor for any entity implementing the LogicContract interface,
 * along with its associated list of nodes. Currently, a typical example of a LogicContract is a
 * Scenario model, with its nodes being Step models.
 *
 * The runner goes through all the standard execution stages in order:
 * before -> nodes -> after.
 *
 * ---
 * Context:
 * - Accessible via the facade App\Logic\Facades\LogicRunner.
 * - Invoked by NodeRunner when executing the logic of a specific node
 * - Supports recursive logic execution, since each node can contain its own nested logic
 * - TODO: Will be callable by the user via a special UI actions (debug or manual execution for various purposes)
 */
class LogicRunner
{
    /**
     * Executes the logic attached to a node, if available.
     */
    public function run(NodeContract $node, Process $process): Process
    {
        return $this->runLogic($node->getLogic(), $process);
    }

    /**
     * Main method for running logic.
     * Executes:
     * - before effects via EffectRunner
     * - each node using NodeRunner
     * - after effects via EffectRunner
     * @noinspection PhpRedundantCatchClauseInspection
     */
    public function runLogic(?LogicContract $logic, Process $process): Process
    {
        if (!$logic) {
            return $process;
        }

        $process->startEffects($logic);
        try {
            $process->node = $logic;
            $process->handle('before', $logic, fn() => EffectRunner::run($logic->getBefore(), $process));
            if($logic->getNodes()) {
                $process->handle('nodes', $logic, function () use ($logic, $process) {
                    foreach ($logic->getNodes() as $node) {
                        $process->node = $node;
                        NodeRunner::run($node, $process);
                    }
                });
                $process->node = $logic;
                $process->handle('after', $logic, fn() => EffectRunner::run($logic->getAfter(), $process));
            }
        } catch (ReturnException $e) {
            logger()->debug('[NodeRunner] Return', [
                'node' => $logic->getCode(),
                'process' => $process->pack(),
                'return' => $e->getValue()
            ]);
        }
        $process->finishEffects($logic);

        return $process;
    }
}
