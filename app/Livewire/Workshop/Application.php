<?php

namespace App\Livewire\Workshop;

use App\Livewire\Workshop\Traits\HandleOwner;

class Application extends AbstractCrud
{
    use HandleOwner;

    /**
     * @return string
     */
    public function className(): string
    {
        return  \App\Models\Application::class;
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

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        return array_merge([
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => $this->isPublicField(),
            'user' => $this->userField('Author'),
        ]);
    }
}
