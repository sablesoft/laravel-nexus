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
                'id' => 9,
                'user_id' => 1,
                'application_id' => 1,
                'image_id' => 62,
                'title' => '{"en":"Recorder","ru":"Диктофон"}',
                'code' => 'recorder',
                'description' => '{"en":"This screen displays audio log entries created by the player or revealed through the story. Each entry reflects the character’s thoughts, memories, or key moments — either recorded manually or triggered by events. The screen is meant to feel like a quiet personal archive, slowly growing over time. Use it to deepen the emotional tone, reinforce narrative themes, or foreshadow future developments","ru":"На этом экране отображаются аудиозаписи, созданные игроком или раскрытые по ходу сюжета. Каждая запись отражает мысли, воспоминания или важные моменты персонажа — будь то сделанные вручную или активированные событиями. Экран задуман как личный архив, который постепенно наполняется со временем. Используйте его для усиления эмоционального фона, раскрытия тем повествования или предвосхищения будущих событий. Здесь отображаются только записи с тегом \\"audio-log\\"."}',
                'is_start' => false,
                'query' => '":meta.tags" contains ["audio-log"]',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'states' => '{"system": {"__previous": null}}',
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-14 20:55:10',
                'updated_at' => '2025-04-14 22:30:46',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'application_id' => 1,
                'image_id' => 53,
                'title' => '{"en":"Porch","ru":"На пороге"}',
                'code' => 'porch',
                'description' => '{"ru":null}',
                'is_start' => false,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => '[{"set":{"messages":[{"role":">>system","content":">>Then focus on the porch itself: it is covered, weathered, and slightly aged but stable. You must include the following specific elements: \\u2013 The front door is shut and looks strong. \\u2013 The windows are intact, not broken. \\u2013 A worn doormat lies in front of the door with the word \\u201cWelcome\\u201d barely readable on it. In addition, invent and describe 2\\u20133 extra details about the porch area that support the setting. Make them vivid but grounded in realism."}]}}]',
                'after' => NULL,
                'states' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:54:06',
                'updated_at' => '2025-04-15 00:13:31',
            ),
            2 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'application_id' => 1,
                'image_id' => 52,
                'title' => '{"en":"Prologue","ru":"Пролог"}',
                'code' => 'prologue',
                'description' => '{"ru":null,"en":null}',
                'is_start' => true,
                'query' => '":type" == screen.code',
                'template' => NULL,
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 0","then":[{"comment":">>Greeting"},{"chat.completion":{"model":">>gpt-4o","messages":[{"role":">>system","content":">>User\'s character: {{ member.asString }}"},{"role":">>system","content":">>The user\'s character speaks {{ member.language }} and identifies as {{ member.gender }}. Always respond in this language unless instructed otherwise and always use grammatical forms that match the character\'s gender. This includes correct verb conjugations, adjectives, and pronouns where applicable. Always adapt second-person and first-person grammar, vocabulary, and tone to match the gender and personality of the character. If the language has no gendered forms (like English), maintain consistency in character tone and avoid gender assumptions unless instructed. Always narrate in second person (\\u201cyou\\u201d) as if speaking directly to the player-character."},{"role":">>system","content":">>Greet the player in the voice of an AI narrator for an interactive post-apocalyptic story. Set a somber, reflective tone suitable for a post-apocalyptic world. Welcome them quietly, as if the story is waiting to begin. Use 2\\u20133 sentences. Avoid exposition \\u2014 focus on mood and restraint."}],"content":[{"memory.create":{"content":"content"}}]}},{"screen.state":{"values":{"step":"screen.nextState(\'step\')"}}}]}}]',
                'after' => NULL,
                'states' => '{"has": {"step": {"type": "int", "value": 0}, "steps": {"type": "int", "value": 3, "constant": true}, "isDone": {"type": "bool", "value": false}, "waiting": {"type": "bool", "value": false}}}',
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:43:19',
                'updated_at' => '2025-04-15 01:23:29',
            ),
        ));
        
        
    }
}