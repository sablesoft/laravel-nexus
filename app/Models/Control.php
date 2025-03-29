<?php

namespace App\Models;

use App\Logic\Contracts\NodeContract;
use App\Models\Enums\Command;
use App\Models\Enums\ControlType;
use App\Models\Traits\HasLogic;
use App\Models\Traits\HasSetup;
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
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Screen $screen
 * @property-read null|Scenario $scenario
 */
class Control extends Model implements NodeContract
{
    use HasSetup, HasLogic;

    protected $fillable = [
        'screen_id', 'scenario_id', 'command', 'type',
        'title', 'tooltip', 'description', 'before', 'after',
    ];

    protected $casts = [
        'command' => Command::class,
        'type' => ControlType::class,
        'before' => 'array',
        'after' => 'array',
    ];

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }
}
