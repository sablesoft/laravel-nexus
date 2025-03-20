<?php

namespace App\Crud\Traits;

use App\Models\Image;
use Livewire\Attributes\On;
use Storage;

trait HandleImage
{
    protected function getImageIdField(): string
    {
        return 'image_id';
    }

    protected function getImageField(): string
    {
        return 'image';
    }

    #[On('imageSelected')]
    public function imageSelected(int $imageId): void
    {
        $this->state[$this->getImageIdField()] = $imageId;
        $this->state[$this->getImageField()] = $this->getImagePath($imageId);
    }

    public function getImageRatio(int $modelId): ?string
    {
        return $this->getModel($modelId)?->image?->aspect?->value;
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
        array $action = ['create', 'edit', 'index', 'view']
    ): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'image',
            'callback' => fn($model) => $model->image ? $model->image->path : null
        ];
    }

    protected function getImagePath(int $imageId): string
    {
        return Image::findOrFail($imageId)->path;
    }
}
