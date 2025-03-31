<?php

namespace App\Logic\Runners;

use App\Logic\Effect\EffectHandlerRegistry;
use App\Logic\Process;

class EffectRunner
{
    public static function run(?array $effects, Process $process): void
    {
        if (empty($effects)) {
            return;
        }

        foreach ($effects as $raw) {
            $effect = EffectHandlerRegistry::resolve($raw);
            $effect->execute($process);
        }
    }
}
