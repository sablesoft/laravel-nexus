<?php

namespace App\Models;

use App\Logic\Contracts\NodeContract;
use App\Models\Casts\LocaleString;
use App\Models\Interfaces\HasNotesInterface;
use App\Models\Traits\HasLogic;
use App\Models\Traits\HasEffects;
use App\Models\Traits\HasNotes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Step model represents an individual executable node inside a Scenario.
 * Each step may contain before/after DSL instructions and optionally reference a nested Scenario,
 * allowing deep logical composition.
 *
 * Implements NodeContract, making it executable via NodeRunner, and includes HasEffects and HasLogic traits.
 * This allows each step to function both as an atomic unit of logic and as a wrapper for nested logic blocks.
 *
 * Steps are ordered within their parent scenario by the `number` field.
 *
 * Environment:
 * - Executed via NodeRunner as part of a scenario execution
 * - Can contain a nested scenario as logic, allowing reuse and modular design
 * - Appears in the Workshop UI as part of scenario editing
 * - Included in logic flows orchestrated by LogicRunner
 *
 * @property null|int $id
 * @property null|int $parent_id         - ID of the parent scenario
 * @property null|int $scenario_id         - ID of the nested scenario (if any)
 * @property null|int $number              - Step number (used for ordering)
 * @property null|string $name           - Optional technical or editor-facing name
 * @property null|string $description      - Optional technical or editor-facing description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Scenario $parent   - Parent scenario this step belongs to
 * @property-read null|Scenario $scenario         - Nested scenario executed as logic
 */
class Step extends Model implements NodeContract, HasNotesInterface
{
    use HasNotes, HasEffects, HasLogic;

    protected $fillable = [
        'parent_id', 'scenario_id', 'number',
        'name', 'description', 'before', 'after'
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'name' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Scenario::class, 'parent_id');
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(Scenario::class);
    }

    public function getCode(): string
    {
        $prefix = $this->parent?->getCode();
        $prefix = $prefix ? "$prefix." : '';

        return $prefix . 'step.'. $this->number;
    }
}
