<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ScenarioFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|string $code
 * @property null|string $title
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Step> $steps
 */
class Scenario extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ScenarioFactory> */
    use HasOwner, HasFactory;

    protected $fillable = [
        'user_id', 'code', 'title', 'description'
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)
            ->orderBy('number');
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
