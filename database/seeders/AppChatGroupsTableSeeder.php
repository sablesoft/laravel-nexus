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

        \DB::table('app.chat_groups')->insert(array (
            0 =>
            array (
                'id' => 1,
                'application_id' => 1,
                'chat_id' => NULL,
                'name' => '{"ru":"Архетип","en":"Archetype"}',
                'description' => '{"ru":"Эта группа описывает внутренний взгляд персонажа на мир: как он чувствует, реагирует, взаимодействует с окружающей реальностью и людьми. Эти роли задают характер речевых паттернов и решения.","en":"This group reflects the character’s internal lens on the world — how they perceive, respond to, and interact with their environment and others. These roles shape narrative tone and decision-making."}',
                'number' => 1,
                'roles_per_character' => 1,
                'is_required' => true,
                'allowed' => NULL,
                'created_at' => '2025-04-12 05:23:53',
                'updated_at' => '2025-04-12 08:11:40',
            ),
            1 =>
            array (
                'id' => 2,
                'application_id' => 1,
                'chat_id' => NULL,
                'name' => '{"ru":"Функция","en":"Function"}',
                'description' => '{"ru":"Эта группа описывает полезные функции, занятия и фракционные принадлежности персонажей в условиях разрухи: кто они по призванию или по обстоятельствам. Это может быть как профессия, так и способ выживания.","en":"This group defines practical functions, occupations, or affiliations the characters embody in the post-collapse world. It reflects their role in survival — whether chosen or imposed."}',
                'number' => 2,
                'roles_per_character' => 1,
                'is_required' => true,
                'allowed' => NULL,
                'created_at' => '2025-04-12 05:31:13',
                'updated_at' => '2025-04-12 08:12:00',
            ),
            2 =>
            array (
                'id' => 3,
                'application_id' => 1,
                'chat_id' => NULL,
                'name' => '{"en":"Fraction","ru":"Фракция"}',
                'description' => '{"en":null,"ru":null}',
                'number' => 3,
                'roles_per_character' => 1,
                'is_required' => true,
                'allowed' => NULL,
                'created_at' => '2025-04-16 00:56:30',
                'updated_at' => '2025-04-16 01:13:01',
            ),
        ));


    }
}
