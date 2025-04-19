<?php

namespace App\Models;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Models\Casts\LocaleString;
use App\Models\Interfaces\HasNotesInterface;
use App\Models\Traits\HasEffects;
use App\Models\Traits\HasNotes;
use App\Models\Traits\UI;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * The Transfer model represents a logical transition (node) between two screens in a user application.
 * It is an interactive element that is usually rendered as a button in the chat footer
 * and allows the user to move from one screen (screen_from) to another (screen_to).
 *
 * Implements the NodeContract, meaning it can be executed via NodeRunner,
 * and supports before/after DSL blocks for custom logic execution before or after the transition.
 * However, unlike other node types, it does not contain embedded logic.
 *
 * Environment:
 * - Executed via NodeRunner when a transfer button is clicked
 * - Used in the Chat\Play component to render transitions in the footer
 * - May contain before/after DSL blocks to control navigation conditions or effects
 *
 * @property null|int $id
 * @property null|int $screen_from_id   - ID of the screen from which this transfer originates
 * @property null|int $screen_to_id     - ID of the destination screen
 * @property null|string $title         - Displayed title of the transfer (usually shown on the button)
 * @property null|string $tooltip       - Tooltip shown on hover
 * @property null|string $description   - Optional internal/editorial description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|string $code        - Unique code of the transfer
 * @property-read null|Screen $screenFrom  - Source screen of the transfer
 * @property-read null|Screen $screenTo    - Target screen of the transfer
 */
class Transfer extends Model implements NodeContract, HasNotesInterface
{
    use HasFactory, HasNotes, HasEffects, UI;

    protected $fillable = [
        'screen_from_id', 'screen_to_id', 'title', 'tooltip',
        'visible_condition', 'enabled_condition',
        'description', 'before', 'after',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'title' => LocaleString::class,
        'tooltip' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function getCodeAttribute(): ?string
    {
        return $this->screen_from_id ."|". $this->screen_to_id;
    }

    public function screenFrom(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_from_id');
    }

    public function screenTo(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_to_id');
    }

    public function getLogic(): ?LogicContract
    {
        return null;
    }
}
