<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppChatRoleMemberTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.chat_role_member')->delete();
        
        \DB::table('app.chat_role_member')->insert(array (
            0 => 
            array (
                'chat_role_id' => 8,
                'member_id' => 101,
                'created_at' => '2025-04-14 21:58:04',
                'updated_at' => '2025-04-14 21:58:04',
            ),
            1 => 
            array (
                'chat_role_id' => 4,
                'member_id' => 101,
                'created_at' => '2025-04-14 21:58:04',
                'updated_at' => '2025-04-14 21:58:04',
            ),
            2 => 
            array (
                'chat_role_id' => 2,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            3 => 
            array (
                'chat_role_id' => 7,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            4 => 
            array (
                'chat_role_id' => 8,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            5 => 
            array (
                'chat_role_id' => 4,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            6 => 
            array (
                'chat_role_id' => 1,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            7 => 
            array (
                'chat_role_id' => 6,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            8 => 
            array (
                'chat_role_id' => 3,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            9 => 
            array (
                'chat_role_id' => 5,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            10 => 
            array (
                'chat_role_id' => 3,
                'member_id' => 103,
                'created_at' => '2025-04-14 22:26:36',
                'updated_at' => '2025-04-14 22:26:36',
            ),
            11 => 
            array (
                'chat_role_id' => 5,
                'member_id' => 103,
                'created_at' => '2025-04-14 22:26:36',
                'updated_at' => '2025-04-14 22:26:36',
            ),
        ));
        
        
    }
}