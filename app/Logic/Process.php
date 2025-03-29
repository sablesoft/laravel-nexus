<?php

namespace App\Logic;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Dsl\Adapters\ModelDslAdapter;
use App\Logic\Traits\SetupStack;
use App\Logic\Traits\Timing;
use App\Models\Chat;
use App\Models\Member;
use App\Models\Memory;
use App\Models\Screen;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Process
{
    use Timing, SetupStack;

    protected array $data = [];
    public bool $inQueue = false;
    public bool $skipQueue = false;

    public readonly DslAdapterContract $chat;
    public readonly DslAdapterContract $memory;
    public readonly DslAdapterContract $screen;
    public readonly DslAdapterContract $member;

    protected array $adapters = [
        'chat'          => Chat::class,
        'screen'        => Screen::class,
        'memory'        => Memory::class,
        'member'        => Member::class,
    ];

    public function __construct(array $initial = [])
    {
        foreach ($this->adapters as $key => $modelClass) {
            $model = $initial[$key] ?? new $modelClass();
            if (!($model instanceof $modelClass)) {
                throw new InvalidArgumentException("Invalid model [$key], expected instance of [$modelClass].");
            }
            $this->{$key} = ($model instanceof HasDslAdapterContract) ?
                $model->getDslAdapter($this) :
                 new ModelDslAdapter($this, $model);

            unset($initial[$key]);
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

    public function data(): array
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
        foreach (array_keys($this->adapters) as $key) {
            $context[$key] = $this->{$key};
        }

        return array_merge($this->data, $context);
    }

    public function pack(): array
    {
        return [
            'data' => $this->data,
            'adapters' => [
                'chat'        => $this->chat->id(),
                'screen'      => $this->screen->id(),
                'memory'      => $this->memory->id(),
                'member'      => $this->member->id(),
            ],
            'inQueue'    => $this->inQueue,
            'skipQueue'  => $this->skipQueue,
            'timing'     => $this->packTiming(),
        ];
    }

    public static function unpack(array $payload): Process
    {
        $adapters = [
            'chat'        => Chat::findOrNew($payload['adapters']['chat']?? null),
            'screen'      => Screen::findOrNew($payload['adapters']['screen'] ?? null),
            'memory'      => Memory::findOrNew($payload['adapters']['memory'] ?? null),
            'member'      => Member::findOrNew($payload['adapters']['member'] ?? null),
        ];

        $instance = new static(array_merge($adapters, $payload['data'] ?? []));

        $instance->inQueue   = $payload['inQueue'] ?? false;
        $instance->skipQueue = $payload['skipQueue'] ?? false;
        $instance->unpackTiming($payload['timing'] ?? []);

        return $instance;
    }
}
