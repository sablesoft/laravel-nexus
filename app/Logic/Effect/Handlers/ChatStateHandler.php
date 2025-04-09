<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class ChatStateHandler implements EffectHandlerContract
{
    /**
     * @param array<string, mixed> $states Key-value map of state names and values
     */
    public function __construct(protected array $states) {}

    public function describeLog(Process $process): ?string
    {
        $keys = array_keys($this->states);
        return 'Set chat states: ' . implode(', ', $keys);
    }

    public function execute(Process $process): void
    {
        foreach ($this->states as $key => $expression) {
            $value = ValueResolver::resolve($key, $expression);
            $process->chat->setState($key, $value);
        }
    }
}
