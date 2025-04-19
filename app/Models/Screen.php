<?php

namespace App\Models;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Contracts\HasEffectsContract;
use App\Logic\Dsl\Adapters\ScreenDslAdapter;
use App\Logic\Process;
use App\Logic\Validators\QueryExpressionValidator;
use App\Models\Casts\LocaleString;
use App\Models\Interfaces\HasNotesInterface;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasInit;
use App\Models\Traits\HasNotes;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasEffects;
use App\Models\Traits\HasStates;
use App\Models\Traits\UI;
use Carbon\Carbon;
use Database\Factories\ScreenFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The Screen model represents a visual screen within a user-defined application (Application),
 * where the screen's messages, controls (Control), and transfers (Transfer) are placed.
 * Each screen includes a mandatory DSL `query` used to filter displayed messages (Memory),
 * along with optional `before` and `after` DSL instructions, a message `template` for rendering,
 * and an `is_default` flag indicating whether the screen is the default one.
 *
 * Implements HasDslAdapterContract, which allows the screen to be wrapped in a DSL adapter inside a Process.
 * This enables DSL expressions to access screen properties directly, like `screen.code` or `screen.title`.
 *
 * Environment:
 * - Used by the Chat\Play Livewire component as the currently active screen
 * - Applies Dsl::apply on the Memory model via the `query` field to filter messages
 * - TODO: The `template` field will define how messages are rendered and additional UI elements
 * - Contains Control elements that act as NodeContract nodes (executed via NodeRunner)
 * - Linked to Transfer entities that define possible screen-to-screen transitions
 * - Used in the Workshop UI for building and managing user applications
 * - Used internally in Process as the DSL adapter `screen` (wrapped via ModelDslAdapter or a custom adapter)
 *
 * @property null|int $id
 * @property null|int $application_id     - ID of the parent application
 * @property null|string $code            - Unique code of the screen
 * @property null|string $title           - Display name of the screen
 * @property null|string $description     - Optional description
 * @property null|bool $is_start          - Whether this is the start screen
 * @property null|string $query           - DSL expression for filtering messages (Memory) on this screen
 * @property null|string $template        - Message rendering template
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application            - The parent application this screen belongs to
 * @property-read Collection<int, Transfer> $transfers     - Outgoing screen transitions (screen_from_id)
 * @property-read Collection<int, Transfer> $transfersFrom - Incoming screen transitions (screen_to_id)
 * @property-read Collection<int, Control> $controls       - Controls placed on this screen
 */
class Screen extends Model implements HasOwnerInterface, HasNotesInterface, HasEffectsContract, HasDslAdapterContract, Stateful
{
    /** @use HasFactory<ScreenFactory> */
    use HasOwner, HasNotes, HasFactory, HasImage, HasEffects, HasInit, HasStates, UI;

    const DEFAULT_DSL_QUERY = '":type" == screen.code';

    protected $fillable = [
        'user_id', 'application_id', 'code', 'title', 'description',
        'visible_condition', 'enabled_condition', 'states',
        'is_start', 'query', 'init', 'before', 'after', 'template',
    ];

    protected $casts = [
        'is_start' => 'boolean',
        'states' => 'array',
        'init' => 'array',
        'before' => 'array',
        'after' => 'array',
        'title' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'screen_from_id');
    }

    public function transfersFrom(): HasMany
    {
        return $this->hasMany(Transfer::class, 'screen_to_id');
    }

    public function controls(): HasMany
    {
        return $this->hasMany(Control::class);
    }

    public function getDslAdapter(Process $process): DslAdapterContract
    {
        return new ScreenDslAdapter($process, $this);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (self $screen) {
            self::assignCurrentUser($screen);
            if (empty($screen->query)) {
                $screen->query = config('dsl.screen_query', self::DEFAULT_DSL_QUERY);
            }
            QueryExpressionValidator::validate($screen->query);
        });

        static::updating(function (self $screen) {
            if ($screen->isDirty('query') && empty(trim($screen->query))) {
                $screen->query = config('dsl.screen_query', self::DEFAULT_DSL_QUERY);
            }
            QueryExpressionValidator::validate($screen->query);
            if ($screen->isDirty('is_start') && $screen->is_start) {
                Screen::where('application_id', $screen->application_id)
                    ->where('id', '!=', $screen->id)
                    ->update(['is_start' => false]);
            }
        });

        static::saving([self::class, 'savingAllStates']);
    }
}
