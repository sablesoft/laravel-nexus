<?php

namespace App\Models\Traits;

use App\Logic\Contracts\LogicContract;

trait HasLogic
{
    public function getLogic(): ?LogicContract
    {
        // todo - check if has command also:
        return $this->scenario;
    }
}
