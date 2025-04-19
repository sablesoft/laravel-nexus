<?php

namespace App\Logic;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final readonly class ToolCall implements Arrayable
{
    public function __construct(private string $name, public array $arguments) {}

    public function name(): string
    {
        return $this->name;
    }

    public function __get(string $name): mixed
    {
        return $this->arguments[$name] ?? null;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->arguments, $key, $default);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'arguments' => $this->arguments
        ];
    }

    public static function fromArray(array $data): self
    {
        $name = $data['name'] ?? null;
        if (empty($name) || !is_string($name)) {
            throw new \InvalidArgumentException('Missed tool name for ToolCall from array');
        }
        $arguments = $data['arguments'] ?? [];
        if (!is_array($arguments)) {
            throw new \InvalidArgumentException('Invalid arguments for ToolCall from array');
        }

        return new ToolCall($name, $arguments);
    }
}
