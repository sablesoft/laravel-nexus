<?php

namespace App\Logic\Traits;

use App\Logic\Contracts\SetupContract;
use Carbon\Carbon;

trait SetupStack
{
    public array $setupStack = [];
    public int $maxStack = 50;

    public function startSetup(SetupContract $setup): void
    {
        $code = $setup->getCode();
        if (in_array($code, $this->setupStack)) {
            throw new \RuntimeException("Recursive setup detected: $code, stack: ". implode(', ', $this->setupStack));
        }
        logger()->debug('[Process][Setup][Start] '. $setup->getCode() .' L'. count($this->setupStack), [
            'data' => $this->data,
        ]);
        $this->setupStack[] = $code;

        if ($this->isOverflow()) {
            throw new \RuntimeException("Setup stack overflow");
        }
    }

    public function finishSetup(SetupContract $setup): void
    {
        array_pop($this->setupStack);
        logger()->debug('[Process][Setup][Finish] '. $setup->getCode() .' L'. count($this->setupStack), [
            'data' => $this->data
        ]);
    }

    public function startLog(string $identifier): void
    {
        logger()->debug('[Process][Block][Start] ' . $identifier, [
            'data' => $this->data,
            'started_at' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
        ]);
    }

    public function stopLog(string $identifier): void
    {
        logger()->debug('[Process][Block][Stop] ' . $identifier, [
            'data' => $this->data,
            'started_at' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
            'ended_at' => $this->formatMicrotime($this->timestamps[$identifier]['end']),
            'duration_ms' => number_format(($this->executionTimes[$identifier]) * 1000, 2) . 'ms',
        ]);
    }

    protected function isOverflow(): bool
    {
        return count($this->setupStack) > $this->maxStack;
    }

    protected function formatMicrotime(float $timestamp, string $tz = 'UTC'): string
    {
        return Carbon::createFromTimestamp($timestamp, $tz)->format('Y-m-d H:i:s.v');
    }
}
