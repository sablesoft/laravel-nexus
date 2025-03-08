<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;

class Application extends AbstractCrud
{
    use HandleHasMany, HandleImage;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Application::class;
    }

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title'
        ];
    }

    public function templateParams(string $action, ?string $field = null): array
    {
        return match ($field) {
            'image_id' => $this->imageParam(),
            default => [],
        };
    }

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        return array_merge([
            'image' => $this->getThumbnailField(),
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image_id' => $this->imageField(),
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'screens' => $this->hasManyField('screens'),
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => 'bool',
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ]
        ]);
    }
}
