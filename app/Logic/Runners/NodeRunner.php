<?php

namespace App\Logic\Runners;

use App\Logic\Contracts\NodeContract;
use App\Logic\Facades\LogicRunner;
use App\Logic\Facades\SetupRunner;
use App\Logic\Process;

class NodeRunner
{
    public function run(NodeContract $node, Process $process): Process
    {
        $process->startSetup($node);

        $process->startBlock($node->getCode() .'::before', $id);
        SetupRunner::run($node->getBefore(), $process);
        $process->stopBlock($id);

        $process->startBlock($node->getCode() .'::run', $id);
        LogicRunner::run($node, $process);
        $process->stopBlock($id);

        $process->startBlock($node->getCode() .'::after', $id);
        SetupRunner::run($node->getAfter(), $process);
        $process->stopBlock($id);

        $process->finishSetup($node);

        return $process;
    }
}
