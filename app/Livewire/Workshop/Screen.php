<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleLinks;
use App\Livewire\Filters\FilterApplication;
use App\Livewire\Filters\FilterIsDefault;
use App\Livewire\Workshop\Screen\HandleTransfers;
use App\Models\Transfer;
use App\Services\OpenAI\Enums\ImageAspect;
use Illuminate\Database\Eloquent\Builder;

class Screen extends AbstractCrud implements ShouldHasMany, ShouldBelongsTo
{
    use HandleHasMany, HandleBelongsTo, HandleImage, HandleTransfers, HandleLinks,
        FilterApplication, FilterIsDefault;

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
            'is_default' => 'Is Default',
        ];
    }

    protected function paginationProperties(): array
    {
        return [
            'orderBy', 'orderDirection', 'perPage', 'search',
            ...$this->filterApplicationProperties(), ...$this->filterIsDefaultProperties()
        ];
    }

    public function filterTemplates(): array
    {
        return [
            ...$this->filterApplicationTemplates(),
            ...$this->filterIsDefaultTemplates()
        ];
    }

    public function templateParams(string $action, ?string $field = null): array|callable
    {
        if (array_key_exists($field, $this->getHasManyFields())) {
            $class = $this->getHasManyFields()[$field];
            return $this->optionsParam($field, $class);
        }
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
            'scenarioLink' => $this->linkTemplateParams(Scenario::routeName(), 'scenario', true),
            'scenariosList' => $this->linkListTemplateParams(Scenario::routeName(), 'scenarios'),
            default => []
        };
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($field === 'image_id') {
            return $this->componentParamsImageSelector($field, [
                'aspectRatio' => ImageAspect::Portrait->value
            ]);
        }
        if ($action === 'edit' && $field === 'transfersEdit') {
            return ['screenId' => $this->modelId];
        }

        return [];
    }

    protected function fieldsConfig(): array
    {
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
                $this->belongsToField('Application', 'application', ['create', 'edit']),
            'is_default' => [
                'title' => 'Is Default',
                'action' => ['index', 'edit', 'view', 'create'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn($model) => $model->is_default ? 'Yes' : 'No'
            ],
            'applicationLink' => $this->linkField('Application', ['index', 'view']),
            'transfersEdit' => $this->transfersEditField(),
            'transfersView' => $this->transfersViewField(),
            'scenarioLink' => $this->linkField('Default Scenario', ['index', 'view']),
            'scenariosList' => $this->linkListField('Scenarios', ['index', 'view']),
            'constants' => [
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|json'
            ],
            'template' => [
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string|not_regex:/@php|@include|@component/'
            ],
        ];
    }

    public function getHasManyFields(): array
    {
        return [
            'scenarios' => \App\Models\Scenario::class,
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
        return $this->applyFilterIsDefault($query);
    }

    public function validate($rules = null, $messages = [], $attributes = []): array
    {
        $data = parent::validate($rules, $messages, $attributes);

        // todo - validate template and transfers

        return $data;
    }

    public function store(): void
    {
        $this->updateTransfers();
        parent::store();
    }

    protected function updateTransfers(): void
    {
        if ($this->action === 'edit') {
            unset($this->state['transfersEdit']);
            $transfers = Transfer::where('screen_from_id', $this->modelId)->get();
            foreach ($this->transfersDeleted as $screenToId) {
                /** @var Transfer $transfer */
                $transfer = $transfers->where('screen_to_id', $screenToId)->first();
                $transfer->delete();
            }
            foreach ($this->transfersUpdated as $screenToId => $updated) {
                /** @var Transfer $transfer */
                $transfer = $transfers->where('screen_to_id', $screenToId)->first();
                foreach (['code', 'title', 'tooltip', 'active'] as $field) {
                    $transfer->$field = $updated[$field];
                }
                $transfer->save();
            }
            foreach ($this->transfersAdded as $data) {
                Transfer::create($data);
            }
        }
    }
}
