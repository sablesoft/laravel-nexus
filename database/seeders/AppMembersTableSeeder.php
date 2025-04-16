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
            1 => 
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
            2 => 
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
            3 => 
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
            4 => 
            array (
                'id' => 8,
                'application_id' => NULL,
                'chat_id' => 1,
                'mask_id' => 2,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-16 03:33:33',
                'updated_at' => '2025-04-16 03:44:52',
            ),
            5 => 
            array (
                'id' => 14,
                'application_id' => NULL,
                'chat_id' => 3,
                'mask_id' => 1,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-16 03:55:27',
                'updated_at' => '2025-04-16 04:00:09',
            ),
            6 => 
            array (
                'id' => 9,
                'application_id' => NULL,
                'chat_id' => 2,
                'mask_id' => 3,
                'user_id' => 1,
                'screen_id' => 9,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-16 03:47:30',
                'updated_at' => '2025-04-16 04:09:03',
            ),
            7 => 
            array (
                'id' => 19,
                'application_id' => NULL,
                'chat_id' => 4,
                'mask_id' => 4,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-16 04:02:12',
                'updated_at' => '2025-04-16 04:10:42',
            ),
        ));
        
        
    }
}