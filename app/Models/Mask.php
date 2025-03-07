<?php

namespace App\Models;

use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use Carbon\Carbon;
use Database\Factories\MaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $user_id
 * @property null|string $name
 * @property null|string $description
 * @property null|boolean $is_public
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|User $user
 * @property-read Collection<int, Chat>|Chat[] $chats
 * @property-read Collection<int, Memory>|Memory[] $memories
 */
class Mask extends Model implements HasOwnerInterface
{
    /** @use HasFactory<MaskFactory> */
    use HasOwner, HasFactory, HasImage;

    protected $fillable = [
        'user_id', 'name', 'description', 'is_public'
    ];

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
