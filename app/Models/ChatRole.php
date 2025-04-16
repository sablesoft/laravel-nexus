<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasBehaviors;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|int $chat_group_id
 * @property null|int $role_id
 * @property null|string $name
 * @property null|string $code
 * @property null|string $description
 * @property null|string $allowed
 * @property null|int $limit
 * @property null|int $screen_id
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application  - The parent application this group-role belongs to
 * @property-read null|ChatGroup $chatGroup      - The parent group this group-role belongs to
 * @property-read null|Role $role                - The global role this group-role belongs to
 * @property-read null|Screen $screen            - TODO: The initial screen this group-role starts from?
 */
class ChatRole extends Model implements Stateful
{
    use HasBehaviors, HasStates;

    protected $fillable = [
        'application_id', 'chat_group_id', 'role_id', 'allowed',
        'name', 'code', 'description', 'limit', 'screen_id', 'states',
        'statesString', 'behaviors', 'behaviorsString'
    ];

    protected $casts = [
        'states' => 'array',
        'behaviors' => 'array',
        'name' => LocaleString::class,
        'description' => LocaleString::class
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function chatGroup(): BelongsTo
    {
        return $this->belongsTo(ChatGroup::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating(function(self $model) {
            if ($model->role) {
                $model->states = $model->role->states;
                $model->behaviors = $model->role->behaviors;
            }
        });
        static::saving(function(self $model) {
            if ($model->isDirty('states')) {
                $states = $model->states ?: [];
                foreach ($states as $key => $state) {
                    $model->validateState($key, $state);
                }
            }
        });
    }
}
