<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * TODO - realize screen.waiting for selected characters or screens
 */
class ScreenWaitingHandler implements EffectHandlerContract
{
    public function __construct(
        protected string|bool $flag,
    ) {}

    public function describeLog(Process $process): ?string
    {
        return "Screen Waiting";
    }

    public function execute(Process $process): void
    {
        if (!$process->screen->getKey()) {
            throw new \DomainException('Cannot use screen.waiting effect without screen');
        }
        $process->screenWaiting = (bool) ValueResolver::resolve($this->flag, $process);
    }
}
