<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleHasMany;

class Screen extends AbstractCrud
{
    use HandleHasMany;

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

    protected function fieldsConfig(): array
    {
        return [
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
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
