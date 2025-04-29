<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppScreensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.screens')->delete();
        
        \DB::table('app.screens')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'application_id' => 1,
                'image_id' => 1,
                'title' => '{"en":"Recorder","ru":"Диктофон"}',
                'code' => 'recorder',
                'description' => '{"en":"This screen displays audio log entries created by the player or revealed through the story. Each entry reflects the character’s thoughts, memories, or key moments — either recorded manually or triggered by events. The screen is meant to feel like a quiet personal archive, slowly growing over time. Use it to deepen the emotional tone, reinforce narrative themes, or foreshadow future developments","ru":"На этом экране отображаются аудиозаписи, созданные игроком или раскрытые по ходу сюжета. Каждая запись отражает мысли, воспоминания или важные моменты персонажа — будь то сделанные вручную или активированные событиями. Экран задуман как личный архив, который постепенно наполняется со временем. Используйте его для усиления эмоционального фона, раскрытия тем повествования или предвосхищения будущих событий. Здесь отображаются только записи с тегом \\"audio-log\\"."}',
                'is_start' => false,
                'query' => '":meta.tags" contains ["audio-log"]',
                'template' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'states' => NULL,
                'init' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-14 20:55:10',
                'updated_at' => '2025-04-15 16:31:22',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'application_id' => 1,
                'image_id' => 9,
                'title' => '{"en":"Porch","ru":"На пороге"}',
                'code' => 'porch',
                'description' => '{"ru":null,"en":null}',
                'is_start' => false,
                'query' => '":type" == screen.code or ":type" == "debug"',
                'template' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'states' => '{"has": {"hasKey": {"type": "bool", "value": false}, "opened": {"type": "bool", "value": false}, "foundKey": {"type": "bool", "value": false}}}',
                'init' => '[{"character.state":{"values":{"place":">>Porch"}}}]',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 19:54:06',
                'updated_at' => '2025-04-21 23:19:13',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'application_id' => 1,
                'image_id' => 3,
                'title' => '{"en":"Prologue","ru":"Пролог"}',
                'code' => 'prologue',
                'description' => '{"ru":null,"en":null}',
                'is_start' => true,
            'query' => '":type" == screen.code or has(":meta.tags", "card")',
                'template' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'states' => '{"has": {"step": {"type": "int", "value": 0}, "steps": {"type": "int", "value": 3, "constant": true}, "isDone": {"type": "bool", "value": false}}}',
            'init' => '[{"if":{"condition":"screen.state(\'step\') == 0","then":[{"comment":">>Greeting"},{"screen.waiting":true},{"set":{"message_rules_game":"note.message(\'rules-game\', \'Rules:\')","message_lore_virus":"note.message(\'lore-virus\', \'Lore:\')","message_lore_fractions":"note.message(\'lore-fractions\', \'Lore:\')"}},{"memory.card":{"async":true,"type":">>quest","layout":"note.content(\'layout-quest\')","code":">>main","title":">>Main","messages":["message_rules_game","message_lore_virus","message_lore_fractions"],"task":"note.content(\\"quest-main\\")"}},{"chat.completion":{"async":true,"messages":["message_rules_game","note.message(\'rules-narrator\', \'Rules:\')","note.message(\'rules-content\', \'Rules:\')","message_lore_virus","message_lore_fractions","note.message(\'make-greeting\', \'Make:\')"],"content":[{"memory.create":{"content":"content"}},{"screen.state":{"values":{"step":"screen.nextState(\'step\')"}}},{"chat.refresh":null}]}}]}}]',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 19:43:19',
                'updated_at' => '2025-04-28 06:40:53',
            ),
        ));
        
        
    }
}