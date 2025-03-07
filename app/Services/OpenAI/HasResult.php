<?php

namespace App\Services\OpenAI;

trait HasResult
{
    public ?bool $success = null;
    protected ?array $data = null;

    public function toArray(): array
    {
        $data = $this->data ?: [];
        $data['success'] = $this->success;

        return $data;
    }

    public function markFailed(): self
    {
        $this->success = false;
        return $this;
    }

    public function markSuccess(): self
    {
        $this->success = true;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @noinspection PhpDocSignatureIsNotCompleteInspection
     */
    public function add(string $key, mixed $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function getAll(): array
    {
        return $this->data;
    }
}
