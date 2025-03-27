<?php

namespace App\Facades;

use App\Logic\Contracts\CommandContract;
use App\Logic\Contracts\NodeContract;
use App\Logic\Contracts\ScenarioContract;
use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for LogicRunner service.
 *
 * @method static void run(NodeContract $node, Process $process)
 * @see \App\Logic\Runners\LogicRunner::run()
 *
 * @method static void runCommand(CommandContract $command, Process $process)
 * @see \App\Logic\Runners\LogicRunner::runCommand()
 *
 * @method static void runScenario(ScenarioContract $scenario, Process $process)
 * @see \App\Logic\Runners\LogicRunner::runScenario()
 */
class LogicRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logic-runner';
    }
}
