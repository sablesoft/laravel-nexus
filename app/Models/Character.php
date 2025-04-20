<?php

namespace App\Models;

use App\Enums\Language;
use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Contracts\HasDslAdapterContract;
use App\Logic\Dsl\Adapters\CharacterDslAdapter;
use App\Logic\Process;
use App\Models\Casts\Behaviors;
use App\Models\Enums\Actor;
use App\Models\Enums\Gender;
use App\Models\Interfaces\Stateful;
use App\Models\Services\BehaviorsCompiler;
use App\Models\Traits\HasBehaviors;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Database\Factories\MaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LogicException;
use Symfony\Component\Intl\Languages;

/**
 * @property null|int $id
 * @property null|int $mask_id
 * @property null|int $application_id
 * @property null|int $chat_id
 * @property null|int $screen_id
 * @property null|string $code
 * @property null|Language $language
 * @property null|Gender $gender
 * @property null|Actor $actor
 * @property null|bool $is_confirmed
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|string $languageName
 * @property-read null|string $genderName
 * @property-read null|Application $application
 * @property-read null|Chat $chat
 * @property-read null|Screen $screen
 * @property-read null|Mask $mask
 * @property-read null|string $maskName
 * @property-read Collection<int, ChatRole> $roles
 * @property-read Collection<int, Memory> $memories
 */
class Character extends Model implements HasDslAdapterContract, Stateful
{
    /** @use HasFactory<MaskFactory> */
    use HasOwner, HasStates, HasBehaviors, HasFactory;

    protected $fillable = [
        'chat_id', 'application_id', 'mask_id', 'screen_id', 'user_id', 'code',
        'actor', 'is_confirmed', 'states', 'language', 'gender', 'behaviors'
    ];

    protected $casts = [
        'is_confirmed' => 'bool',
        'states' => 'array',
        'behaviors' => Behaviors::class,
        'gender' => Gender::class,
        'actor' => Actor::class,
        'language' => Language::class
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public function mask(): BelongsTo
    {
        return $this->belongsTo(Mask::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(ChatRole::class)->withTimestamps();
    }

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public function getMaskNameAttribute(): ?string
    {
        return $this->mask?->name;
    }

    public function getLanguageNameAttribute(): string
    {
        return $this->language->label();
    }

    public function getGenderNameAttribute(): string
    {
        return $this->gender->label();
    }

    public function getDslAdapter(Process $process): DslAdapterContract
    {
        return new CharacterDslAdapter($process, $this);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (self $character) {
            $startScreen = $character->application ?
                $character->application->startScreen :
                $character->chat?->application?->startScreen;
            if (!$startScreen) {
                throw new LogicException('Cannot create character without starting screen!');
            }
            $character->screen_id = $startScreen->id;
            if ($character->chat) {
                $compiler = new BehaviorsCompiler();
                $character->behaviors = $compiler->compile($character);
            }
        });

        static::saving(function (self $character) {
            self::savingAllStates($character);
            $character->language = $character->user?->language ?? 'en';
        });
    }
}
