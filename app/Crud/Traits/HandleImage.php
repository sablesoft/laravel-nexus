<?php

namespace App\Crud\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait HandleImage
{
    /**
     * @param string $title
     * @return array
     */
    protected function imageField(string $title = 'Image'): array
    {
        return [
            'title' => $title,
            'action' => ['create', 'edit', 'view'],
            'type' => 'template',
            'template' => 'crud.searchable',
            'callback' => 'getImageHtml',
            'rules' => 'nullable|int',
        ];
    }

    protected function getImageHtml(Model $model, int $size = 96): string
    {
        if (!$model->image) {
            return '---';
        }

        return '<img src="' . Storage::url($model->imagePath) .
            '" class="w-'.$size.' h-'.$size.' object-cover rounded-md" alt="Image"/>';
    }

    protected function getThumbnailField(string $title = 'Image'): array
    {
        return [
            'title' => $title,
            'action' => ['index'],
            'type' => 'image',
            'callback' => 'getThumbnailHtml',
        ];
    }

    protected function getThumbnailHtml(Model $model): string
    {
        return $this->getImageHtml($model, 32);
    }

    /**
     * @return array
     */
    protected function imageParam(): array
    {
        return [
            'options' =>
                $this->filterByOwner($this->getQuery(Image::class))
                    ->select(['id', 'title as name'])->get()->toArray()
        ];
    }
}
