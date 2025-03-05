<?php

namespace App\Livewire\Workshop;

use App\Livewire\Workshop\Traits\HandleOwner;

class Scenario extends AbstractCrud
{
    use HandleOwner;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Scenario::class;
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
//            'code' => [
//                'action' => ['index', 'create', 'edit', 'view'],
//                'rules' => ['required', 'string', $this->uniqueRule('scenarios', 'code')],
//            ],
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'user' => $this->userField('Author'),
        ];
    }
}
