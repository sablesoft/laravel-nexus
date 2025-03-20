<?php

namespace App\Crud\Traits;

use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Locked;

trait HandleForm
{
    #[Locked]
    public ?bool $showForm = null;
    #[Locked]
    public string $formAction = 'store';

    /**
     * @param string $field
     * @return string|null
     */
    public function placeholder(string $field): ?string
    {
        return $this->config($field, 'placeholder');
    }

    public function selectOptions(string $field): array
    {
        return [];
    }

    public function config(string $field, string $param, ?string $default = null): mixed
    {
        $config = $this->fieldsConfig()[$field];
        return $config[$param] ?? $default;
    }

    /**
     * @param string $field
     * @return string
     */
    public function type(string $field): string
    {
        return $this->config($field, 'type', 'input');
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        $class = $this->className();
        return $class::findOrFail($this->modelId);
    }

    /**
     * @return void
     */
    protected function openForm(): void
    {
        $this->showForm = true;
    }
}
