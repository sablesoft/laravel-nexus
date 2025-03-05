<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ChatFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|string $title
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application
 * @property-read Collection<int, Memory>|Memory[] $memories
 * @property-read Collection<int, Mask>|Mask[] $masks
 */
class Chat extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ChatFactory> */
    use HasOwner, HasFactory;

    protected $fillable = [
        'user_id', 'application_id', 'title'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public function masks(): BelongsToMany
    {
        return $this->BelongsToMany(Mask::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
