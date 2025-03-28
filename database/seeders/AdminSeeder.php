<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $name = config('admin.name');
        $password = config('admin.pass');

        if (!$email || !$name || !$password) {
            echo "Admin config missing. Skipping seeder.\r\n";
            return;
        }

        if (!User::whereEmail($email)->exists()) {
            echo "Creating admin user... \r\n";

            User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }
    }
}
