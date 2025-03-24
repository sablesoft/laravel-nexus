<?php

namespace App\Crud\Traits;

use App\Models\Image;
use Livewire\Attributes\On;

trait HandleImage
{
    #[On('imageSelected')]
    public function imageSelected(int $imageId, string $field): void
    {
        $parts = explode('_', $field);
        $this->state[$field] = $imageId;
        $this->state[reset($parts)] = $this->getImagePath($imageId);
    }

    public function getImageRatio(int $modelId): ?string
    {
        return $this->getResource()?->image?->aspect?->value;
    }

    public function componentParamsImageSelector(string $field = 'image_id', ?int $imageId = null, array $filter = []): array
    {
        return [
            'field' => $field,
            'imageId' => $imageId,
            'filter' => $filter
        ];
    }

    /**
     * @param string $title
     * @param array $action
     * @return array
     */
    protected function imageSelectorField(string $title = 'Image', array $action = ['create', 'edit']): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'component',
            'component' => 'image-selector',
            'rules' => 'nullable|int',
        ];
    }

    protected function imageViewerField(
        string $title = 'Image',
        string $relation = 'image',
        array $action = ['index', 'view']
    ): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'image',
            'callback' => fn($model) => $model->$relation ? $model->$relation->path_md : null
        ];
    }

    protected function getImagePath(int $imageId): string
    {
        return Image::findOrFail($imageId)->path_md;
    }
}
