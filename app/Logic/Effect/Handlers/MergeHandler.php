<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class MergeHandler implements EffectHandlerContract
{
    public function __construct(protected array $map) {}

    public function execute(Process $process): void
    {
        foreach ($this->map as $path => $expr) {
            $value = ValueResolver::resolve($expr, $process);
            $process->merge($value, $path);
        }
    }
}
