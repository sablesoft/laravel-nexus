<?php

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $image_id
 * @property-read null|Image $image
 * @property-read null|string $imagePath
 * @property-read null|string $imagePathMd
 * @property-read null|string $imagePathSm
 * @property-read null|string $imageUrl
 * @property-read null|string $imageUrlMd
 * @property-read null|string $imageUrlSm
 */
trait HasImage
{
    /**
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return string|null
     */
    public function getImagePathAttribute(): ?string
    {
        return $this->image?->path;
    }

    public function getImagePathMdAttribute(): ?string
    {
        return $this->image?->path_md;
    }

    public function getImagePathSmAttribute(): ?string
    {
        return $this->image?->path_sm;
    }

    public function getImageUrlAttribute(): ?string
    {
        $path = $this->imagePath;
        return $path ? \Storage::url($path) : null;
    }

    public function getImageUrlMdAttribute(): ?string
    {
        $path = $this->imagePathMd;
        return $path ? \Storage::url($path) : null;
    }

    public function getImageUrlSmAttribute(): ?string
    {
        $path = $this->imagePathSm;
        return $path ? \Storage::url($path) : null;
    }
}
