<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleHasMany;

class Scenario extends AbstractCrud
{
    use HandleHasMany;

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
            'screens' => $this->hasManyField('screens')
        ];
    }
}
