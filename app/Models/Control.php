<?php

namespace App\Models;

use App\Logic\Contracts\NodeContract;
use App\Models\Casts\LocaleString;
use App\Models\Enums\ControlType;
use App\Models\Traits\HasLogic;
use App\Models\Traits\HasEffects;
use App\Models\Traits\UI;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Control model represents a user-facing UI element on a screen — either a button or an input field.
 * It implements the NodeContract interface, which allows it to be executed via NodeRunner and include
 * an associated logic scenario (Scenario), as well as before/after DSL blocks for additional behavior.
 *
 * Control is one of the key interface components responsible for triggering logic flows:
 * - Type `Action` represents a button that, when clicked, runs a scenario.
 * - Type `Input` captures user text input and passes it into the Process (under the `ask` key).
 *
 * Environment:
 * - Executed via NodeRunner when the user clicks a button or submits input
 * - Can contain an associated Scenario executed as a LogicContract
 * - Used by the Chat\Play component to render footer controls (actions, inputs)
 * - Executed within a Process that holds chat, screen, character, ask, etc., in context
 *
 * @property null|int $id
 * @property null|int $screen_id       - ID of the screen this control belongs to
 * @property null|int $scenario_id     - ID of the logic scenario associated with this control
 * @property null|ControlType $type    - Control type (Action or Input)
 * @property null|string $title        - Button label shown in the UI
 * @property null|string $tooltip      - Tooltip shown on hover
 * @property null|string $description  - Technical/editorial description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Screen $screen      - Parent screen this control belongs to
 * @property-read null|Scenario $scenario  - Scenario to be executed when this control is activated
 */
class Control extends Model implements NodeContract
{
    use HasEffects, HasLogic, UI;

    protected $fillable = [
        'screen_id', 'scenario_id', 'type',
        'visible_condition', 'enabled_condition',
        'title', 'tooltip', 'description', 'before', 'after',
    ];

    protected $casts = [
        'type' => ControlType::class,
        'before' => 'array',
        'after' => 'array',
        'title' => LocaleString::class,
        'tooltip' => LocaleString::class,
        'description' => LocaleString::class,
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
