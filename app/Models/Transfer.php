<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|int $id
 * @property null|int $screen_from_id
 * @property null|int $screen_to_id
 * @property null|string $code
 * @property null|string $title
 * @property null|string $tooltip
 * @property null|array $active
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Screen $screenFrom
 * @property-read null|Screen $screenTo
 */
class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_from_id', 'screen_to_id', 'code', 'title', 'tooltip', 'active'
    ];

    protected $casts = [
        'active' => 'array',
    ];

    public function screenFrom(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_from_id');
    }

    public function screenTo(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_to_id');
    }
}
