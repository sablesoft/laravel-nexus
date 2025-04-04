<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|string $name
 * @property null|string $description
 * @property null|int $number
 * @property null|int $roles_per_member
 * @property null|bool $is_required
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application             - The parent application this group belongs to
 * @property-read Collection<int, GroupRole> $groupRoles    - All group-roles that belong to this group
 */
class Group extends Model
{
    protected $fillable = [
        'application_id', 'name', 'description',
        'number', 'roles_per_member', 'is_required'
    ];

    protected $casts = [
        'is_required' => 'bool'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function groupRoles(): HasMany
    {
        return $this->hasMany(GroupRole::class);
    }
}
