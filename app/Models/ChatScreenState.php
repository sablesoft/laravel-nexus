<?php

namespace App\Models;

use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasStates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $chat_id
 * @property null|int $screen_id
 *
 * @property-read null|Chat $chat
 * @property-read null|Screen $screen
 */
class ChatScreenState extends Model implements Stateful
{
    use HasStates;

    protected $fillable = [
        'chat_id', 'screen_id', 'states', 'statesString'
    ];

    protected $casts = [
        'states' => 'array',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving([self::class, 'savingAllStates']);
    }
}
