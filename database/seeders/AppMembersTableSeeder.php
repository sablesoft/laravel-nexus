<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppMembersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.members')->delete();
        
        \DB::table('app.members')->insert(array (
            0 => 
            array (
                'id' => 101,
                'application_id' => NULL,
                'chat_id' => 28,
                'mask_id' => 4,
                'user_id' => 1,
                'screen_id' => 9,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-14 21:58:04',
                'updated_at' => '2025-04-14 22:16:59',
            ),
            1 => 
            array (
                'id' => 103,
                'application_id' => NULL,
                'chat_id' => 29,
                'mask_id' => 3,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-14 22:26:36',
                'updated_at' => '2025-04-14 22:30:46',
            ),
            2 => 
            array (
                'id' => 1,
                'application_id' => 1,
                'chat_id' => NULL,
                'mask_id' => 3,
                'user_id' => NULL,
                'screen_id' => 1,
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:50:33',
                'updated_at' => '2025-04-12 01:50:33',
            ),
            3 => 
            array (
                'id' => 3,
                'application_id' => 1,
                'chat_id' => NULL,
                'mask_id' => 1,
                'user_id' => NULL,
                'screen_id' => 1,
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:55',
                'updated_at' => '2025-04-12 01:58:55',
            ),
            4 => 
            array (
                'id' => 2,
                'application_id' => 1,
                'chat_id' => NULL,
                'mask_id' => 4,
                'user_id' => NULL,
                'screen_id' => 1,
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:47',
                'updated_at' => '2025-04-12 01:58:47',
            ),
            5 => 
            array (
                'id' => 4,
                'application_id' => 1,
                'chat_id' => NULL,
                'mask_id' => 2,
                'user_id' => NULL,
                'screen_id' => 1,
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:59:03',
                'updated_at' => '2025-04-12 01:59:03',
            ),
        ));
        
        
    }
}