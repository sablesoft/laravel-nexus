<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.roles')->delete();
        
        \DB::table('app.roles')->insert(array (
            0 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'group_id' => 1,
                'name' => '{"en":"Analyst","ru":"Аналитик"}',
                'description' => '{"en":"Rational and methodical, the Analyst relies on logic and patterns. Emotionally detached, he forms theories and seeks efficient solutions.\\nSpeaks in a structured, near-mechanical manner.","ru":"Рационален, методичен, склонен к рассуждениям и логическим выводам. Видит закономерности и строит гипотезы. Часто отстранён эмоционально.\\nГоворит структурировано, почти как машина."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 04:56:36',
                'updated_at' => '2025-04-12 04:57:04',
            ),
            1 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'group_id' => 1,
                'name' => '{"en":"Heart","ru":"Сердце"}',
                'description' => '{"en":"Kind and open-hearted, the Heart seeks goodness in people and moments. Speaks from the soul and often serves as the group’s moral anchor.\\nBelieves in hope, even when others don’t.","ru":"Человек с этим архетипом как правило добрый, открытый, мягкий. Всегда ищет, во что можно поверить, и в ком найти свет. Говорит искренне, от души.\\nЧасто становится моральной опорой группы."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 04:59:52',
                'updated_at' => '2025-04-12 05:00:46',
            ),
            2 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'group_id' => 2,
                'name' => '{"en":"Technician","ru":"Техник"}',
                'description' => '{"en":"Knows machines, circuits, and signals. Repairs, builds, hacks, and modifies with ease.\\nIn their hands, even scraps regain purpose.","ru":"Понимает машины, схемы и провода. Чинит, собирает, взламывает, модифицирует.\\nВ его руках даже обломок может снова заработать."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 05:04:22',
                'updated_at' => '2025-04-12 05:04:47',
            ),
            3 => 
            array (
                'id' => 8,
                'user_id' => 1,
                'group_id' => 2,
                'name' => '{"en":"Healer","ru":"Целитель"}',
                'description' => '{"en":"A caretaker and mender. Uses herbs, bandages, or salvaged med-tech — whatever gets the job done.\\nHeals not just wounds, but hearts too.","ru":"Заботится о других. Использует травы, бинты, старую медтехнику — всё, что работает.\\nЛечит не только раны, но и души."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 05:05:24',
                'updated_at' => '2025-04-12 05:05:51',
            ),
            4 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'group_id' => 1,
                'name' => '{"en":"Observer","ru":"Наблюдатель"}',
                'description' => '{"en":"Quiet and watchful, the Observer stands back and studies the situation before acting. Rarely speaks of feelings but notices more than others.\\nTends to spot the hidden and avoid impulsive moves.","ru":"Молчаливый, внимательный, держится в стороне. Изучает происходящее, прежде чем действовать. Редко делится эмоциями, но видит больше, чем другие.\\nЧасто замечает скрытое и избегает поспешных решений."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 04:43:50',
                'updated_at' => '2025-04-12 04:53:22',
            ),
            5 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'group_id' => 1,
                'name' => '{"en":"Spark","ru":"Искра"}',
                'description' => '{"en":"Bold and full of energy, the Spark ignites tension and stirs reactions. Provocative, witty, and sharp-tongued, she speaks when others hesitate.\\nBrings momentum to any situation.","ru":"Живая, дерзкая, способна зажечь других. Любит провокации, обострения и неожиданные ходы. Часто говорит с юмором или язвительно.\\nТам, где все молчат — она первая заговорит."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 04:54:52',
                'updated_at' => '2025-04-12 04:55:23',
            ),
            6 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'group_id' => 2,
                'name' => '{"en":"Scout","ru":"Разведчик"}',
                'description' => '{"en":"Fast, quiet, and alert. The Scout explores unknown terrain, assesses danger, and charts the path forward.\\nAlways ahead of the group, but never forgets the way back.","ru":"Быстрый, тихий и дальновидный. Исследует новые территории, оценивает угрозы и прокладывает путь.\\nЧасто впереди группы, но никогда не забывает, куда возвращаться."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 05:01:40',
                'updated_at' => '2025-04-12 05:02:15',
            ),
            7 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'group_id' => 2,
                'name' => '{"en":"Scrapper","ru":"Собиратель"}',
                'description' => '{"en":"A scavenger with a nose for value in wreckage. Ventures into ruins others fear to enter, pulling out what still works.\\nImprovises naturally, survives on instinct.","ru":"Мастер находить ценное в хламе. Залезает в самые опасные развалины ради полезных вещей.\\nОбладает чутьём на ресурсы, импровизирует, как дышит."}',
                'is_public' => false,
                'states' => NULL,
                'behaviors' => NULL,
                'created_at' => '2025-04-12 05:03:11',
                'updated_at' => '2025-04-12 05:03:45',
            ),
        ));
        
        
    }
}