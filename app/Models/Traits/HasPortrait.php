<?php

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $portrait_id
 * @property-read null|Image $portrait
 * @property-read null|string $portraitPath
 * @property-read null|string $portraitPathMd
 * @property-read null|string $portraitPathSm
 * @property-read null|string $portraitUrl
 * @property-read null|string $portraitUrlMd
 * @property-read null|string $portraitUrlSm
 */
trait HasPortrait
{
    /**
     * @return BelongsTo
     */
    public function portrait(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'portrait_id');
    }

    /**
     * @return string|null
     */
    public function getPortraitPathAttribute(): ?string
    {
        return $this->portrait?->path;
    }

    public function getPortraitPathMdAttribute(): ?string
    {
        return $this->portrait?->path_md;
    }

    public function getPortraitPathSmAttribute(): ?string
    {
        return $this->portrait?->path_sm;
    }

    public function getPortraitUrlAttribute(): ?string
    {
        $path = $this->portraitPath;
        return $path ? \Storage::url($path) : null;
    }

    public function getPortraitUrlMdAttribute(): ?string
    {
        $path = $this->portraitPathMd;
        return $path ? \Storage::url($path) : null;
    }

    public function getPortraitUrlSmAttribute(): ?string
    {
        $path = $this->portraitPathSm;
        return $path ? \Storage::url($path) : null;
    }
}
