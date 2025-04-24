<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppTransfersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.transfers')->delete();
        
        \DB::table('app.transfers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'screen_from_id' => 2,
                'screen_to_id' => 1,
                'title' => '{"en":"Recorder","ru":"Диктофон"}',
                'tooltip' => '{"en":"Check your audio records","ru":"Проверить аудио записи"}',
                'description' => '{"en":null,"ru":null}',
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-14 20:59:21',
                'updated_at' => '2025-04-14 22:25:52',
            ),
            1 => 
            array (
                'id' => 2,
                'screen_from_id' => 3,
                'screen_to_id' => 1,
                'title' => '{"en":"Recorder","ru":"Диктофон"}',
                'tooltip' => '{"en":"Check your audio records","ru":"Проверить аудио записи"}',
                'description' => '{"en":null,"ru":null}',
                'before' => NULL,
                'after' => NULL,
            'visible_condition' => 'screen.state(\'step\') >= 3',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-14 20:58:46',
                'updated_at' => '2025-04-14 22:29:11',
            ),
            2 => 
            array (
                'id' => 3,
                'screen_from_id' => 3,
                'screen_to_id' => 2,
                'title' => '{"en":"Explore","ru":"Исследовать"}',
                'tooltip' => '{"en":"What else is there to do?","ru":"А что еще остается делать?"}',
                'description' => '{"en":"Transitions to the next screen once the prologue is fully completed. \\nAppears only after all parts of the prologue have been shown. Becomes the player’s first active choice to explore the world.","ru":"Переходит на следующий экран после полного завершения пролога.\\nПоявляется только после того, как показаны все части пролога. Становится первым активным выбором игрока для начала исследования мира."}',
            'before' => '[{"comment":">>Transfer to the Porch"},{"screen.waiting":true},{"chat.completion":{"async":true,"messages":["note.message(\'rules-game\', \'Rules:\')","note.message(\'rules-narrator\', \'Rules:\')","note.message(\'rules-content\', \'Rules:\')","memory.card(\'house\', \'place\')","memory.card(\'porch\', \'place\')","note.message(\'make-transfer\', \'Make:\')"],"content":[{"memory.create":{"type":">>porch","content":"content"}},{"chat.refresh":null}]}}]',
                'after' => NULL,
            'visible_condition' => 'screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:06:27',
                'updated_at' => '2025-04-24 04:24:24',
            ),
        ));
        
        
    }
}