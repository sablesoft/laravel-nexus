<?php

namespace App\Models;

use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Interfaces\Stateful;
use App\Models\Traits\HasBehaviors;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasStates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property null|int $id
 * @property null|string $name
 * @property null|string $description
 * @property null|bool $is_public
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 */
class Role extends Model implements HasOwnerInterface, Stateful
{
    use HasOwner, HasBehaviors, HasStates, HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'is_public', 'behaviors', 'states'
    ];

    protected $casts = [
        'is_public' => 'bool',
        'behaviors' => 'array',
        'states' => 'array',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
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
