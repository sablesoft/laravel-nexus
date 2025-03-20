<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use App\Livewire\Workshop\Screen\HandleTransfers;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;

class Screen extends AbstractCrud implements ShouldHasMany, ShouldBelongsTo
{
    use HandleHasMany, HandleBelongsTo, HandleImage, HandleTransfers;

    public function className(): string
    {
        return \App\Models\Screen::class;
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

    public function templateParams(string $action, ?string $field = null): array
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
            $model = $this->getModel($this->modelId);
            return ['transfers' => $model->transfers];
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
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image' => $this->imageViewerField(),
            'image_id' => $this->imageSelectorField(),
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'application_id' => $this->belongsToField('Application', 'application'),
            'is_default' => [
                'title' => 'Is Default',
                'action' => ['index', 'edit', 'view', 'create'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn($model) => $model->is_default ? 'Yes' : 'No'
            ],
            'transfersEdit' => $this->transfersEditField(),
            'transfersView' => $this->transfersViewField(),
            'screen' => [
                'title' => 'Default Scenario',
                'action' => ['view'],
                'callback' => fn($model) => $model->scenario()?->title
            ],
            'scenarios' => $this->hasManyField('scenarios', ['view']),
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
        return $query->with('image');
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
