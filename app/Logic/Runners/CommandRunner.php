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
        SetupRunner::run($this->command->getBefore(), $process);
        $this->command->execute($process);
        SetupRunner::run($this->command->getAfter(), $process);
    }
}
