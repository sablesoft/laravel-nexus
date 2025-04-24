<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.groups')->delete();
        
        \DB::table('app.groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'name' => '{"en":"Archetype","ru":"Архетип"}',
                'description' => '{"en":"This group reflects the character’s internal lens on the world — how they perceive, respond to, and interact with their environment and others. These roles shape narrative tone and decision-making.","ru":"Архетип описывает внутренний взгляд персонажа на мир: как он чувствует, реагирует, взаимодействует с окружающей реальностью и людьми. Эти роли задают характер речевых паттернов и решения."}',
                'created_at' => '2025-04-12 04:23:22',
                'updated_at' => '2025-04-12 04:25:40',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'name' => '{"en":"Function","ru":"Функция"}',
                'description' => '{"en":"This group defines practical functions, occupations, or affiliations the characters embody. It reflects their role in survival — whether chosen or imposed.","ru":"Эта группа описывает полезные функции, занятия и фракционные принадлежности персонажей: кто они по призванию или по обстоятельствам. Это может быть как профессия, так и способ выживания."}',
                'created_at' => '2025-04-12 04:26:51',
                'updated_at' => '2025-04-12 04:28:56',
            ),
        ));
        
        
    }
}