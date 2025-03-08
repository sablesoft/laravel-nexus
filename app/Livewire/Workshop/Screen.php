<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldBelongsTo;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleBelongsTo;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;

class Screen extends AbstractCrud implements ShouldHasMany, ShouldBelongsTo
{
    use HandleHasMany, HandleBelongsTo, HandleImage;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Screen::class;
    }

    /**
     * @return string[]
     */
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
            'scenario_id' => $this->optionsParam('scenario_id', \App\Models\Scenario::class),
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
            'applications' => $this->hasManyField('applications'),
            'scenario_id' => $this->belongsToField('Default Scenario', 'scenario'),
            'scenarios' => $this->hasManyField('scenarios', ['view', 'edit'])
        ];
    }

    public function getHasManyFields(): array
    {
        return [
            'applications' => \App\Models\Application::class,
            'scenarios' => \App\Models\Scenario::class,
        ];
    }

    public function getBelongsToFields(): array
    {
        return [
            'scenario_id' => \App\Models\Scenario::class
        ];
    }
}
