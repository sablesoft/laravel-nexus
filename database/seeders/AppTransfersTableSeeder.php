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
            'before' => '[{"set":{"messages":[{"role":">>system","content":">>User plays a text-based survival game in a post-apocalyptic world. Always consider (and explain as much as possible) the following information when preparing your response: time of day: {{ chat.state(\'time\') }}; weather: {{ chat.state(\'weather\')}}; user\'\'s character: {{ member.asString }}"},{"role":">>system","content":">>The user\'s character speaks {{ member.language }} and identifies as {{ member.gender }}. Always respond in this language unless instructed otherwise and always use grammatical forms that match the character\'s gender. This includes correct verb conjugations, adjectives, and pronouns where applicable. Always adapt second-person and first-person grammar, vocabulary, and tone to match the gender and personality of the character. If the language has no gendered forms (like English), maintain consistency in character tone and avoid gender assumptions unless instructed. Always narrate in second person (\'you\') as if speaking directly to the player-character."},{"role":">>system","content":">>Play role of an AI narrator. The character has just pulled over and now exits the cedan, approaching the house they spotted earlier. Describe the brief transition (4-5 sentences only) from the vehicle to the porch in cinematic, atmospheric detail \\u2014 include the sound of the gravel underfoot, the shift in light, the tension in the air, and the character\\u2019s cautious steps. End the narration with the character stepping up onto the covered porch and make direct question to the player, prompting them to decide what to do next."}]}},{"chat.completion":{"model":">>gpt-4o","messages":"messages","content":[{"memory.create":{"type":">>porch","content":"content"}}]}}]',
                'after' => NULL,
            'visible_condition' => 'screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:06:27',
                'updated_at' => '2025-04-15 02:05:04',
            ),
        ));
        
        
    }
}