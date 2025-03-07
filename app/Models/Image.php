<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\FileService;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasFilesInterface;
use App\Models\Interfaces\HasOwnerInterface;

/**
 * @property null|int $id
 * @property string|null $title
 * @property string|null $prompt
 * @property string|null $path
 * @property bool|null $is_public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Image extends Model implements HasOwnerInterface, HasFilesInterface
{
    use HasOwner;

    protected $fillable = ['title', 'prompt', 'path', 'user_id', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean'
    ];

    public static function boot(): void
    {
        parent::boot();

        //while creating
        static::creating(function (Image $image) {
            self::assignCurrentUser($image);
        });

        static::saving(function(Image $image) {
            FileService::check($image);
        });
        // after scenario deleted:
        static::deleted(function(Image $image) {
            FileService::remove($image);
            static::detachStories($image);
        });
    }

    public function getPaths(): array
    {
        return [
            $this->path
        ];
    }
}
