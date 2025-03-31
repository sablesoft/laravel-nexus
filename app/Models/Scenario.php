<?php

namespace App\Models;

use App\Logic\Contracts\LogicContract;
use App\Logic\Process;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasEffects;
use Carbon\Carbon;
use Database\Factories\ScenarioFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The Scenario model represents a user-defined logic scenario —
 * a composite structure consisting of steps (Step), before/after DSL instructions, and metadata.
 * It implements the LogicContract interface, which means it can be executed via the LogicRunner,
 * nested inside other scenarios, used in UI controls, and run either immediately or via queue.
 *
 * Scenarios are the main building block of user-defined logic on the platform.
 * Each scenario can contain any number of steps (Step), and can itself be nested into other steps.
 *
 * Environment:
 * - Executed via LogicRunner, either directly or through NodeRunner (if nested)
 * - Can be used inside Control elements (input, action) and Step as nested logic
 * - May be deferred to the queue via LogicJob if shouldQueue returns true
 * - Used in the Workshop UI to create, edit, and manage user logic flows
 *
 * @property null|int $id
 * @property null|string $code         - Unique scenario code (can be used for referencing and debugging)
 * @property null|string $title        - Scenario title shown to the user
 * @property null|string $description  - Optional description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read Collection<int, Step> $steps        - Steps in this scenario (executable NodeContract nodes)
 * @property-read Collection<int, Step> $inSteps      - Steps where this scenario is used as nested logic
 * @property-read Collection<int, Control> $inControls - Control elements that use this scenario
 */
class Scenario extends Model implements HasOwnerInterface, LogicContract
{
    /** @use HasFactory<ScenarioFactory> */
    use HasOwner, HasFactory, HasEffects;

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
        return $this->hasMany(Step::class, 'scenario_id');
    }

    public function inControls(): HasMany
    {
        return $this->hasMany(Control::class, 'scenario_id');
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
        return $process->shouldQueue();
    }
}
