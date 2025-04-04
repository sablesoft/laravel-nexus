<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleLinks;
use App\Logic\Contracts\LogicContract;
use App\Logic\Effect\EffectRule;
use App\Logic\Facades\LogicRunner;
use App\Logic\Process;

class Scenario extends AbstractCrud
{
    use HandleLinks;

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
                'title' => 'Effects',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new EffectRule($dslEditor)],
                'collapsed' => true
            ],
            'afterString' => [
                'title' => 'Effects After',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new EffectRule($dslEditor)],
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
            'inControlsList' => $this->linkListField('In Controls Of', ['index', 'view']),
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
                    $list[$inStep->parent_id] = $inStep->parent->title;
                }
                return compact('list', 'route');
            },
            'inControlsList' => function(\App\Models\Scenario $scenario) {
                $route = Screen::routeName();
                $inControls = $scenario->inControls;
                if (!count($inControls)) {
                    return [];
                }
                $list = [];
                foreach ($inControls as $inControl) {
                    $list[$inControl->screen_id] = $inControl->screen->title .' - '. $inControl->title;
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

    public function viewButtons(): array
    {
        return [
            'edit' => [
                'title' => __('Edit'),
                'variant' => 'primary',
            ],
            'run' => [
                'title' => __('Run'),
            ]
        ];
    }

    public function run(): void
    {
        /** @var LogicContract $scenario **/
        $scenario = $this->getResource();
        $process = new Process();
        $process->skipQueue = true;
        try {
            LogicRunner::runLogic($scenario, $process);
            dd($process);
        } catch (\Throwable $e) {
            dd($e, $process);
        }
    }
}
