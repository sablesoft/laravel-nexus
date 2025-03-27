<?php

namespace App\Logic\Contracts;

interface NodeContract extends SetupContract
{
    public function getCommand(): ?CommandContract;
    public function getScenario(): ?ScenarioContract;
}
