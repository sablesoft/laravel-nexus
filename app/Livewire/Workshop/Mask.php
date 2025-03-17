<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleUnique;

class Mask extends AbstractCrud
{
    use HandleUnique, HandleImage;

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
            'name' => 'Name',
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
            'image' => $this->imageViewerField(),
            'image_id' => $this->imageSelectorField(),
            'description' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'rules' => [
                    'boolean',
                    function ($attribute, $value, $fail) {
                        if ($value === true && is_null($this->state['image_id'])) {
                            $fail('You cannot make this mask public without image.');
                        }
                    }
                ],
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
            ],
        ];
    }
}
