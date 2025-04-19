<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;

class Note extends AbstractCrud
{
    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Note::class;
    }

    public static function routeName(): string
    {
        return 'workshop.notes';
    }

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
//            'title' => __('Title'), todo
        ];
    }

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        return [
            'title' => [
                'title' => __('Title'),
                'action' => ['index', 'edit', 'create', 'view'],
                'rules'  => ['required', 'string'],
            ],
            'content' => [
                'title' => __('Content'),
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'required|string'
            ],
        ];
    }
}
