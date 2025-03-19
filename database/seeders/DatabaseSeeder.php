<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ApplicationsTableSeeder::class);
        $this->call(ScreensTableSeeder::class);
        $this->call(ScenariosTableSeeder::class);
        $this->call(MasksTableSeeder::class);
        $this->call(SequencesSeeder::class);
    }
}
