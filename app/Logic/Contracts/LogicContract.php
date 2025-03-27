<?php

namespace App\Logic\Contracts;

use App\Logic\Process;
use Illuminate\Support\Collection;

interface LogicContract extends SetupContract
{
    public function execute(Process $process): void;

    /**
     * @return Collection<int, NodeContract>
     */
    public function getNodes(): Collection;

    public function shouldQueue(Process $process): bool;
}
