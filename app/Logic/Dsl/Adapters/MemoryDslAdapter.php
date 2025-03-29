<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Process;
use App\Models\Memory;

class MemoryDslAdapter extends ModelDslAdapter
{
    public function __construct(Process $process, ?Memory $model = null)
    {
        parent::__construct($process, $model ?? new Memory());
    }

    public function loadByExpr(string $expression): static
    {

//        $this->model = $model;
        return $this;
    }

    public function save(): bool
    {
        return $this->model?->save();
    }

    public function create(string $type, array $data): mixed
    {
        $data['type'] = $type;
        return Memory::create($data);
    }

    public function get(string $key): mixed
    {
        return $this->model?->getAttributeValue($key);
    }

    public function set(string $key, mixed $value): static
    {
        $this->model?->setAttribute($key, $value);
        return $this;
    }

    public function exists(string $key, $scope = null): bool
    {
        return Memory::for($scope)->has($key);
    }

    public function delete(string $key, $scope = null): void
    {
        Memory::for($scope)->delete($key);
    }
}
