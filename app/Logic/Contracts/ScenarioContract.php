<?php

namespace App\Logic\Contracts;

use Illuminate\Support\Collection;

interface ScenarioContract extends SetupContract
{
    /**
     * @return Collection<int, NodeContract> 
     */
    public function getNodes(): Collection;
}
