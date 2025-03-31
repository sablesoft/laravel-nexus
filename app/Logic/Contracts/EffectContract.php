<?php

namespace App\Logic\Contracts;

use App\Logic\Process;

interface EffectContract
{
    /**
     * Execute this effect within the given process context.
     */
    public function execute(Process $process): void;
}

