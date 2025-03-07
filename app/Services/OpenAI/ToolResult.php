<?php

namespace App\Services\OpenAI;

use Illuminate\Contracts\Support\Arrayable;

class ToolResult implements Arrayable
{
    use HasResult;

    public string $name;

    public function __construct(string $name, bool $success = true)
    {
        $this->name = $name;
        $this->success = $success;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'success' => $this->success,
            'result' => $this->data
        ];
    }
}
