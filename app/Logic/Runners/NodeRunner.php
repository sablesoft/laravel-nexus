<?php

namespace App\Logic\Runners;

use App\Facades\LogicRunner;
use App\Facades\SetupRunner;
use App\Logic\Contracts\NodeContract;
use App\Logic\Process;

class NodeRunner
{
    public function run(NodeContract $node, Process $process): void
    {
        SetupRunner::run($node->getBefore(), $process);
        LogicRunner::run($node, $process);
        SetupRunner::run($node->getAfter(), $process);
    }
}
