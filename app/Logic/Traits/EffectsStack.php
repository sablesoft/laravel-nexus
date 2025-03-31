<?php

namespace App\Logic\Traits;

use App\Logic\Contracts\HasEffectsContract;
use Carbon\Carbon;

trait EffectsStack
{
    protected array $effectsStack = [];
    protected int $maxStack = 50;

    protected ?float $setupStarted = null;

    public function startEffects(HasEffectsContract $effects): void
    {
        $this->setupStarted = microtime(true);
        $code = $effects->getCode();
        if (in_array($code, $this->effectsStack)) {
            throw new \RuntimeException("Recursive effects detected: $code, stack: ". implode(', ', $this->effectsStack));
        }
        logger()->debug('[Process][Effects][Start] '. $effects->getCode() .' L'. count($this->effectsStack), [
            'data' => $this->data,
            'started' => $this->formatMicrotime($this->setupStarted),
        ]);
        $this->effectsStack[] = $code;

        if ($this->isOverflow()) {
            throw new \RuntimeException("Setup stack overflow");
        }
    }

    public function finishEffects(HasEffectsContract $effects): void
    {
        $ended = microtime(true);
        array_pop($this->effectsStack);
        logger()->debug('[Process][Effects][Finish] '. $effects->getCode() .' L'. count($this->effectsStack), [
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
        return count($this->effectsStack) > $this->maxStack;
    }

    protected function formatMicrotime(float $timestamp, string $tz = 'UTC'): string
    {
        return Carbon::createFromTimestamp($timestamp, $tz)->format('Y-m-d H:i:s.v');
    }
}
