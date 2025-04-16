<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $character_id
 * @property null|string $effect_key
 * @property null|string $message
 * @property null|array $context
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat
 * @property-read null|Character $character
 */
class ChatLog extends Model
{
    protected $fillable = [
        'chat_id', 'character_id', 'effect_key', 'message', 'context'
    ];

    protected $casts = [
        'context' => 'array'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
