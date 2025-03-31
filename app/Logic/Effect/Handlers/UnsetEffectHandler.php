<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;

class UnsetEffectHandler implements EffectHandlerContract
{
    /**
     * @param array<int, string> $keys
     */
    public function __construct(protected array $keys) {}

    public function execute(Process $process): void
    {
        foreach ($this->keys as $key) {
            $process->forget($key);
        }
    }
}

