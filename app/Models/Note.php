<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use App\Models\Enums\NoteType;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasOwner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property null|int $id
 * @property null|int $title
 * @property null|int $content
 * @property null|NoteType $type
 * @property null|array $meta
 * @property null|int $created_at
 * @property null|int $updated_at
 *
 * @property-read Collection $usages
 */
class Note extends Model implements HasOwnerInterface
{
    use HasOwner;

    protected $fillable = [
        'user_id', 'title', 'content', 'meta'
    ];

    protected $casts = [
        'title' => LocaleString::class,
        'content' => LocaleString::class,
        'type' => NoteType::class,
        'meta' => 'array',
    ];

    public function usages(): MorphToMany
    {
        return $this->morphedByMany(
            Note::class,
            'noteable',
            'note_usages'
        )->withPivot('code')->withTimestamps();
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
