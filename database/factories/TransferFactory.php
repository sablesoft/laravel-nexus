<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Screen;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferFactory extends Factory
{
    protected $model = Transfer::class;

    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'screen_from_id' => Screen::factory(),
            'screen_to_id' => Screen::factory(),
            'code' => $this->faker->text(100),
            'title' => $this->faker->word(),
            'tooltip' => $this->faker->text(),
        ];
    }
}
