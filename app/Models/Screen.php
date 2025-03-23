<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ScreenFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Interfaces\HasOwnerInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $application_id
 * @property null|string $code
 * @property null|string $title
 * @property null|string $description
 * @property null|bool $is_default
 * @property null|bool $constants
 * @property null|string $template
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Application $application
 * @property-read Collection<int, Transfer> $transfers
 * @property-read Collection<int, Control> $controls
 */
class Screen extends Model implements HasOwnerInterface
{
    /** @use HasFactory<ScreenFactory> */
    use HasOwner, HasFactory, HasImage;

    protected $fillable = [
        'user_id', 'application_id', 'code', 'title', 'description',
        'is_default', 'constants', 'template',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'constants' => 'array'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'screen_from_id');
    }

    public function controls(): HasMany
    {
        return $this->hasMany(Control::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
