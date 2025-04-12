<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
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
 * @property-read Collection<int, Role> $roles    - All chat-roles that belong to this chat-group
 */
class Group extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    protected $casts = [
        'name' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
