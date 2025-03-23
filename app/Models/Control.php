<?php

namespace App\Models;

use App\Models\Enums\Command;
use App\Models\Enums\ControlType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $screen_id
 * @property null|int $scenario_id
 * @property null|Command $command
 * @property null|ControlType $type
 * @property null|string $title
 * @property null|string $tooltip
 * @property null|array $active
 * @property null|array $constants
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Scenario $scenario
 */
class Control extends Model
{
    protected $fillable = [
        'screen_id', 'scenario_id', 'command', 'type',
        'title', 'tooltip', 'active', 'constants'
    ];

    protected $casts = [
        'command' => Command::class,
        'type' => ControlType::class,
        'active' => 'array',
        'constants' => 'array'
    ];

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }
}
