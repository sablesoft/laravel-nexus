<?php

namespace App\Crud\Traits;

trait HandleView
{
    public function viewButtons(): array
    {
        return [
            'edit' => [
                'title' => __('Edit'),
                'variant' => 'primary',
            ]
        ];
    }

    public function view(?int $id = null): void
    {
        $id = $id ?: $this->modelId;
        if (!$id) {
            return;
        }
        $this->resetState();
        $this->showForm = false;
        $model = $this->getModel($id);
        $this->modelId = $id;
        foreach($this->fields('view') as $field) {
            $this->state[$field] = $this->getValue($model, $field);
        }
        $this->action = 'view';
        $this->changeUri('view', $id);
    }
}
