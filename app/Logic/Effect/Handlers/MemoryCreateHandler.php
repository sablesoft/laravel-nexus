<?php

namespace App\Logic\Effect\Handlers;

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Memory;

class MemoryCreateHandler implements EffectHandlerContract
{
    public function __construct(protected array $params) {}

    public function execute(Process $process): void
    {
        $params = ValueResolver::resolve($this->params, $process);
        $type = $params['type'] ?? $process->screen->code();
        $data = $params['data'];
        $data['type'] = $type;
        $data['chat_id'] = $process->chat->id();

        Memory::create($data);
    }
}
