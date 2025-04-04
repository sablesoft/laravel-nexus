<?php

namespace App\Models;

use App\Models\Traits\HasOwner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property null|int $id
 * @property null|string $name
 * @property null|string $description
 * @property null|bool $is_public
 * @property null|array $behaviors
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 */
class Role extends Model
{
    use HasOwner;

    protected $fillable = [
        'user_id', 'name', 'description', 'is_public', 'behaviors'
    ];

    protected $casts = [
        'is_public' => 'bool',
        'behaviors' => 'array'
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
