<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleLinks;

class Group extends AbstractCrud
{
    use HandleLinks;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Group::class;
    }

    public static function routeName(): string
    {
        return 'workshop.groups';
    }

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
//            'name' => __('Name'), todo
        ];
    }

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        return [
            'name' => [
                'title' => __('Name'),
                'action' => ['index', 'edit', 'create', 'view'],
                'rules'  => ['required', 'string'],
            ],
            'description' => [
                'title' => __('Description'),
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'rolesList' => $this->linkListField(__('Screens'), ['index', 'view']),
        ];
    }

    public function templateParams(string $action, ?string $field = null): array|callable
    {
        return match ($field) {
            'rolesList' => $this->linkListTemplateParams(Role::routeName(), 'roles'),
            default => [],
        };
    }
}
