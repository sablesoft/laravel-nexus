<?php

namespace Database\Factories;

use App\Models\Mask;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mask>
 */
class MaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'description' => fake()->text(),
            'is_public' => fake()->boolean()
        ];
    }
}
