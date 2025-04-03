<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class PushHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function execute(Process $process): void
    {
        foreach ($this->map as $key => $expr) {
            $value = ValueResolver::resolveWithRaw($key, $expr, $process);
            $process->push($key, $value);
        }
    }
}
