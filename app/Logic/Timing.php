<?php

namespace App\Logic;

use Laravel\Telescope\Telescope;

trait Timing
{
    protected int $number = 0;
    protected array $timestamps = [];
    protected array $executionTimes = [];

    /**
     * @param string $code
     * @param string $identifier
     * @return float
     */
    public function startTimer(string $code, string &$identifier): float
    {
        $this->number++;
        $identifier = $this->number . ') '. $code;
        return $this->timestamps[$identifier]['start'] = microtime(true);
    }

    /**
     * @param string $identifier
     * @return null|float
     */
    public function stopTimer(string $identifier): ?float
    {
        if (empty($this->timestamps[$identifier]['start'])) {
            return null;
        }
        $this->timestamps[$identifier]['end'] = microtime(true);
        $this->executionTimes[$identifier] =
            $this->timestamps[$identifier]['end'] - $this->timestamps[$identifier]['start'];

        return $this->timestamps[$identifier]['end'];
    }

    /**
     * @param bool $withTotal
     * @return array
     */
    public function getExecutionTimes(bool $withTotal = false): array
    {
        $times = $this->executionTimes;
        if ($withTotal) {
            $total = 0;
            foreach ($times as $time) {
                $total += $time;
            }
            $times['total'] = $total;
        }

        if (app()->environment('local') && class_exists(Telescope::class)) {
            $this->logExecutionTimesToTelescope($times);
        }

        return $times;
    }

    /**
     * @param string $identifier
     * @return null|float
     */
    public function getExecutionTime(string $identifier): ?float
    {
        return $this->executionTimes[$identifier] ?? null;
    }

    protected function logExecutionTimesToTelescope(array $times): void
    {
        foreach ($times as $label => $time) {
            \Log::info('[Timing] ' . $label . ': ' . round($time * 1000, 2) . ' ms');
        }
    }
}
