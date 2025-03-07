<?php

namespace App\Services\OpenAI;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

class ChoiceResult implements Arrayable
{
    use HasResult;

    protected ?string $content;

    /** @var Collection<int, ToolResult>|null  */
    protected ?Collection $toolResults;

    public function __construct(?string $content = null)
    {
        $this->content = $content;
        $this->toolResults = collect();
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return $this
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param ToolResult $result
     * @return $this
     */
    public function addToolResult(ToolResult $result): self
    {
        $this->toolResults->add($result);
        return $this;
    }

    /**
     * @return Collection<int, ToolResult>
     */
    public function getToolResults(): Collection
    {
        return $this->toolResults;
    }
}
