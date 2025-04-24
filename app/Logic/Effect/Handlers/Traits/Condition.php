<?php

namespace App\Logic\Effect\Handlers\Traits;

use App\Logic\Facades\Dsl;
use App\Logic\Process;

trait Condition
{
    protected ?string $condition = null;

    protected function conditionParam(): string
    {
        return 'condition';
    }

    protected function prepareCondition(): void
    {
        $this->condition = $this->params[$this->conditionParam()] ?? true;
    }

    protected function shouldSkip(Process $process): bool
    {
        if (is_null($this->condition)) {
            $this->prepareCondition();
        }

        return !Dsl::evaluate($this->condition, $process->toContext());
    }
}
