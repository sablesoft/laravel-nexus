<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

/**
 * TODO - add parameter useJob and realize job for async scenarios
 * TODO - realize screen.writing for selected characters or screens
 */
class ScreenWritingHandler implements EffectHandlerContract
{
    public function __construct(
        protected string|bool $flag,
    ) {}

    public function describeLog(Process $process): ?string
    {
        return "Screen Writing";
    }

    public function execute(Process $process): void
    {
        if (!$process->screen->getKey()) {
            throw new \DomainException('Cannot use screen.back effect without screen');
        }
        $process->screenWriting = (bool) ValueResolver::resolve($this->flag, $process);
    }
}
