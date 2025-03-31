<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class SetEffectHandler implements EffectHandlerContract
{
    public function __construct(protected array $vars) {}

    public function execute(Process $process): void
    {
        foreach ($this->vars as $key => $expr) {
            $value = ValueResolver::resolve($expr, $process);
            $process->set($key, $value);
        }
    }
}
