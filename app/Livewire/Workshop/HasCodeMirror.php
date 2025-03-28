<?php

namespace App\Livewire\Workshop;

use Livewire\Attributes\Locked;

trait HasCodeMirror
{
    #[Locked]
    public string $codeMirrorPrefix = '';

    public function mountHasCodeMirror(): void
    {
        $this->codeMirrorPrefix = $this->codeMirrorPrefix();
    }

    protected function codeMirrorPrefix(): string
    {
        $parts = explode('\\', static::class);
        return strtolower(end($parts));
    }

    protected function codeMirrorFields(): array
    {
        return [];
    }

    protected function dispatchCodeMirror(): void
    {
        foreach ($this->codeMirrorFields() as $field) {
            $this->dispatch('codemirror:update', key: "$this->codeMirrorPrefix.$field", value: $this->state[$field]);
        }
    }
}
