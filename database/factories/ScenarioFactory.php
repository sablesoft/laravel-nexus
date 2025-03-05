<?php

namespace Database\Factories;

use App\Models\Scenario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scenario>
 */
class ScenarioFactory extends AppFactory
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
            'title' => $this->getFakeName(1,2),
            'description' => fake()->text(),
        ];
    }
}
