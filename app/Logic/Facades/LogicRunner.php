<?php

namespace App\Logic\Facades;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for LogicRunner service.
 *
 * @method static void run(NodeContract $node, Process $process)
 * @see \App\Logic\Runners\LogicRunner::run()
 *
 * @method static void runLogic(LogicContract $logic, Process $process)
 * @see \App\Logic\Runners\LogicRunner::runLogic()
 */
class LogicRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logic-runner';
    }
}
