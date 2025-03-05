<?php

namespace App\Livewire\Workshop\Traits;

use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Support\Facades\Auth;

trait HandleIndex
{

    protected $checkedModels = null;

    /**
     * @return array
     */
    public function indexButtons(): array
    {
        return [
            'create' => __('Create')
        ];
    }

    public function checkedModels(): array
    {
        if (!is_null($this->checkedModels)) {
            return $this->checkedModels;
        }

        $models = [];
        foreach ($this->models as $model) {
            $data['id'] = $model->id;
            foreach ($this->checkedFields() as $field => $title) {
                $data[$field] = $this->getValue($model, $field);
            }
            $models[$model->id] = $data;
        }

        return $this->checkedModels = $models;
    }

    /**
     * @return array
     */
    public function checkedFields(): array
    {
        $fields = [];
        $config = $this->fieldsConfig();
        foreach ($this->fields($this->action) as $field) {
            $fields[$field] = (!empty($config[$field]['title'])) ?
                $config[$field]['title'] :
                self::title($field);
        }

        return $fields;
    }

    /**
     * @return array
     */
    public function checkedActions(): array
    {
        $actions = [];
        foreach ($this->actions() as $action => $icon) {
            foreach ($this->models as $model) {
                if ($this->canRun($action, $model->id)) {
                    $actions[$action] = $actions[$action] ?? [];
                    $actions[$action]['icon'] = $icon;
                    $actions[$action]['ids'] = $actions[$action]['ids'] ?? [];
                    $actions[$action]['ids'][] = $model->id;
                }
            }
        }

        return $actions;
    }

    /**
     * @return string[]
     */
    protected function actions(): array
    {
        return [
            'view' => 'eye',
            'edit' => 'pencil-square',
            'delete' => 'trash'
        ];
    }

    /**
     * @param string $action
     * @param int $id
     * @return bool
     */
    protected function canRun(string $action, int $id): bool
    {
        if (!$model = $this->getModel($id)) {
            return false;
        }

        if (Auth::user()->isAdmin()) {
            return true;
        }
        if ($action === 'view' && $model->is_public) {
            return true;
        }

        if ($model instanceof HasOwnerInterface) {
            $owner  = $model->user;
            return !$owner || $owner->id === auth()->id();
        } else {
            return true;
        }
    }
}
