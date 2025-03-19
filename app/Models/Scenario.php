<?php

namespace App\Models;

use App\Models\Enums\ScenarioType;
use Carbon\Carbon;
use Database\Factories\ScenarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;

/**
 * @property null|int $id
 * @property null|int $screen_id
 * @property null|string $code
 * @property null|ScenarioType $type
 * @property null|string $title
 * @property null|string $tooltip
 * @property null|string $description
 * @property null|bool $is_default
 * @property null|array $constants
 * @property null|array $active
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 */
class Scenario extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ScenarioFactory> */
    use HasOwner, HasFactory;

    protected $fillable = [
        'user_id', 'screen_id', 'code', 'type', 'title', 'tooltip',
        'description', 'is_default', 'constants', 'active'
    ];

    protected $casts = [
        'type' => ScenarioType::class,
        'is_default' => 'boolean',
        'constants' => 'array',
        'active' => 'array'
    ];

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
