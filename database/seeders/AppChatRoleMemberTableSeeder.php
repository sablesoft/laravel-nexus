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
                'chat_role_id' => 2,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            1 =>
            array (
                'chat_role_id' => 7,
                'member_id' => 4,
                'created_at' => '2025-04-12 07:54:04',
                'updated_at' => '2025-04-12 07:54:04',
            ),
            2 =>
            array (
                'chat_role_id' => 8,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            3 =>
            array (
                'chat_role_id' => 4,
                'member_id' => 2,
                'created_at' => '2025-04-12 07:54:16',
                'updated_at' => '2025-04-12 07:54:16',
            ),
            4 =>
            array (
                'chat_role_id' => 1,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            5 =>
            array (
                'chat_role_id' => 6,
                'member_id' => 3,
                'created_at' => '2025-04-12 07:54:31',
                'updated_at' => '2025-04-12 07:54:31',
            ),
            6 =>
            array (
                'chat_role_id' => 3,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            7 =>
            array (
                'chat_role_id' => 5,
                'member_id' => 1,
                'created_at' => '2025-04-12 07:54:42',
                'updated_at' => '2025-04-12 07:54:42',
            ),
            8 =>
            array (
                'chat_role_id' => 10,
                'member_id' => 1,
                'created_at' => '2025-04-16 01:18:10',
                'updated_at' => '2025-04-16 01:18:10',
            ),
            9 =>
            array (
                'chat_role_id' => 10,
                'member_id' => 3,
                'created_at' => '2025-04-16 01:18:57',
                'updated_at' => '2025-04-16 01:18:57',
            ),
            10 =>
            array (
                'chat_role_id' => 9,
                'member_id' => 2,
                'created_at' => '2025-04-16 01:19:07',
                'updated_at' => '2025-04-16 01:19:07',
            ),
            11 =>
            array (
                'chat_role_id' => 9,
                'member_id' => 4,
                'created_at' => '2025-04-16 01:19:28',
                'updated_at' => '2025-04-16 01:19:28',
            ),
        ));


    }
}
