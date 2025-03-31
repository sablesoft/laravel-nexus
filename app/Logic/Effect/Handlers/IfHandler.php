<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;

class IfHandler implements EffectHandlerContract
{
    public function __construct(protected array $params) {}

    public function execute(Process $process): void
    {
        $condition = $this->params['condition'];
        $context = $process->toContext();

        if (!Dsl::evaluate($condition, $context)) {
            if (!empty($this->params['else'])) {
                EffectRunner::run($this->params['else'], $process);
            }
            return;
        }

        EffectRunner::run($this->params['then'], $process);
    }
}
