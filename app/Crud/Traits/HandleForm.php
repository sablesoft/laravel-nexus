<?php

namespace App\Crud\Traits;

use App\Models\Services\StoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;

trait HandleForm
{
    #[Locked]
    public ?bool $showForm = null;
    #[Locked]
    public string $formAction = 'store';

    public function create(): void
    {
        $this->action = 'create';
        $this->resetState();
        foreach($this->fields('create') as $field) {
            $init = $this->config($field, 'init');
            if ($init) {
                $this->state[$field] = $this->$init();
            }
        }
        $this->openForm();
        $this->changeUri('create');
    }

    public function edit(int $id): void
    {
        $model = $this->getModel($id);
        $this->modelId = $id;
        $this->resetState();
        foreach($this->fields('edit') as $field) {
            if ($this->type($field) === 'image') {
                $callback = $this->config($field, 'callback');
                $this->state[$field] = is_callable($callback) ?
                    $callback($model) : $model->$field;
            } else {
                if ($model->$field instanceof \UnitEnum) {
                    $enum = $model->$field;
                    $this->state[$field] = $enum->value;
                } else {
                    $this->state[$field] = $model->$field;
                }
            }
        }
        $this->action = 'edit';
        $this->openForm();
        $this->changeUri('edit', $id);
    }

    public function store(): void
    {
        $rules = $this->actionConfig($this->action, 'rules');
        if ($rules) {
            $data = $this->validate(\Arr::prependKeysWith($rules, 'state.'));
        }  else {
            return;
        }
        try {
            $model = $this->getModel($this->modelId);
            $model = StoreService::handle($data['state'], $model);
            $this->dispatch('flash', message: $this->classTitle(false) . ($this->modelId ? ' updated' : ' created'));
            $this->view($model->getKey());
        } catch (\Throwable $e) {
            $this->dispatch('flash', message: config('app.debug') ? $e->getMessage() : 'Failed. Something wrong.');
            Log::error($e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * @param string $field
     * @return string|null
     */
    public function placeholder(string $field): ?string
    {
        return $this->config($field, 'placeholder');
    }

    public function selectOptions(string $field): array
    {
        return [];
    }

    public function config(string $field, string $param, ?string $default = null): mixed
    {
        $config = $this->fieldsConfig()[$field];
        return $config[$param] ?? $default;
    }

    /**
     * @param string $field
     * @return string
     */
    public function type(string $field): string
    {
        return $this->config($field, 'type', 'input');
    }

    /**
     * @return Model
     */
    public function getResource(): Model
    {
        $class = $this->className();
        return $class::findOrFail($this->modelId);
    }

    /**
     * @return void
     */
    protected function openForm(): void
    {
        $this->showForm = true;
    }
}
