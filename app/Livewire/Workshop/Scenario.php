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
        $dslEditor = config('dsl.editor', 'json');
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
            'stepsCount' => [
                'title' => 'Steps Count',
                'action' => ['index'],
                'callback' => fn(\App\Models\Scenario $scenario) => $scenario->steps()->count()
            ],
            'beforeString' => [
                'title' => 'Before',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => "nullable|$dslEditor",
                'collapsed' => true
            ],
            'afterString' => [
                'title' => 'After',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => "nullable|$dslEditor",
                'collapsed' => true
            ],
            'stepsCrud' => [
                'title' => 'Steps',
                'action' => ['view'],
                'type' => 'component',
                'component' => 'workshop.scenario.steps',
                'showEmpty' => true,
                'collapsed' => true
            ],
            'inStepsList' => $this->linkListField('In Steps Of', ['index', 'view']),
        ];
    }

    public function templateParams(string $action, ?string $field = null): array|callable
    {
        return match($field) {
            'inStepsList' => function(\App\Models\Scenario $scenario) {
                $route = Scenario::routeName();
                $inSteps = $scenario->inSteps;
                if (!count($inSteps)) {
                    return [];
                }
                $list = [];
                foreach ($inSteps as $inStep) {
                    $list[$inStep->scenario_id] = $inStep->scenario->title;
                }
                return compact('list', 'route');
            },
        };
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($action === 'view' && $field === 'stepsCrud') {
            return ['scenarioId' => $this->modelId];
        }

        return [];
    }
}
