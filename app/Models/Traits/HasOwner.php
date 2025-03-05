<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Interfaces\HasOwnerInterface;

/**
 * @property int|null $user_id
 * @property-read User|null $user
 */
trait HasOwner
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param HasOwnerInterface $model
     * @return void
     * @noinspection PhpDynamicFieldDeclarationInspection
     */
    public static function assignCurrentUser(HasOwnerInterface $model): void
    {
        if (!$model->user_id) {
            $model->user_id = Auth::id();
        }
    }
}
