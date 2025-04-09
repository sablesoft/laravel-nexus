<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleLinks;
use App\Livewire\Filters\FilterApplication;
use App\Livewire\Filters\FilterIsFlag;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\EffectsValidator;
use App\Logic\Validators\QueryExpressionValidator;
use App\Logic\Validators\StatesValidator;
use App\Services\OpenAI\Enums\ImageAspect;
use Illuminate\Database\Eloquent\Builder;

class Screen extends AbstractCrud implements ShouldBelongsTo
{
    use HandleBelongsTo, HandleImage, HandleLinks,
        FilterApplication, FilterIsFlag;

    public function className(): string
    {
        return \App\Models\Screen::class;
    }

    public static function routeName(): string
    {
        return 'workshop.screens';
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'code' => 'Code',
            'is_start' => 'Is Start',
        ];
    }

    protected function paginationProperties(): array
    {
        return [
            'orderBy', 'orderDirection', 'perPage', 'search',
            ...$this->filterApplicationProperties(), ...$this->filterIsFlagProperties()
        ];
    }

    public function filterTemplates(): array
    {
        return [
            ...$this->filterApplicationTemplates(),
            ...$this->filterIsFlagTemplates()
        ];
    }

    public function templateParams(string $action, ?string $field = null): array|callable
    {
        if (array_key_exists($field, $this->getBelongsToFields())) {
            $class = $this->getBelongsToFields()[$field];
            return $this->optionsParam($field, $class);
        }
        if ($action === 'view' && $field === 'transfersView') {
            /** @var \App\Models\Screen $model */
            $model = $this->getResource();
            return ['transfers' => $model->transfers];
        }
        return match($field) {
            'applicationLink' => $this->linkTemplateParams(Application::routeName(), 'application'),
            'transfersToList' => function(\App\Models\Screen $screen) {
                $route = Screen::routeName();
                $transfers = $screen->transfers;
                if (!count($transfers)) {
                    return [];
                }
                $list = [];
                foreach ($transfers as $transfer) {
                    $list[$transfer->screen_to_id] = $transfer->title;
                }
                return compact('list', 'route');
            },
            'transfersFromList' => function(\App\Models\Screen $screen) {
                $route = Screen::routeName();
                $transfers = $screen->transfersFrom;
                if (!count($transfers)) {
                    return [];
                }
                $list = [];
                foreach ($transfers as $transfer) {
                    $list[$transfer->screen_from_id] = $transfer->screenFrom->title;
                }
                return compact('list', 'route');
            },
            default => []
        };
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($field === 'image_id') {
            /** @var \App\Models\Screen $model */
            $model = $this->getModel($this->modelId);
            return $this->componentParamsImageSelector($field, $model->image_id, [
                'aspectRatio' => ImageAspect::Portrait->value
            ]);
        }
        if ($action === 'view' && $field === 'transfersCrud') {
            return ['screenId' => $this->modelId];
        }
        if ($action === 'view' && $field === 'controlsCrud') {
            return ['screenId' => $this->modelId];
        }

        return [];
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
                'action' => ['create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image' => $this->imageViewerField(),
            'image_id' => $this->imageSelectorField(),
            'description' => [
                'action' => ['create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'application_id' =>
                $this->belongsToField('Application', 'application', ['create', 'edit'], 'required|int'),
            'is_start' => [
                'title' => 'Is Start',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => 'nullable|bool',
                'init' => false,
                'callback' => fn(\App\Models\Screen $model) => $model->is_start ? 'Yes' : 'No'
            ],
            'query' => [
                'action' => ['create','edit','view'],
                'type' => 'textarea',
                'rules' => [
                    'nullable',
                    'string',
                    new DslRule(QueryExpressionValidator::class, 'raw'),
                ]
            ],
            'template' => [
                'action' => ['create','edit','view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'statesString' => [
                'title' => 'Global States',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'beforeString' => [
                'title' => 'Effects',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'afterString' => [
                'title' => 'Effects After',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'enabled_condition' => [
                'title' => 'Enabled Condition',
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => [
                    'nullable',
                    'string',
                    new DslRule(QueryExpressionValidator::class, 'raw')
                ]
            ],
            'visible_condition' => [
                'title' => 'Visible Condition',
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => [
                    'nullable',
                    'string',
                    new DslRule(QueryExpressionValidator::class, 'raw')
                ]
            ],
            'applicationLink' => $this->linkField('Application', ['index', 'view']),
            'transfersToList' => $this->linkListField('Transfers To', ['index']),
            'transfersFromList' => $this->linkListField('Transfers From', ['index', 'view']),
            'transfersCrud' => [
                'title' => 'Transfers To',
                'action' => ['view'],
                'type' => 'component',
                'component' => 'workshop.screen.transfers',
                'showEmpty' => true,
                'collapsed' => true,
            ],
            'controlsCrud' => [
                'title' => 'Controls',
                'action' => ['view'],
                'type' => 'component',
                'component' => 'workshop.screen.controls',
                'showEmpty' => true,
                'collapsed' => true,
            ],
        ];
    }

    public function getBelongsToFields(): array
    {
        return [
            'application_id' => \App\Models\Application::class
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query = $this->applyFilterApplication($query->with('image'));
        return $this->applyFilterIsFlag($query, 'is_start');
    }

    public function filterIsFlagLabel(): string
    {
        return 'Is Start';
    }

    public function validate($rules = null, $messages = [], $attributes = []): array
    {
        $data = parent::validate($rules, $messages, $attributes);

        // todo - validate template

        return $data;
    }
}
