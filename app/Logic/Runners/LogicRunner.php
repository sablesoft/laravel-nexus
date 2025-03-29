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

        $process->startLog($logic);

        $process->startTimer($logic->getCode() .'::before', $id);
        SetupRunner::run($logic->getBefore(), $process);
        $process->stopTimer($id);

        $process->startTimer($logic->getCode() .'::execute', $id);
        $logic->execute($process);
        $process->stopTimer($id);

        $process->startTimer($logic->getCode() .'::nodes', $id);
        foreach ($logic->getNodes() as $node) {
            NodeRunner::run($node, $process);
        }
        $process->stopTimer($id);

        $process->startTimer($logic->getCode() .'::after', $id);
        SetupRunner::run($logic->getAfter(), $process);
        $process->stopTimer($id);

        $process->finishLog();

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
