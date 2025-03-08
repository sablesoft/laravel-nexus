<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;

class Application extends AbstractCrud implements ShouldHasMany
{
    use HandleHasMany, HandleImage;

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
            return [
                'field' => $field,
                'options' =>
                    $class::where('user_id', auth()->id())
                        ->select(['id', 'title as name'])->get()->toArray()
            ];
        }

        return match ($field) {
            'image_id' => $this->imageParam(),
            default => [],
        };
    }

    protected function fieldsConfig(): array
    {
        return array_merge([
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
            'screens' => $this->hasManyField('screens'),
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => 'bool',
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ]
        ]);
    }

    public function getHasManyFields(): array
    {
        return [
            'screens' => \App\Models\Screen::class
        ];
    }
}
