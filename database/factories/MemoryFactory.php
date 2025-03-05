<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Memory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Memory>
 */
class MemoryFactory extends AppFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_id' => Chat::factory(),
            'title' => $this->getFakeName(2, 5),
            'content' => fake()->text(),
            'type' => fake()->word(),
        ];
    }
}
