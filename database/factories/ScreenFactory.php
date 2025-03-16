<?php

namespace Database\Factories;

use App\Models\Application;
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
        $title = $this->getFakeName(1, 2);
        return [
            'user_id' => User::factory(),
            'application_id' => Application::factory(),
            'title' => $title,
            'code' => \Str::kebab($title),
            'description' => fake()->text(),
        ];
    }
}
