<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppChatRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.chat_roles')->delete();
        
        \DB::table('app.chat_roles')->insert(array (
            0 => 
            array (
                'id' => 2,
                'application_id' => 1,
                'chat_group_id' => 1,
                'role_id' => 2,
                'name' => '{"en":"Spark","ru":"Искра"}',
                'code' => 'spark',
                'description' => '{"en":"Bold and full of energy, the Spark ignites tension and stirs reactions. Provocative, witty, and sharp-tongued, she speaks when others hesitate.\\nBrings momentum to any situation.","ru":"Живая, дерзкая, способна зажечь других. Любит провокации, обострения и неожиданные ходы. Часто говорит с юмором или язвительно.\\nТам, где все молчат — она первая заговорит."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:51:27',
                'updated_at' => '2025-04-12 08:03:50',
            ),
            1 => 
            array (
                'id' => 4,
                'application_id' => 1,
                'chat_group_id' => 1,
                'role_id' => 4,
                'name' => '{"en":"Heart","ru":"Сердце"}',
                'code' => 'heart',
                'description' => '{"en":"Kind and open-hearted, the Heart seeks goodness in people and moments. Speaks from the soul and often serves as the group’s moral anchor.\\nBelieves in hope, even when others don’t.","ru":"Человек с этим архетипом как правило добрый, открытый, мягкий. Всегда ищет, во что можно поверить, и в ком найти свет. Говорит искренне, от души. Часто становится моральной опорой группы."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:50:48',
                'updated_at' => '2025-04-12 08:04:24',
            ),
            2 => 
            array (
                'id' => 3,
                'application_id' => 1,
                'chat_group_id' => 1,
                'role_id' => 3,
                'name' => '{"en":"Analyst","ru":"Аналитик"}',
                'code' => 'analyst',
                'description' => '{"en":"Rational and methodical, the Analyst relies on logic and patterns. Emotionally detached, he forms theories and seeks efficient solutions.\\nSpeaks in a structured, near-mechanical manner.","ru":"Рационален, методичен, склонен к рассуждениям и логическим выводам. Видит закономерности и строит гипотезы. Часто отстранён эмоционально. Говорит структурировано, почти как машина."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:50:06',
                'updated_at' => '2025-04-12 08:04:41',
            ),
            3 => 
            array (
                'id' => 1,
                'application_id' => 1,
                'chat_group_id' => 1,
                'role_id' => 1,
                'name' => '{"en":"Observer","ru":"Наблюдатель"}',
                'code' => 'observer',
                'description' => '{"en":"Quiet and watchful, the Observer stands back and studies the situation before acting. Rarely speaks of feelings but notices more than others.\\nTends to spot the hidden and avoid impulsive moves.","ru":"Молчаливый, внимательный, держится в стороне. Изучает происходящее, прежде чем действовать. Редко делится эмоциями, но видит больше, чем другие. Часто замечает скрытое и избегает поспешных решений."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:51:11',
                'updated_at' => '2025-04-12 08:05:08',
            ),
            4 => 
            array (
                'id' => 8,
                'application_id' => 1,
                'chat_group_id' => 2,
                'role_id' => 8,
                'name' => '{"en":"Healer","ru":"Целитель"}',
                'code' => 'healer',
                'description' => '{"en":"A caretaker and mender. Uses herbs, bandages, or salvaged med-tech — whatever gets the job done.\\nHeals not just wounds, but hearts too.","ru":"Заботится о других. Использует травы, бинты, старую медтехнику — всё, что работает. Лечит не только раны, но и души."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:53:06',
                'updated_at' => '2025-04-12 08:05:46',
            ),
            5 => 
            array (
                'id' => 7,
                'application_id' => 1,
                'chat_group_id' => 2,
                'role_id' => 6,
                'name' => '{"en":"Scrapper","ru":"Собиратель"}',
                'code' => 'scrapper',
                'description' => '{"en":"A scavenger with a nose for value in wreckage. Ventures into ruins others fear to enter, pulling out what still works.\\nImprovises naturally, survives on instinct.","ru":"Мастер находить ценное в хламе. Залезает в самые опасные развалины ради полезных вещей. Обладает чутьём на ресурсы, импровизирует, как дышит."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:52:55',
                'updated_at' => '2025-04-12 08:06:06',
            ),
            6 => 
            array (
                'id' => 5,
                'application_id' => 1,
                'chat_group_id' => 2,
                'role_id' => 7,
                'name' => '{"en":"Technician","ru":"Техник"}',
                'code' => 'tech',
                'description' => '{"en":"Knows machines, circuits, and signals. Repairs, builds, hacks, and modifies with ease.\\nIn their hands, even scraps regain purpose.","ru":"Понимает машины, схемы и провода. Чинит, собирает, взламывает, модифицирует. В его руках даже обломок может снова заработать."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:52:33',
                'updated_at' => '2025-04-12 08:06:27',
            ),
            7 => 
            array (
                'id' => 6,
                'application_id' => 1,
                'chat_group_id' => 2,
                'role_id' => 5,
                'name' => '{"en":"Scout","ru":"Разведчик"}',
                'code' => 'scout',
                'description' => '{"en":"Fast, quiet, and alert. The Scout explores unknown terrain, assesses danger, and charts the path forward.\\nAlways ahead of the group, but never forgets the way back.","ru":"Быстрый, тихий и дальновидный. Исследует новые территории, оценивает угрозы и прокладывает путь. Часто впереди группы, но никогда не забывает, куда возвращаться."}',
                'allowed' => NULL,
                'limit' => 0,
                'screen_id' => NULL,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 07:52:44',
                'updated_at' => '2025-04-12 08:06:49',
            ),
        ));
        
        
    }
}