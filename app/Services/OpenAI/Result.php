<?php

namespace App\Services\OpenAI;

use Illuminate\Contracts\Support\Arrayable;
use App\Models\User;

class Result implements Arrayable
{
    use HasResult;

    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
