<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Traits\HandleBelongsTo;
use App\Models\Enums\ScenarioType;

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
            'type' => 'Type',
            'is_default' => 'Is Default'
        ];
    }

    protected function fieldsConfig(): array
    {
        return [
            'code' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'type' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
                'type' => 'select',
                'callback' => fn($model) => $model->type->value
            ],
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',

            ],
            'tooltip' => [
                'action' => ['create', 'edit', 'view'],
                'rules' => 'nullable|string',

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
            'active' => [
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|json'
            ],
        ];
    }

    public function selectOptions(string $field): array
    {
        return match ($field) {
            'type' => ScenarioType::options(),
            default => [],
        };
    }

    public function getBelongsToFields(): array
    {
        return [
            'screen_id' => \App\Models\Screen::class
        ];
    }
}
