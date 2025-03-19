<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Chat;
use App\Models\Mask;
use App\Models\Memory;
use App\Models\Scenario;
use App\Models\Screen;
use App\Models\Transfer;
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

        $masks = Mask::factory()->for($user)->count(7)->create();
        $applications = Application::factory()->for($user)->count(3)->create();
        $screens = Screen::factory()->for($user)->recycle($applications)->count(6)->create();
        $transfers = Transfer::factory()->recycle($applications)->recycle($screens);
        $scenarios = Scenario::factory()->for($user)->recycle($screens)->count(14)->create();
        $chats = Chat::factory()->for($user)->recycle($masks)->recycle($applications)->count(5)->create();
        $memories = Memory::factory()->recycle($chats)->count(30)->create();
    }
}
