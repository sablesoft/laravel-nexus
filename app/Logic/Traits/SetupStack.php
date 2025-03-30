<?php

namespace App\Logic\Traits;

use App\Logic\Contracts\SetupContract;
use Carbon\Carbon;

trait SetupStack
{
    protected array $setupStack = [];
    protected int $maxStack = 50;

    protected ?float $setupStarted = null;

    public function startSetup(SetupContract $setup): void
    {
        $this->setupStarted = microtime(true);
        $code = $setup->getCode();
        if (in_array($code, $this->setupStack)) {
            throw new \RuntimeException("Recursive setup detected: $code, stack: ". implode(', ', $this->setupStack));
        }
        logger()->debug('[Process][Setup][Start] '. $setup->getCode() .' L'. count($this->setupStack), [
            'data' => $this->data,
            'started' => $this->formatMicrotime($this->setupStarted),
        ]);
        $this->setupStack[] = $code;

        if ($this->isOverflow()) {
            throw new \RuntimeException("Setup stack overflow");
        }
    }

    public function finishSetup(SetupContract $setup): void
    {
        $ended = microtime(true);
        array_pop($this->setupStack);
        logger()->debug('[Process][Setup][Finish] '. $setup->getCode() .' L'. count($this->setupStack), [
            'data' => $this->data,
            'started' => $this->formatMicrotime($this->setupStarted),
            'ended' => $this->formatMicrotime($ended),
            'duration' => number_format(($ended - $this->setupStarted) * 1000, 2) . 'ms',
        ]);
        $this->setupStarted = null;
    }

    public function startLog(string $identifier, ?array $block): void
    {
        logger()->debug('[Process][Block][Start] ' . $identifier, [
            'data' => $this->data,
            'block' => $block,
            'started' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
        ]);
    }

    public function stopLog(string $identifier, ?array $block): void
    {
        logger()->debug('[Process][Block][Stop] ' . $identifier, [
            'data' => $this->data,
            'block' => $block,
            'duration' => number_format(($this->executionTimes[$identifier]), 2) . 's',
            'started' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
            'ended' => $this->formatMicrotime($this->timestamps[$identifier]['end']),
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
