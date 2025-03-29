<?php

namespace App\Models;

use App\Logic\Contracts\LogicContract;
use App\Logic\Contracts\NodeContract;
use App\Models\Traits\HasSetup;
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
 * @property null|string $description
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|Screen $screenFrom
 * @property-read null|Screen $screenTo
 */
class Transfer extends Model implements NodeContract
{
    use HasFactory, HasSetup;

    protected $fillable = [
        'screen_from_id', 'screen_to_id', 'code', 'title', 'tooltip',
        'description', 'before', 'after',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    public function screenFrom(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_from_id');
    }

    public function screenTo(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_to_id');
    }

    public function getLogic(): ?LogicContract
    {
        return null;
    }
}
