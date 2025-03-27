<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\NodeContract;
use App\Logic\Facades\LogicRunner;
use App\Logic\Facades\SetupRunner;
use App\Logic\Process;

class NodeRunner
{
    public function run(NodeContract $node, Process $process): void
    {
        $process->startLog($node);

        $process->startTimer($node->getCode() .'::before', $id);
        SetupRunner::run($node->getBefore(), $process);
        $process->stopTimer($id);

        $process->startTimer($node->getCode() .'::run', $id);
        LogicRunner::run($node, $process);
        $process->stopTimer($id);

        $process->startTimer($node->getCode() .'::after', $id);
        SetupRunner::run($node->getAfter(), $process);
        $process->stopTimer($id);

        $process->finishLog();
    }
}
