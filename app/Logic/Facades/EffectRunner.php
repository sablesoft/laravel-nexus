<?php

namespace App\Logic\Facades;

use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for EffectRunner service.
 *
 * @method static void run(?array $config, Process $process)
 * @see \App\Logic\Runners\EffectRunner::run()
 */
class EffectRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'effect-runner';
    }
}
