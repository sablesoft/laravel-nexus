<?php

namespace App\Crud\Traits;

trait HandleBelongsTo
{
    protected function belongsToField(string $title, string $relation, array $action = ['create', 'edit', 'view']): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'template',
            'template' => 'components.searchable-select',
            'callback' => fn($model) => $model->$relation?->title,
            'rules' => 'nullable|int',
        ];
    }

    public function templateParams(string $action, ?string $field = null): array
    {
        if (array_key_exists($field, $this->getBelongsToFields())) {
            $class = $this->getBelongsToFields()[$field];
            return $this->optionsParam($field, $class);
        }

        return [];
    }
}
