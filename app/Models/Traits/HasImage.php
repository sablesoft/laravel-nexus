<?php

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $image_id
 * @property-read null|Image $image
 * @property-read null|string $imagePath
 * @property-read null|string $imageUrl
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

    public function getImageUrlAttribute(): ?string
    {
        $path = $this->imagePath;
        return $path ? \Storage::url($path) : null;
    }
}
