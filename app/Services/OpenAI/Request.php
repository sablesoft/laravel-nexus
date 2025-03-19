<?php

namespace App\Services\OpenAI;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Log;

class Request implements Arrayable
{
    protected array $params = [];
    protected ?string $model;

    /**
     * @param string|null $model
     */
    public function __construct(?string $model = null)
    {
        $this->model = $model;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addParam(string $key, mixed $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getParam(?string $key = null, mixed $default = null): mixed
    {
        if (!$key) {
            return $this->params;
        }
        return $this->params[$key] ?? $default;
    }

    public function unsetParam(string $key): self
    {
        unset($this->params[$key]);

        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->getParam(), [
            'model' => $this->model,
        ]);
    }
}
