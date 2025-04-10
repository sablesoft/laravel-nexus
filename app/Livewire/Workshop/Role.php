<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleUnique;
use App\Livewire\Filters\FilterIsPublic;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\BehaviorsValidator;
use App\Logic\Validators\StatesValidator;
use Illuminate\Database\Eloquent\Builder;

class Role extends AbstractCrud
{
    use HandleUnique, FilterIsPublic;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Role::class;
    }

    public static function routeName(): string
    {
        return 'workshop.roles';
    }

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'name' => __('Name'),
            'is_public' => __('Public')
        ];
    }

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        $dslEditor = config('dsl.editor', 'json');
        return [
            'name' => [
                'title' => __('Name'),
                'action' => ['index', 'edit', 'create', 'view'],
                'rules'  => ['required', 'string', $this->uniqueRule('roles', 'name')],
            ],
            'description' => [
                'title' => __('Description'),
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => [
                'title' => __('Public'),
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => ['boolean'],
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ],
            'statesString' => [
                'title' => __('States'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'behaviorsString' => [
                'title' => __('Behaviors'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(BehaviorsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $this->applyFilterIsPublic($query);
    }

    protected function paginationProperties(): array
    {
        return ['orderBy', 'orderDirection', 'perPage', 'search', ...$this->filterIsPublicProperties()];
    }

    public function filterTemplates(): array
    {
        return $this->filterIsPublicTemplates();
    }
}
