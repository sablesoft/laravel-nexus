<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Mask;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Character>
 */
class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'chat_id' => Chat::factory(),
            'mask_id' => Mask::factory(),
            'user_id' => User::factory(),
        ];
    }
}
