<?php

namespace App\Logic\Contracts;

use App\Logic\Process;

interface CommandContract extends SetupContract
{
    public function execute(Process $process): void;
}
