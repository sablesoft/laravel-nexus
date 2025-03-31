<?php

namespace App\Logic\Facades;

use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for EffectsRunner service.
 *
 * @method static void run(?array $config, Process $process)
 * @see \App\Logic\Runners\EffectsRunner::run()
 */
class EffectsRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'effects-runner';
    }
}
