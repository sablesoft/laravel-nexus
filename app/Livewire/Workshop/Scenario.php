<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleLinks;
use App\Livewire\Filters\FilterIsDefault;

class Scenario extends AbstractCrud
{
    use HandleLinks, FilterIsDefault;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Scenario::class;
    }

    public static function routeName(): string
    {
        return 'workshop.scenarios';
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
            'stepsCrud' => [
                'title' => 'Steps',
                'action' => ['view'],
                'type' => 'component',
                'component' => 'workshop.scenario.steps',
            ],
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

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($action === 'view' && $field === 'stepsCrud') {
            return ['scenarioId' => $this->modelId];
        }

        return [];
    }
}
