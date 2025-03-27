<?php

namespace App\Logic\Runners;

use App\Facades\SetupRunner;
use App\Facades\NodeRunner;
use App\Logic\Contracts\LogicRunnerContract;
use App\Logic\Contracts\ScenarioContract;
use App\Logic\Process;

class ScenarioRunner implements LogicRunnerContract
{
    public function __construct(
        protected ScenarioContract $scenario
    ) {}

    public function run(Process $process): void
    {
        SetupRunner::run($this->scenario->getBefore(), $process);
        foreach ($this->scenario->getNodes() as $node) {
             NodeRunner::run($node, $process);
        }
        SetupRunner::run($this->scenario->getAfter(), $process);
    }
}
