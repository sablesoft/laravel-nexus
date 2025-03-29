<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Contracts\DslAdapterContract;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use RuntimeException;

readonly class CarbonDslAdapter implements DslAdapterContract
{
    public function __construct(
        protected CarbonInterface $carbon
    ) {}

    public function __get(string $name): mixed
    {
        return match ($name) {
            'year' => $this->carbon->year,
            'month' => $this->carbon->month,
            'day' => $this->carbon->day,
            'hour' => $this->carbon->hour,
            'minute' => $this->carbon->minute,
            'second' => $this->carbon->second,
            'timestamp' => $this->carbon->timestamp,
            'iso' => $this->carbon->toISOString(),
            'formatted' => $this->carbon->format('Y-m-d H:i:s'),
            'toDateString' => $this->carbon->toDateString(),
            'toTimeString' => $this->carbon->toTimeString(),
            'isToday' => $this->carbon->isToday(),
            'isPast' => $this->carbon->isPast(),
            'isFuture' => $this->carbon->isFuture(),
            default => throw new RuntimeException("Unknown property [$name] in CarbonDslAdapter."),
        };
    }

    // Difference in days between this and another date
    public function diffInDays(CarbonInterface|string|CarbonDslAdapter $other): int
    {
        $otherDate = match (true) {
            is_string($other) => Carbon::parse($other),
            $other instanceof CarbonDslAdapter => $other->raw(),
            default => $other,
        };

        return $this->carbon->diffInDays($otherDate);
    }

    // Check if the same day
    public function isSameDay(CarbonInterface|string|CarbonDslAdapter $other): bool
    {
        $otherDate = match (true) {
            is_string($other) => Carbon::parse($other),
            $other instanceof CarbonDslAdapter => $other->raw(),
            default => $other,
        };

        return $this->carbon->isSameDay($otherDate);
    }

    // Return original Carbon instance (optional)
    public function raw(): CarbonInterface
    {
        return $this->carbon;
    }
}

