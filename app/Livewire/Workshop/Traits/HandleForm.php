<?php

namespace App\Livewire\Workshop\Traits;

use Livewire\Attributes\Locked;

trait HandleForm
{
    #[Locked]
    public ?int $modelId = null;
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

    /**
     * @param string $field
     * @param string $param
     * @param string|null $default
     * @return string|null
     */
    public function config(string $field, string $param, ?string $default = null): ?string
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
     * @return void
     */
    protected function openForm(): void
    {
        $this->showForm = true;
    }
}
