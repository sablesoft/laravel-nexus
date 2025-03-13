<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\MaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\HasOwner;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $mask_id
 * @property null|bool $is_confirmed
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat
 * @property-read null|Mask $mask
 * @property-read null|string $mask_name
 * @property-read Collection<int, Memory>|Memory[] $memories
 */
class Member extends Model
{
    /** @use HasFactory<MaskFactory> */
    use HasOwner, HasFactory;

    protected $fillable = [
        'chat_id', 'mask_id', 'user_id', 'is_confirmed'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
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
}
