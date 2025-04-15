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
                'id' => 115,
                'application_id' => NULL,
                'chat_id' => 32,
                'mask_id' => 3,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-15 01:13:41',
                'updated_at' => '2025-04-15 01:18:03',
            ),
            1 => 
            array (
                'id' => 122,
                'application_id' => NULL,
                'chat_id' => 33,
                'mask_id' => 2,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-15 01:25:58',
                'updated_at' => '2025-04-15 01:29:08',
            ),
            2 => 
            array (
                'id' => 125,
                'application_id' => NULL,
                'chat_id' => 34,
                'mask_id' => 4,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-15 02:05:18',
                'updated_at' => '2025-04-15 02:09:25',
            ),
            3 => 
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
            4 => 
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
            5 => 
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
            6 => 
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
            7 => 
            array (
                'id' => 127,
                'application_id' => NULL,
                'chat_id' => 35,
                'mask_id' => 3,
                'user_id' => 1,
                'screen_id' => 2,
                'is_confirmed' => true,
                'language' => 'ru',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-15 02:14:06',
                'updated_at' => '2025-04-15 02:18:26',
            ),
        ));
        
        
    }
}