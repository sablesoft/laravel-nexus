<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleUnique;
use App\Livewire\Filters\FilterIsPublic;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\BehaviorsValidator;
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
            'name' => 'Name',
            'is_public' => 'Is Public'
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
                'action' => ['index', 'edit', 'create', 'view'],
                'rules'  => ['required', 'string', $this->uniqueRule('roles', 'name')],
            ],
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => ['boolean'],
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ],
            'behaviorsString' => [
                'title' => 'Behaviors',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(BehaviorsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
        ];
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        return [];
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
