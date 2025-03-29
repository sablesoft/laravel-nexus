<?php

namespace App\Logic\Facades;

use App\Logic\Contracts\NodeContract;
use App\Logic\Process;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for NodeRunner service.
 *
 * @method static Process run(NodeContract $node, Process $process)
 * @see \App\Logic\Runners\NodeRunner::run()
 */
class NodeRunner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'node-runner';
    }
}
