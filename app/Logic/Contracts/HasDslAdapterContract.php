<?php

namespace App\Logic\Contracts;

use App\Logic\Process;

interface HasDslAdapterContract
{
    public function getDslAdapter(Process $process): DslAdapterContract;
}
