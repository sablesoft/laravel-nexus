<?php

namespace Database\Factories;

use App\Models\Screen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Screen>
 */
class ScreenFactory extends AppFactory
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
            'title' => $this->getFakeName(1, 2),
            'description' => fake()->text(),
        ];
    }
}
