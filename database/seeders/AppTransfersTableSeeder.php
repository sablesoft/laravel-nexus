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
                'id' => 7,
                'screen_from_id' => 2,
                'screen_to_id' => 9,
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
                'id' => 6,
                'screen_from_id' => 1,
                'screen_to_id' => 9,
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
                'id' => 1,
                'screen_from_id' => 1,
                'screen_to_id' => 2,
                'title' => '{"en":"Explore","ru":"Исследовать"}',
                'tooltip' => '{"en":"What else is there to do?","ru":"А что еще остается делать?"}',
                'description' => '{"en":"Transitions to the next screen once the prologue is fully completed. \\nAppears only after all parts of the prologue have been shown. Becomes the player’s first active choice to explore the world.","ru":"Переходит на следующий экран после полного завершения пролога.\\nПоявляется только после того, как показаны все части пролога. Становится первым активным выбором игрока для начала исследования мира."}',
            'before' => '[{"set":{"messages":"character_info"}},{"merge":{"messages":[{"role":">>system","content":">>Play the role of an AI narrator. The character has just pulled over and now exits the sedan, approaching the house they spotted earlier. Describe the brief transition (4\\u20135 sentences) from the vehicle to the porch in cinematic, atmospheric detail. Include physical sensations \\u2014 the crunch of gravel, the shift in light, the air\'s movement \\u2014 and the character\\u2019s cautious posture. The world is alive again, reclaimed by nature; subtle signs of nearby animal or bird presence may be included, along with how they react to the character\\u2019s appearance \\u2014 startled flight, wary glances, or indifference. The character\\u2019s own reaction or thoughts about these creatures should also be reflected if appropriate. Focus on mood and immersion, without describing the porch in detail yet. End the narration with the character stepping up onto the covered porch, and include a direct in-universe question to the player \\u2014 prompting them to decide what to do next."}]}},{"chat.completion":{"model":">>gpt-4o","messages":"messages","content":[{"memory.create":{"type":">>porch","content":"content"}}]}}]',
                'after' => NULL,
            'visible_condition' => 'screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:06:27',
                'updated_at' => '2025-04-16 04:02:01',
            ),
        ));
        
        
    }
}