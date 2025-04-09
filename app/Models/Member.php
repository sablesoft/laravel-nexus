<?php

namespace App\Models;

use App\Logic\Contracts\HasDslAdapterContract;
use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasDslAdapter;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Database\Factories\MaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\HasOwner;
use LogicException;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $mask_id
 * @property null|int $screen_id
 * @property null|bool $is_confirmed
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat
 * @property-read null|Screen $screen
 * @property-read null|Mask $mask
 * @property-read null|string $maskName
 * @property-read Collection<int, Memory>|Memory[] $memories
 */
class Member extends Model implements HasDslAdapterContract, Stateful
{
    /** @use HasFactory<MaskFactory> */
    use HasOwner, HasStates, HasFactory, HasDslAdapter;

    protected $fillable = [
        'chat_id', 'mask_id', 'screen_id', 'user_id', 'is_confirmed', 'states'
    ];

    protected $casts = [
        'is_confirmed' => 'bool',
        'states' => 'array'
    ];

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

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public function getMaskNameAttribute(): ?string
    {
        return $this->mask?->name;
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (self $member) {
            $startScreen = $member->chat?->application?->startScreen;
            if (!$startScreen) {
                throw new LogicException('Cannot create member without starting screen!');
            }
            $member->screen_id = $startScreen->id;
        });

        static::saving([self::class, 'savingAllStates']);
    }
}
