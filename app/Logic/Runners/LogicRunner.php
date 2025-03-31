<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Facades\NodeRunner;
use App\Logic\Facades\SetupRunner;
use App\Logic\LogicJob;
use App\Logic\Process;

/**
 * LogicRunner is the centralized executor for any entity implementing the LogicContract interface,
 * along with its associated list of nodes. Currently, a typical example of a LogicContract is a
 * Scenario model, with its nodes being Step models.
 *
 * The runner's job is to determine whether the logic should be executed immediately or dispatched
 * to a queue. If immediate, it goes through all the standard execution stages in order:
 * before -> nodes -> after.
 *
 * ---
 * Environment:
 * - Accessible via the facade App\Logic\Facades\LogicRunner.
 * - Invoked by NodeRunner when executing the logic of a specific node
 * - Used internally by LogicJob to run logic restored from a queued job
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
     * Checks if the logic should be queued; if not, executes:
     * - before block via SetupRunner
     * - each node using NodeRunner
     * - after block via SetupRunner
     */
    public function runLogic(?LogicContract $logic, Process $process): Process
    {
        if (!$logic || $this->addedToQueue($logic, $process)) {
            return $process;
        }

        $process->startSetup($logic);
        $process->handle('before', $logic, fn() => SetupRunner::run($logic->getBefore(), $process));
        $process->handle('nodes', $logic, function () use ($logic, $process) {
            foreach ($logic->getNodes() as $node) {
                NodeRunner::run($node, $process);
            }
        });
        $process->handle('after', $logic, fn() => SetupRunner::run($logic->getAfter(), $process));
        $process->finishSetup($logic);

        return $process;
    }

    /**
     * Determines whether the logic should be queued.
     * If so, dispatches LogicJob and returns true, skipping the current execution path.
     */
    protected function addedToQueue(LogicContract $logic, Process $process): bool
    {
        if (!$logic->shouldQueue($process)) {
            return false;
        }

        LogicJob::dispatch($logic, $process);

        return true;
    }
}
