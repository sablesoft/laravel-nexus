<?php

namespace App\Logic\Contracts;

interface NodeContract extends SetupContract
{
    public function getLogic(): ?LogicContract;
}
