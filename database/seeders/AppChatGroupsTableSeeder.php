<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppChatGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.chat_groups')->delete();
        
        
        
    }
}