<?php

namespace App\Models;

use App\Models\Casts\LocaleString;
use App\Models\Enums\Gender;
use App\Models\Interfaces\HasOwnerInterface;
use App\Models\Traits\HasImage;
use App\Models\Traits\HasOwner;
use App\Models\Traits\HasPortrait;
use Carbon\Carbon;
use Database\Factories\MaskFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property null|int $id
 * @property null|int $user_id
 * @property null|string $name
 * @property null|string $description
 * @property null|Gender $gender
 * @property null|boolean $is_public
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 *
 * @property-read null|string $title
 * @property-read null|User $user
 * @property-read Collection<int, Character>|Character[] $characters
 */
class Mask extends Model implements HasOwnerInterface
{
    /** @use HasFactory<MaskFactory> */
    use HasOwner, HasFactory, HasImage, HasPortrait;

    protected $fillable = [
        'user_id', 'image_id', 'portrait_id',
        'name', 'description', 'is_public', 'gender'
    ];

    protected $casts = [
        'name' => LocaleString::class,
        'description' => LocaleString::class,
        'gender' => Gender::class,
    ];

    public function getTitleAttribute(): ?string
    {
        return $this->name;
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public static function boot(): void
    {
        parent::boot();
        static::creating([self::class, 'assignCurrentUser']);
    }
}
