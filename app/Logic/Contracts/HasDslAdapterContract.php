<?php

namespace App\Logic\Contracts;

interface HasDslAdapterContract
{
    public function getDslAdapter(): DslAdapterContract;
}
