<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class PushHandler implements EffectHandlerContract
{
    public function __construct(
        protected array $params
    ) {}

    public function execute(Process $process): void
    {
        $params = ValueResolver::resolve($this->params, $process);
        $process->push($params['path'], $params['value']);
    }
}

