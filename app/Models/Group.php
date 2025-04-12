<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasOwner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|string $name
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|string $title
 * @property-read Collection<int, Role> $roles    - All roles that belong to this group
 */
class Group extends Model implements HasOwnerInterface
{
    use HasOwner;

    protected $fillable = [
        'user_id', 'name', 'description',
    ];

    protected $casts = [
        'name' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function getTitleAttribute(): ?string
    {
        return $this->name;
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
