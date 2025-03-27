<?php

namespace App\Logic\Runners;

use App\Facades\SetupRunner;
use App\Logic\Contracts\CommandContract;
use App\Logic\Contracts\LogicRunnerContract;
use App\Logic\Process;

class CommandRunner implements LogicRunnerContract
{
    public function __construct(
        protected CommandContract $command
    ) {}

    public function run(Process $process): void
    {
        $process->startTimer($this->command->getCode() .'::before', $id);
        SetupRunner::run($this->command->getBefore(), $process);
        $process->stopTimer($id);

        $process->startTimer($this->command->getCode() .'::execute', $id);
        $this->command->execute($process);
        $process->stopTimer($id);

        $process->startTimer($this->command->getCode() .'::after', $id);
        SetupRunner::run($this->command->getAfter(), $process);
        $process->stopTimer($id);
    }
}
