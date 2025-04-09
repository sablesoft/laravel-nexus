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
        $this->call(AppMasksTableSeeder::class);
        $this->call(AppRolesTableSeeder::class);
        $this->call(AppApplicationsTableSeeder::class);
        $this->call(AppScreensTableSeeder::class);
        $this->call(AppTransfersTableSeeder::class);
        $this->call(AppScenariosTableSeeder::class);
        $this->call(AppControlsTableSeeder::class);
        $this->call(AppStepsTableSeeder::class);
        $this->call(AppChatGroupsTableSeeder::class);
        $this->call(AppChatRolesTableSeeder::class);
        $this->call(SequencesSeeder::class);
    }
}
