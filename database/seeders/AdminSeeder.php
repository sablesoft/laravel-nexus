<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (!$email = config('admin.email')) {
            echo "Admin email not provided";
            return;
        }
        if (!$name = config('admin.name')) {
            echo "Admin name not provided";
            return;
        }
        if (!$password = config('admin.pass')) {
            echo "Admin pass not provided";
            return;
        }

        if (!User::whereEmail($email)->first()) {
            echo "Creating admin user... \r\n";
            User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
        }
    }
}
