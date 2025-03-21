<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Traits\HandleBelongsTo;
use App\Livewire\Filters\FilterIsDefault;
use App\Livewire\Filters\FilterScreen;
use App\Models\Enums\ScenarioType;
use Illuminate\Database\Eloquent\Builder;

class Scenario extends AbstractCrud implements ShouldBelongsTo
{
    use HandleBelongsTo, FilterScreen, FilterIsDefault;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Scenario::class;
    }

    protected function routeName(): string
    {
        return 'workshop.scenarios';
    }

    protected function paginationProperties(): array
    {
        return [
            'orderBy', 'orderDirection', 'perPage', 'search',
            ...$this->filterScreenProperties(), ...$this->filterIsDefaultProperties()
        ];
    }

    public function filterTemplates(): array
    {
        return [...$this->filterIsDefaultTemplates(), ...$this->filterScreenTemplates()];
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
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
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
            'screen_id' => $this->belongsToField('Screen', 'screen', ['create', 'edit', 'view', 'index']),
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

    protected function modifyQuery(Builder $query): Builder
    {
        $query = $this->applyFilterScreen($query);
        return $this->applyFilterIsDefault($query);
    }
}
