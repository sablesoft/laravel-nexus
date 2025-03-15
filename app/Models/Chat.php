<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ChatFactory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enums\ChatStatus;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|string $title
 * @property null|int $seats
 * @property null|ChatStatus $status
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application
 * @property-read Collection<int, Memory>|Memory[] $memories
 * @property-read Collection<int, Member>|Member[] $members
 * @property-read Collection<int, Member>|Member[] $freeSeats
 * @property-read Collection<int, Member>|Member[] $takenSeats
 */
class Chat extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ChatFactory> */
    use HasOwner, HasFactory, BroadcastsEvents;

    protected $fillable = [
        'user_id', 'application_id', 'title', 'status'
    ];

    protected $casts = [
        'status' => ChatStatus::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function memories(): HasMany
    {
        return $this->hasMany(Memory::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function freeSeats(): HasMany
    {
        return $this->members()->whereNull('user_id');
    }

    public function takenSeats(): HasMany
    {
        return $this->members()->whereNotNull('user_id');
    }

    public function allowedSeatsCount(): int
    {
        return $this->seats - $this->takenSeats()->count();
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }

    public function broadcastOn(string $event): array
    {
        return [new Channel('chats.index')];
    }

    public function broadcastAs(string $event): ?string
    {
        return 'refresh';
    }

    public function broadcastWith(string $event): array
    {
        return  ['id' => $this->id];
    }
}
