<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AppFactory extends Factory
{
    abstract public function definition();

    /**
     * @param int $wordsMin
     * @param int $wordsMax
     * @return string
     */
    protected function getFakeName(int $wordsMin = 2, int $wordsMax = 2): string
    {
        return implode(' ', array_map('ucfirst', fake()->words(rand($wordsMin, $wordsMax))));
    }
}
