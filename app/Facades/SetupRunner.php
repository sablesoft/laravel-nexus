<?php

namespace App\Facades;

use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for SetupRunner service.
 *
 * @method static void run(?array $config, Process $process)
 * @see \App\Logic\Runners\SetupRunner::run()
 */
class SetupRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'setup-runner';
    }
}
