<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ScreenFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;

/**
 * @property null|int $id
 * @property null|string $title
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Application>|Application[] $applications
 * @property-read Collection<int, Scenario>|Scenario[] $scenarios
 */
class Screen extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ScreenFactory> */
    use HasOwner, HasFactory, HasImage;

    protected $fillable = [
        'user_id', 'title', 'description'
    ];

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class)
            ->withPivot('is_default')
            ->withTimestamps();
    }

    public function scenarios(): BelongsToMany
    {
        return $this->belongsToMany(Scenario::class)
            ->withPivot('is_default')
            ->withTimestamps();
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
