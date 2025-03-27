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
        $process->startTimer($this->scenario->getCode() .'::before', $id);
        SetupRunner::run($this->scenario->getBefore(), $process);
        $process->stopTimer($id);

        $process->startTimer($this->scenario->getCode() .'::nodes', $id);
        foreach ($this->scenario->getNodes() as $node) {
             NodeRunner::run($node, $process);
        }
        $process->stopTimer($id);

        $process->startTimer($this->scenario->getCode() .'::after', $id);
        SetupRunner::run($this->scenario->getAfter(), $process);
        $process->stopTimer($id);
    }
}
