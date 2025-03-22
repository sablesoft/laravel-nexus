<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|string $title
 * @property null|string $description
 * @property null|bool $is_public
 * @property null|array $constants
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Screen>|Screen[] $screens
 * @property-read Collection<int, Chat>|Chat[] $chats
 * @property-read null|Screen $initScreen
 */
class Application extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ApplicationFactory> */
    use HasOwner, HasFactory, HasImage;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_public', 'constants'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'constants' => 'array'
    ];

    public function screens(): HasMany
    {
        return $this->hasMany(Screen::class);
    }

    public function getInitScreenAttribute(): ?Screen
    {
        return $this->screens->where('is_default', true)->first();
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
