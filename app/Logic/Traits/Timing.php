<?php

namespace App\Logic\Traits;

trait Timing
{
    protected int $number = 0;
    protected array $timestamps = [];
    protected array $executionTimes = [];

    /**
     * @param string $code
     * @param null|string $identifier
     * @return float
     */
    public function startTimer(string $code, ?string &$identifier): float
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
     * @param bool $writeLogs
     * @return array
     */
    public function getExecutionTimes(bool $writeLogs = false): array
    {
        $times = $this->executionTimes;
        $total = 0;
        foreach ($times as $time) {
            $total += $time;
        }
        $times['total'] = $total;

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

    public function packTiming(): array
    {
        return [
            'number' => $this->number,
            'timestamps' => $this->timestamps,
            'executionTimes' => $this->executionTimes
        ];
    }

    public function unpackTiming(array $timing): void
    {
        $this->number = $timing['number'] ?? 0;
        $this->timestamps = $timing['timestamps'] ?? [];
        $this->executionTimes = $timing['executionTimes'] ?? [];
    }
}
