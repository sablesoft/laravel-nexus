<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Facades\NodeRunner;
use App\Logic\Facades\SetupRunner;
use App\Logic\LogicJob;
use App\Logic\Process;

class LogicRunner
{
    public function run(NodeContract $node, Process $process): Process
    {
        return $this->runLogic($node->getLogic(), $process);
    }

    public function runLogic(?LogicContract $logic, Process $process): Process
    {
        if (!$logic || $this->addedToQueue($logic, $process)) {
            return $process;
        }

        $process->startSetup($logic);
        $process->handle('before', $logic, fn() => SetupRunner::run($logic->getBefore(), $process));
        $process->handle('execute', $logic, fn() => $logic->execute($process));
        $process->handle('nodes', $logic, function () use ($logic, $process) {
            foreach ($logic->getNodes() as $node) {
                NodeRunner::run($node, $process);
            }
        });
        $process->handle('after', $logic, fn() => SetupRunner::run($logic->getAfter(), $process));
        $process->finishSetup($logic);

        return $process;
    }

    protected function addedToQueue(LogicContract $logic, Process $process): bool
    {
        if (!$logic->shouldQueue($process)) {
            return false;
        }

        LogicJob::dispatch($logic, $process);

        return true;
    }
}
