<?php

namespace App\Models;

use App\Models\Enums\Command;
use App\Models\Traits\HasSetup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $scenario_id
 * @property null|int $nested_id
 * @property null|Command $command
 * @property null|int $number
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Scenario $scenario
 * @property-read null|Scenario $nestedScenario
 */
class Step extends Model
{
    use HasSetup;

    protected $fillable = [
        'scenario_id', 'nested_id', 'command',
        'number', 'active', 'setup'
    ];

    protected $casts = [
        'command' => Command::class,
        'active' => 'array',
        'setup' => 'array'
    ];

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class, 'scenario_id');
    }

    public function nestedScenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class, 'nested_id');
    }
}
