<?php

namespace App\Logic\Effects;

use App\Logic\Contracts\EffectContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class SetEffect implements EffectContract
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
