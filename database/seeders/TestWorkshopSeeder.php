<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Chat;
use App\Models\Mask;
use App\Models\Memory;
use App\Models\Scenario;
use App\Models\Screen;
use Illuminate\Database\Seeder;
use App\Models\User;

class TestWorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::where('email', config('admin.email'))->first();
        if (!$user) {
            echo "Please seed user first!. \r\n";
            return;
        }

        $masks = Mask::factory()->for($user)->count(5)->create();
        $scenarios = Scenario::factory()->for($user)->count(5)->create();
        $screens = Screen::factory()->for($user)->recycle($scenarios)->count(3)->create();
        $applications = Application::factory()->for($user)->recycle($screens)->count(2)->create();
        $chats = Chat::factory()->for($user)->recycle($masks)->recycle($applications)->count(4)->create();
        $memories = Memory::factory()->recycle($chats)->count(10)->create();
    }
}
