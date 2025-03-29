<?php

namespace App\Models\Traits;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Process;

trait HasDslAdapter
{
    public function getDslAdapter(Process $process): DslAdapterContract
    {
        return new ModelDslAdapter($process, $this);
    }
}
