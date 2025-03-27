<?php

namespace App\Logic\Contracts;

use App\Logic\Process;

interface LogicRunnerContract
{
    public function run(Process $process): void;
}
