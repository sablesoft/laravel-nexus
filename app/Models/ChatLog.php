<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $member_id
 * @property null|string $effect_key
 * @property null|string $message
 * @property null|array $context
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat
 * @property-read null|Member $member
 */
class ChatLog extends Model
{
    protected $fillable = [
        'chat_id', 'member_id', 'effect_key', 'message', 'context'
    ];

    protected $casts = [
        'context' => 'array'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
