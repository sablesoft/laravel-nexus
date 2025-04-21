<?php

namespace App\Logic\Effect\Handlers\Traits;

use App\Logic\EffectJob;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use Illuminate\Support\Arr;

trait Async
{
    protected function isAsync(Process $process, string $effectKey): bool
    {
        if (empty($this->params['async'])) {
            return false;
        }
        $async = (bool) Dsl::evaluate($this->params['async'], $process->toContext());
        if (!$async) {
            return false;
        }

        EffectJob::dispatch(
            $effectKey,
            Arr::except($this->params, ['async']),
            $process
        );
        Dsl::debug("[$effectKey] sent to async", [
            'params' => $this->params,
            'process' => $process->pack()
        ], 'effect');

        return true;
    }
}
