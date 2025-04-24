<?php

namespace App\Logic\Traits;

use App\Logic\Contracts\HasEffectsContract;
use App\Logic\Facades\Dsl;
use Carbon\Carbon;
use RuntimeException;

trait EffectsStack
{
    protected array $effectsStack = [];
    protected int $maxStack = 50;

    protected array $effectsStarted = [];

    public function startEffects(HasEffectsContract $effects): void
    {
        $code = $effects->getCode();
        $this->effectsStarted[$code] = microtime(true);
        if (in_array($code, $this->effectsStack)) {
            throw new RuntimeException("Recursive effects detected: $code, stack: ". implode(', ', $this->effectsStack));
        }
        Dsl::debug('[Effects][Start] '. $effects->getCode() .' L'. count($this->effectsStack), [
            'data' => $this->getStorage('data'),
            'started' => $this->formatMicrotime($this->effectsStarted[$code]),
        ], 'process');
        $this->effectsStack[] = $code;

        if ($this->isOverflow()) {
            throw new RuntimeException("Setup stack overflow");
        }
    }

    public function finishEffects(HasEffectsContract $effects): void
    {
        $ended = microtime(true);
        $code = $effects->getCode();
        array_pop($this->effectsStack);
        Dsl::debug('[Effects][Finish] '. $code .' L'. count($this->effectsStack), [
            'data' => $this->getStorage('data'),
            'started' => $this->formatMicrotime($this->effectsStarted[$code]),
            'ended' => $this->formatMicrotime($ended),
            'duration' => number_format(($ended - $this->effectsStarted[$code]) * 1000, 2) . 'ms',
        ], 'process');
    }

    public function startLog(string $identifier, ?array $block): void
    {
        Dsl::debug('[Block][Start] ' . $identifier, [
            'data' => $this->getStorage('data'),
            'block' => $block,
            'started' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
        ], 'process');
    }

    public function stopLog(string $identifier, ?array $block): void
    {
        Dsl::debug('[Block][Stop] ' . $identifier, [
            'data' => $this->getStorage('data'),
            'block' => $block,
            'duration' => number_format(($this->executionTimes[$identifier]), 2) . 's',
            'started' => $this->formatMicrotime($this->timestamps[$identifier]['start']),
            'ended' => $this->formatMicrotime($this->timestamps[$identifier]['end']),
        ], 'process');
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
