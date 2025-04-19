<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppCharacterChatRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.character_chat_role')->delete();
        
        \DB::table('app.character_chat_role')->insert(array (
            0 => 
            array (
                'character_id' => 4,
                'chat_role_id' => 2,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            1 => 
            array (
                'character_id' => 4,
                'chat_role_id' => 7,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            2 => 
            array (
                'character_id' => 2,
                'chat_role_id' => 8,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            3 => 
            array (
                'character_id' => 2,
                'chat_role_id' => 4,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            4 => 
            array (
                'character_id' => 3,
                'chat_role_id' => 1,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            5 => 
            array (
                'character_id' => 3,
                'chat_role_id' => 6,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            6 => 
            array (
                'character_id' => 1,
                'chat_role_id' => 3,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            7 => 
            array (
                'character_id' => 1,
                'chat_role_id' => 5,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            8 => 
            array (
                'character_id' => 1,
                'chat_role_id' => 10,
                'created_at' => '2025-04-16 01:18:10',
                'updated_at' => '2025-04-16 01:18:10',
            ),
            9 => 
            array (
                'character_id' => 3,
                'chat_role_id' => 10,
                'created_at' => '2025-04-16 01:18:57',
                'updated_at' => '2025-04-16 01:18:57',
            ),
            10 => 
            array (
                'character_id' => 2,
                'chat_role_id' => 9,
                'created_at' => '2025-04-16 01:19:07',
                'updated_at' => '2025-04-16 01:19:07',
            ),
            11 => 
            array (
                'character_id' => 4,
                'chat_role_id' => 9,
                'created_at' => '2025-04-16 01:19:28',
                'updated_at' => '2025-04-16 01:19:28',
            ),
            12 => 
            array (
                'character_id' => 73,
                'chat_role_id' => 184,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            13 => 
            array (
                'character_id' => 73,
                'chat_role_id' => 188,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            14 => 
            array (
                'character_id' => 73,
                'chat_role_id' => 189,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            15 => 
            array (
                'character_id' => 74,
                'chat_role_id' => 182,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            16 => 
            array (
                'character_id' => 74,
                'chat_role_id' => 185,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            17 => 
            array (
                'character_id' => 74,
                'chat_role_id' => 190,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            18 => 
            array (
                'character_id' => 75,
                'chat_role_id' => 183,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            19 => 
            array (
                'character_id' => 75,
                'chat_role_id' => 187,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
            20 => 
            array (
                'character_id' => 75,
                'chat_role_id' => 189,
                'created_at' => '2025-04-18 03:51:53',
                'updated_at' => '2025-04-18 03:51:53',
            ),
        ));
        
        
    }
}