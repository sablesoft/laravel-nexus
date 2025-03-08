<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;

class Screen extends AbstractCrud
{
    use HandleHasMany, HandleImage;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Screen::class;
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

    protected function fieldsConfig(): array
    {
        return [
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
            'applications' => $this->hasManyField('applications'),
            'scenarios' => $this->hasManyField('scenarios', ['view'])
        ];
    }
}
