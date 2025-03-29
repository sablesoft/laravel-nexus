<?php

namespace App\Models\Traits;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;

trait HasDslAdapter
{
    public function getDslAdapter(): DslAdapterContract
    {
        return new ModelDslAdapter($this);
    }
}
