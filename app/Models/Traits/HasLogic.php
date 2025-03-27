<?php

namespace App\Models\Traits;

use App\Logic\Contracts\CommandContract;
use App\Logic\Contracts\ScenarioContract;

trait HasLogic
{
    public function getCommand(): ?CommandContract
    {
        return null; // todo
    }

    public function getScenario(): ?ScenarioContract
    {
        return $this->scenario;
    }
}
