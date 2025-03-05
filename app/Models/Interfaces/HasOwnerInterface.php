<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int|null $user_id
 */
interface HasOwnerInterface
{
    public function user(): BelongsTo;

    /**
     * @param HasOwnerInterface $model
     * @return void
     */
    public static function assignCurrentUser(HasOwnerInterface $model): void;
}
