<?php

namespace App\Logic;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Traits\SetupStack;
use App\Logic\Traits\Timing;
use App\Models\Application;
use App\Models\Chat;
use App\Models\Member;
use App\Models\Screen;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Process
{
    use Timing, SetupStack;

    protected array $data = [];
    protected array $adapters = [];

    public bool $inQueue = false;
    public bool $skipQueue = false;

    public readonly DslAdapterContract $chat;
    public readonly DslAdapterContract $screen;
    public readonly DslAdapterContract $member;
    public readonly DslAdapterContract $application;

    protected array $main = [
        'chat'          => Chat::class,
        'screen'        => Screen::class,
        'member'        => Member::class,
        'application'   => Application::class,
    ];

    public function __construct(array $initial = [])
    {
        foreach ($this->main as $main => $modelClass) {
            $model = $initial[$main] ?? new $modelClass();
            if (!($model instanceof $modelClass)) {
                throw new InvalidArgumentException("Invalid model for slot [$main], expected instance of [$modelClass].");
            }
            $this->{$main} = ($model instanceof HasDslAdapterContract) ?
                $model->getDslAdapter($this) :
                 new ModelDslAdapter($this, $model);

            unset($initial[$main]);
        }

        foreach ($initial as $key => $value) {
            if ($value instanceof HasDslAdapterContract) {
                $this->adapters[$key] = $value->getDslAdapter($this);
                unset($initial[$key]);
            }
        }

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

    public function toContext(): array
    {
        $context = [];
        foreach ($this->adapters as $key => $adapter) {
            $context[$key] = $adapter;
        }
        foreach (array_keys($this->main) as $main) {
            $context[$main] = $this->{$main};
        }

        return array_merge($this->data, $context);
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'inQueue' => $this->inQueue,
            'skipQueue' => $this->skipQueue,
            'setupStack' => $this->setupStack,
            'logs' => $this->logs,
            'times' => $this->getExecutionTimes(),
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
