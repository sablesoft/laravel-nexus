<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use Illuminate\Database\Eloquent\Builder;

class Application extends AbstractCrud implements ShouldHasMany
{
    use HandleHasMany, HandleImage;

    public string $filterIsPublic = 'all';

    public function className(): string
    {
        return \App\Models\Application::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'is_public' => 'Is Public'
        ];
    }

    public function filterTemplates(): array
    {
        return ['crud.filter-public'];
    }

    protected function getPaginationFields(): array
    {
        return ['orderBy', 'orderDirection', 'perPage', 'search', 'filterIsPublic'];
    }

    public function templateParams(string $action, ?string $field = null): array
    {
        if (array_key_exists($field, $this->getHasManyFields())) {
            $class = $this->getHasManyFields()[$field];
            return $this->optionsParam($field, $class);
        }

        return match ($field) {
            'screen_id' => $this->optionsParam($field, \App\Models\Screen::class),
            default => [],
        };
    }

    protected function fieldsConfig(): array
    {
        return [
            'title' => [
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
            'constants' => [
                'action' => ['edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|json'
            ],
            'screen' => [
                'title' => 'Base Screen',
                'action' => ['view'],
                'callback' => fn($model) => $model->screen()?->title
            ],
            'screens' => $this->hasManyField('screens', ['view']),
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => [
                    'bool',
                    function ($attribute, $value, $fail) {
                        if ($value === true) {
                            if (is_null($this->state['image_id'])) {
                                $fail('You cannot make this application public without an image.');
                            }
                            if (!$this->getModel($this->modelId)->screen()) {
                                $fail('You cannot make this application public without a base screen.');
                            }
                        }
                    },
                ],
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ]
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        if ($this->filterIsPublic !== 'all') {
            $query->where('is_public', $this->filterIsPublic === 'yes');
        }

        return $query->with(['image', 'screens']);
    }

    public function getHasManyFields(): array
    {
        return [
            'screens' => \App\Models\Screen::class
        ];
    }
}
