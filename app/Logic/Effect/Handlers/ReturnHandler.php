<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Exception\ReturnException;
use App\Logic\Process;

/**
 * Terminates logic execution and returns control to parent layer.
 */
class ReturnHandler implements EffectHandlerContract
{
    public function __construct(protected bool $value = true) {}

    /**
     * @throws ReturnException
     */
    public function execute(Process $process): void
    {
        throw new ReturnException($this->value);
    }
}
