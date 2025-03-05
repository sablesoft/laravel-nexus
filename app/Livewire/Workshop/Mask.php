<?php

namespace App\Livewire\Workshop;

use App\Livewire\Workshop\Traits\HandleOwner;
use App\Livewire\Workshop\Traits\HandleUnique;

class Mask extends AbstractCrud
{
    use
        HandleOwner,
        HandleUnique;
//        HandleImage

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Mask::class;
    }

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'name' => 'name'
        ];
    }

    /**
     * @return array[]
     */
    protected function fieldsConfig(): array
    {
        return [
            'name' => [
                'action' => ['index', 'edit', 'create', 'view'],
                'rules' => ['required', 'string', $this->uniqueRule('masks', 'name')],
            ],
//            'image_id' => $this->imageField(),
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => $this->isPublicField(),
            'user' => $this->userField('Owner'),
        ];
    }
}
