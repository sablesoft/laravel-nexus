<?php

namespace App\Models;

use App\Logic\Contracts\LogicContract;
use App\Logic\Process;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasSetup;
use Carbon\Carbon;
use Database\Factories\ScenarioFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property-read Collection<int, Step> $inSteps
 */
class Scenario extends Model implements HasOwnerInterface, LogicContract
{
    /** @use HasFactory<ScenarioFactory> */
    use HasOwner, HasFactory, HasSetup;

    protected $fillable = [
        'user_id', 'code', 'title', 'description', 'before', 'after',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)
            ->orderBy('number');
    }

    public function inSteps(): HasMany
    {
        return $this->hasMany(Step::class, 'nested_id');
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }

    public function getNodes(): \Illuminate\Support\Collection
    {
        return collect($this->steps);
    }

    public function shouldQueue(Process $process): bool
    {
        return !$process->inQueue;
    }

    public function execute(Process $process): void
    {
        // intentionally left blank
    }
}
