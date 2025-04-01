<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Memory;
use Illuminate\Support\Arr;

class MemoryDslAdapter extends ModelDslAdapter
{
    public function __construct(Process $process, ?Memory $model = null)
    {
        parent::__construct($process, $model ?? new Memory());
    }

    public function loadByExpr(string $expression): bool
    {
        $query = Dsl::apply(Memory::query(), $expression, $this->process->toContext());
        $query->where('chat_id', $this->process->chat->id);
        // todo - hande collection:
        $this->model = $query->first();
        return !!$this->model;
    }

    public function meta(string $path, mixed $default = null): mixed
    {
        $meta = $this->model?->getAttributeValue('meta') ?? [];

        return is_array($meta)
            ? Arr::get($meta, $path, $default)
            : $default;
    }

    public function get(string $key): mixed
    {
        return $this->model?->getAttributeValue($key);
    }

    public function set(string $key, mixed $value): true
    {
        $this->model?->setAttribute($key, $value);
        return true;
    }
}
