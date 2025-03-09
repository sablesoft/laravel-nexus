<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Mask;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'chat_id' => Chat::factory(),
            'mask_id' => Mask::factory(),
            'user_id' => User::factory(),
        ];
    }
}
