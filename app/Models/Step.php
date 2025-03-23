<?php

namespace App\Models;

use App\Models\Enums\Command;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $scenario_id
 * @property null|int $nested_id
 * @property null|Command $command
 * @property null|int $number
 * @property null|array $active
 * @property null|array $constants
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Scenario $nestedScenario
 */
class Step extends Model
{
    protected $fillable = [
        'scenario_id', 'nested_id', 'command',
        'number', 'active', 'constants'
    ];

    protected $casts = [
        'command' => Command::class,
        'active' => 'array',
        'constants' => 'array'
    ];

    public function nestedScenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class, 'nested_id');
    }
}
