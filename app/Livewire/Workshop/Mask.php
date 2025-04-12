<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleUnique;
use App\Livewire\Filters\FilterIsPublic;
use App\Models\Enums\Gender;
use App\Services\OpenAI\Enums\ImageAspect;
use Illuminate\Database\Eloquent\Builder;

class Mask extends AbstractCrud
{
    use HandleUnique, HandleImage, FilterIsPublic;

    /**
     * @return string
     */
    public function className(): string
    {
        return \App\Models\Mask::class;
    }

    public static function routeName(): string
    {
        return 'workshop.masks';
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
        return [
            'name' => [
                'title' => __('Name'),
                'action' => ['index', 'edit', 'create', 'view'],
                'rules' => ['required', 'string'],
            ],
            'gender' => [
                'title' => __('Gender'),
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'select',
                'options' => Gender::options()
            ],
            'image' => $this->imageViewerField(__('Avatar')),
            'image_id' => $this->imageSelectorField(__('Avatar')),
            'portrait' => $this->imageViewerField(__('Portrait'), 'portrait'),
            'portrait_id' => $this->imageSelectorField(__('Portrait')),
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

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($field === 'image_id') {
            return $this->componentParamsImageSelector($field, null, [
                'aspectRatio' => ImageAspect::Square->value
            ]);
        }
        if ($field === 'portrait_id') {
            return $this->componentParamsImageSelector($field, null, [
                'aspectRatio' => ImageAspect::Portrait->value
            ]);
        }

        return [];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $this->applyFilterIsPublic($query)->with(['image']);
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
