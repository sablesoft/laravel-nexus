<?php

namespace App\Logic;

use App\Logic\Traits\SetupStack;
use App\Logic\Traits\Timing;
use Illuminate\Support\Arr;

class Process
{
    use Timing, SetupStack;

    protected array $data = [];
    public bool $inQueue = false;
    public bool $skipQueue = false;


    public function __construct(array $initial = [])
    {
        $this->data = $initial;
    }

    public function shouldQueue(): bool
    {
        return !$this->skipQueue && !$this->inQueue;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    public function set(string $key, mixed $value): void
    {
        Arr::set($this->data, $key, $value);
    }

    public function forget(string $key): void
    {
        Arr::forget($this->data, $key);
    }

    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    public function all(): array
    {
        return $this->data;
    }

    public function merge(array $newData): void
    {
        $this->data = array_merge($this->data, $newData);
    }

    public function toExpressionContext(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'inQueue' => $this->inQueue,
            'skipQueue' => $this->skipQueue,
            'setupStack' => $this->setupStack,
            'logs' => $this->logs,
            'times' => $this->getExecutionTimes()
            // add timing trace here if needed
        ];
    }

    public static function fromArray(array $payload): static
    {
        $self = new static($payload['data'] ?? []);
        $self->inQueue = $payload['inQueue'] ?? false;
        $self->setupStack = $payload['setupStack'] ?? [];
        $self->logs = $payload['logs'] ?? [];

        return $self;
    }
}
