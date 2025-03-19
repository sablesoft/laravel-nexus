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
        $this->call(PublicUsersTableSeeder::class);
        $this->call(AppImagesTableSeeder::class);
        $this->call(AppApplicationsTableSeeder::class);
        $this->call(AppScreensTableSeeder::class);
        $this->call(AppScenariosTableSeeder::class);
        $this->call(AppMasksTableSeeder::class);
        $this->call(SequencesSeeder::class);
    }
}
