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

    protected function codeMirrorViewMap(): array
    {
        return [
            'codemirror-before-' => 'beforeString',
            'codemirror-after-' => 'afterString'
        ];
    }

    protected function dispatchCodeMirrorView(string $key): void
    {
        foreach ($this->codeMirrorViewMap() as $prefix => $field) {
            $this->dispatch('codemirror:update', key: "$prefix$key", value: $this->state[$field]);
        }
    }
}
