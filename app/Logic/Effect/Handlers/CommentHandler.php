<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;

class CommentHandler implements EffectHandlerContract
{
    public function __construct(protected string $value) {}

    public function execute(Process $process): void
    {
        // Does nothing. Reserved for annotations or future debug/log.
    }
}
