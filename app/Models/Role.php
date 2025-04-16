<?php

namespace App\Models;

use App\Models\Casts\Behaviors;
use App\Models\Casts\LocaleString;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasBehaviors;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $group_id
 * @property null|string $name
 * @property null|string $description
 * @property null|bool $is_public
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|string $title
 * @property-read null|Group $group
 */
class Role extends Model implements HasOwnerInterface, Stateful
{
    use HasOwner, HasBehaviors, HasStates, HasFactory;

    protected $fillable = [
        'user_id', 'group_id', 'name', 'description', 'is_public', 'behaviors', 'states'
    ];

    protected $casts = [
        'is_public' => 'bool',
        'behaviors' => Behaviors::class,
        'states' => 'array',
        'name' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function getTitleAttribute(): ?string
    {
        return $this->name;
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
        static::saving([self::class, 'savingAllStates']);
    }
}
