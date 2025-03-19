<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use Illuminate\Database\Eloquent\Builder;

class Screen extends AbstractCrud implements ShouldHasMany, ShouldBelongsTo
{
    use HandleHasMany, HandleBelongsTo, HandleImage;

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
            'transfers' => $this->hasManyField('transfers', ['view']),
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
            'control' => [
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

        // todo - validate template

        return $data;
    }
}
