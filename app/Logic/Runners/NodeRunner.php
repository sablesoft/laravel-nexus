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
        $process->handle('before', $node, fn() => SetupRunner::run($node->getBefore(), $process));
        $process->handle('logic', $node, fn() => LogicRunner::run($node, $process));
        $process->handle('after', $node, fn() => SetupRunner::run($node->getAfter(), $process));
        $process->finishSetup($node);

        return $process;
    }
}
