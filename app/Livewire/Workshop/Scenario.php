<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Traits\HandleBelongsTo;

class Scenario extends AbstractCrud implements ShouldBelongsTo
{
    use HandleBelongsTo;

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
            'title' => 'Title',
            'code' => 'Code',
            'is_default' => 'Is Default'
        ];
    }

    protected function fieldsConfig(): array
    {
        return [
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',

            ],
            'code' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_default' => [
                'title' => 'Is Default',
                'action' => ['index', 'edit', 'view', 'create'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn($model) => $model->is_default ? 'Yes' : 'No'
            ],
            'screen_id' => $this->belongsToField('Screen', 'screen'),
            'constants' => [
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|json'
            ],
        ];
    }

    public function getBelongsToFields(): array
    {
        return [
            'screen_id' => \App\Models\Screen::class
        ];
    }
}
