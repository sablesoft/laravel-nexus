<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ScenarioFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;

/**
 * @property null|int $id
 * @property null|string $title
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Screen>|Screen[] $screens
 */
class Scenario extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ScenarioFactory> */
    use HasOwner, HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description'
    ];

    public function screens(): BelongsToMany
    {
        return $this->belongsToMany(Screen::class)->withTimestamps();
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
