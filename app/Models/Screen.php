<?php

namespace App\Models;

use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Dsl\ExpressionQueryRegistry;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasDslAdapter;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasSetup;
use Carbon\Carbon;
use Database\Factories\ScreenFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|string $code
 * @property null|string $title
 * @property null|string $description
 * @property null|bool $is_default
 * @property null|string $query
 * @property null|string $template
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application
 * @property-read Collection<int, Transfer> $transfers
 * @property-read Collection<int, Transfer> $transfersFrom
 * @property-read Collection<int, Control> $controls
 */
class Screen extends Model implements HasOwnerInterface, HasDslAdapterContract
{
    /** @use HasFactory<ScreenFactory> */
    use HasOwner, HasFactory, HasImage, HasSetup, HasDslAdapter;

    const DEFAULT_DSL_QUERY = '":type" == screen.code';

    protected $fillable = [
        'user_id', 'application_id', 'code', 'title', 'description',
        'is_default', 'query', 'before', 'after', 'template',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'before' => 'array',
        'after' => 'array',
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

    public static function allowedDslVariables(): array
    {
        // todo
        return [
            'screen', 'chat', 'application', 'member', 'mask',
            'members', 'onlineMembers', 'offlineMembers'
        ];
    }

    public static function validateDslQuery(string $value): ?\Throwable
    {
        try {
            $el = new ExpressionLanguage();
            ExpressionQueryRegistry::register($el);
            $el->parse($value, self::allowedDslVariables());
        } catch (SyntaxError|\RuntimeException $e) {
            return $e;
        }

        return null;
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (self $screen) {
            self::assignCurrentUser($screen);
            if (empty($screen->query)) {
                $screen->query = config('dsl.screen_query', self::DEFAULT_DSL_QUERY);
            }
            if ($error = Screen::validateDslQuery($screen->query)) {
                throw new \InvalidArgumentException("Invalid DSL query: " . $error->getMessage());
            }
        });

        static::updating(function (self $screen) {
            if ($screen->isDirty('query') && empty(trim($screen->query))) {
                $screen->query = config('dsl.screen_query', self::DEFAULT_DSL_QUERY);
            }
            if ($error = Screen::validateDslQuery($screen->query)) {
                throw new \InvalidArgumentException("Invalid DSL query: " . $error->getMessage());
            }
        });
    }
}
