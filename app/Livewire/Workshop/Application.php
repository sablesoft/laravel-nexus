<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use Illuminate\Database\Eloquent\Builder;

class Application extends AbstractCrud implements ShouldHasMany, ShouldBelongsTo
{
    use HandleHasMany, HandleBelongsTo, HandleImage;

    public function className(): string
    {
        return \App\Models\Application::class;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title'
        ];
    }

    public function templateParams(string $action, ?string $field = null): array
    {
        if (array_key_exists($field, $this->getHasManyFields())) {
            $class = $this->getHasManyFields()[$field];
            return $this->optionsParam($field, $class);
        }

        return match ($field) {
            'screen_id' => $this->optionsParam($field, \App\Models\Screen::class),
            'image_id' => $this->imageParam(),
            default => [],
        };
    }

    protected function fieldsConfig(): array
    {
        return [
            'image' => $this->getThumbnailField(),
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image_id' => $this->imageField(),
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'screen_id' => $this->belongsToField('Default Screen', 'screen', [
                'create', 'edit', 'view', 'index'
            ]),
            'screens' => $this->hasManyField('screens', ['view', 'edit']),
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => [
                    'bool',
                    function ($attribute, $value, $fail) {
                        if ($value === true && is_null($this->state['image_id'])) {
                            $fail('You cannot make this application public without image.');
                        }
                    },
                    function ($attribute, $value, $fail) {
                        if ($value === true && is_null($this->state['screen_id'])) {
                            $fail('You cannot make this application public without default screen.');
                        }
                    }
                ],
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ]
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->with('image', 'screen', 'screens');
    }

    public function getHasManyFields(): array
    {
        return [
            'screens' => \App\Models\Screen::class
        ];
    }

    public function getBelongsToFields(): array
    {
        return [
            'screen_id' => \App\Models\Screen::class
        ];
    }
}
