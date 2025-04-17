<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppCharactersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.characters')->delete();
        
        \DB::table('app.characters')->insert(array (
            0 => 
            array (
                'id' => 3,
                'mask_id' => 1,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:55',
                'updated_at' => '2025-04-12 01:58:55',
            ),
            1 => 
            array (
                'id' => 2,
                'mask_id' => 4,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'system',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:58:47',
                'updated_at' => '2025-04-12 01:58:47',
            ),
            2 => 
            array (
                'id' => 1,
                'mask_id' => 3,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'player',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'male',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:50:33',
                'updated_at' => '2025-04-17 02:09:09',
            ),
            3 => 
            array (
                'id' => 4,
                'mask_id' => 2,
                'application_id' => 1,
                'chat_id' => NULL,
                'user_id' => NULL,
                'screen_id' => 1,
                'actor' => 'player',
                'is_confirmed' => true,
                'language' => 'en',
                'gender' => 'female',
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 01:59:03',
                'updated_at' => '2025-04-17 02:09:28',
            ),
        ));
        
        
    }
}