<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|int $chat_id
 * @property null|string $name
 * @property null|string $description
 * @property null|int $number
 * @property null|int $roles_per_member
 * @property null|bool $is_required
 * @property null|string $allowed
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application             - The application this chat-group belongs to
 * @property-read null|Chat $chat                          - The chat this chat-group belongs to
 * @property-read Collection<int, ChatRole> $roles    - All chat-roles that belong to this chat-group
 */
class ChatGroup extends Model
{
    protected $fillable = [
        'application_id', 'chat_id', 'name', 'description',
        'number', 'roles_per_member', 'is_required', 'allowed'
    ];

    protected $casts = [
        'is_required' => 'bool',
        'name' => LocaleString::class,
        'description' => LocaleString::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(ChatRole::class);
    }
}
