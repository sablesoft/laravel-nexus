<?php

namespace App\Models;

use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasEffects;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The Application model represents a user-defined application (or scenario engine)
 * which contains a structured set of screens (Screen) and can be used to launch interactive chats.
 * Each application is created by a user and can include screens, transitions, logic,
 * and before/after DSL instructions at the application level.
 *
 * Environment:
 * - Used in Workshop UI for building and editing user applications
 * - Serves as the root context for all screens, controls, and transitions
 * - Used in Chat creation and Play component to determine which application is running
 *
 * ---
 * @property null|int $id
 * @property null|string $title         - Application title, visible in UI
 * @property null|string $description   - Description or notes about the application
 * @property null|bool $is_public       - Visibility flag (public or private) TODO - change to status
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Screen> $screens     - All screens that belong to the application
 * @property-read Collection<int, Chat> $chats         - All chats created from this application
 * @property-read Collection<int, Group> $groups       - All groups that belong to this application
 * @property-read Collection<int, GroupRole> $groupRoles - All group-roles that belong to this application
 * @property-read null|Screen $startScreen             - Default starting screen of the application
 */
class Application extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ApplicationFactory> */
    use HasOwner, HasStates, HasFactory, HasImage, HasEffects;

    protected $fillable = [
        'user_id', 'title', 'description', 'is_public', 'states', 'before', 'after'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'states' => 'array',
        'before' => 'array',
        'after' => 'array'
    ];

    public function screens(): HasMany
    {
        return $this->hasMany(Screen::class);
    }

    public function getStartScreenAttribute(): ?Screen
    {
        return $this->screens->where('is_start', true)->first();
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function groupRoles(): HasMany
    {
        return $this->hasMany(GroupRole::class);
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
