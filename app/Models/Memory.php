<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\MemoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $user_id
 * @property null|string $title
 * @property null|string $content
 * @property null|string $type
 * @property null|array $meta
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Chat $chat
 * @property-read null|User $user
 */
class Memory extends Model
{
    /** @use HasFactory<MemoryFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'chat_id', 'title', 'content', 'type', 'meta'
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'meta' => 'json'
    ];
}
