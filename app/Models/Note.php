<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use App\Models\Traits\HasOwner;
use Illuminate\Database\Eloquent\Model;

/**
 * @property null|int $id
 * @property null|int $title
 * @property null|int $content
 * @property null|int $created_at
 * @property null|int $updated_at
 */
class Note extends Model
{
    use HasOwner;

    protected $fillable = [
        'user_id', 'title', 'content',
    ];

    protected $casts = [
        'title' => LocaleString::class,
        'content' => LocaleString::class,
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
