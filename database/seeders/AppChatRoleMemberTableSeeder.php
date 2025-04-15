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
                'chat_role_id' => 3,
                'member_id' => 115,
                'created_at' => '2025-04-15 01:13:41',
                'updated_at' => '2025-04-15 01:13:41',
            ),
            1 => 
            array (
                'chat_role_id' => 5,
                'member_id' => 115,
                'created_at' => '2025-04-15 01:13:41',
                'updated_at' => '2025-04-15 01:13:41',
            ),
            2 => 
            array (
                'chat_role_id' => 2,
                'member_id' => 122,
                'created_at' => '2025-04-15 01:25:58',
                'updated_at' => '2025-04-15 01:25:58',
            ),
            3 => 
            array (
                'chat_role_id' => 7,
                'member_id' => 122,
                'created_at' => '2025-04-15 01:25:58',
                'updated_at' => '2025-04-15 01:25:58',
            ),
            4 => 
            array (
                'chat_role_id' => 8,
                'member_id' => 125,
                'created_at' => '2025-04-15 02:05:18',
                'updated_at' => '2025-04-15 02:05:18',
            ),
            5 => 
            array (
                'chat_role_id' => 4,
                'member_id' => 125,
                'created_at' => '2025-04-15 02:05:18',
                'updated_at' => '2025-04-15 02:05:18',
            ),
            6 => 
            array (
                'chat_role_id' => 3,
                'member_id' => 127,
                'created_at' => '2025-04-15 02:14:06',
                'updated_at' => '2025-04-15 02:14:06',
            ),
            7 => 
            array (
                'chat_role_id' => 5,
                'member_id' => 127,
                'created_at' => '2025-04-15 02:14:06',
                'updated_at' => '2025-04-15 02:14:06',
            ),
            8 => 
            array (
                'chat_role_id' => 2,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            9 => 
            array (
                'chat_role_id' => 7,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            10 => 
            array (
                'chat_role_id' => 8,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            11 => 
            array (
                'chat_role_id' => 4,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            12 => 
            array (
                'chat_role_id' => 1,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            13 => 
            array (
                'chat_role_id' => 6,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            14 => 
            array (
                'chat_role_id' => 3,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            15 => 
            array (
                'chat_role_id' => 5,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
        ));
        
        
    }
}