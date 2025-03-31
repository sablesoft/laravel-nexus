<?php

namespace App\Logic\Effects;

use App\Logic\Contracts\EffectContract;
use App\Logic\Process;

class UnsetEffect implements EffectContract
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

