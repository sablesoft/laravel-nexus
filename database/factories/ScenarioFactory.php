<?php

namespace Database\Factories;

use App\Models\Enums\ScenarioType;
use App\Models\Scenario;
use App\Models\Screen;
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
        $title = $this->getFakeName(1, 2);
        return [
            'user_id' => User::factory(),
            'screen_id' => Screen::factory(),
            'code' => \Str::kebab($title),
            'title' => $title,
            'tooltip' => $this->faker->text(100),
            'type' => $this->faker->randomElement(ScenarioType::values()),
            'description' => fake()->text(),
        ];
    }
}
