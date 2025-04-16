<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * TODO - add parameter useJob and realize job for async scenarios
 * TODO - realize screen.back for selected characters or screens
 */
class ScreenBackHandler implements EffectHandlerContract
{
    public function __construct(
        protected string|bool $flag,
    ) {}

    public function describeLog(Process $process): ?string
    {
        return "Screen Back call";
    }

    public function execute(Process $process): void
    {
        if (!$process->screen->getKey()) {
            throw new \DomainException('Cannot use screen.back effect without screen');
        }
        $process->screenBack = (bool) ValueResolver::resolve($this->flag, $process);
    }
}
