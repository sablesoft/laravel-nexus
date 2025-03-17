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
        $this->state[$this->getImageField()] = $this->getImageUrl($imageId);
    }

    public function getImageRatio(int $modelId): ?string
    {
        return $this->getModel($modelId)?->image?->aspect;
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
            'callback' => fn($model) => $model->image ? Storage::url($model->image->path) : null
        ];
    }

    protected function getImageUrl(int $imageId): string
    {
        $image = Image::findOrFail($imageId);
        return Storage::url($image->path);
    }
}
