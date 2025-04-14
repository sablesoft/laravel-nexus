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
                'before' => NULL,
                'after' => NULL,
                'states' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:54:06',
                'updated_at' => '2025-04-12 00:39:01',
            ),
            1 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'application_id' => 1,
                'image_id' => 52,
                'title' => '{"en":"Prologue","ru":"Пролог"}',
                'code' => 'prologue',
                'description' => '{"ru":null}',
                'is_start' => true,
                'query' => '":type" == screen.code',
                'template' => NULL,
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 0","then":[{"comment":">>Greeting"},{"chat.completion":{"model":">>gpt-4o","messages":[{"role":">>system","content":">>User\'s character: {{ member.asString }}"},{"role":">>system","content":">>The user\'s character speaks {{ member.language }} and identifies as {{ member.gender }}. Always respond in this language unless instructed otherwise and always use grammatical forms that match the character\'s gender. This includes correct verb conjugations, adjectives, and pronouns where applicable. Always adapt second-person and first-person grammar, vocabulary, and tone to match the gender and personality of the character. If the language has no gendered forms (like English), maintain consistency in character tone and avoid gender assumptions unless instructed."},{"role":">>system","content":">>Greet the player in the voice of an AI narrator for an interactive post-apocalyptic story. Set a somber, reflective tone suitable for a post-apocalyptic world. Welcome them quietly, as if the story is waiting to begin. Use 2\\u20133 sentences. Avoid exposition \\u2014 focus on mood and restraint."}],"content":[{"memory.create":{"content":"content"}}]}},{"screen.state":{"values":{"step":"screen.nextState(\'step\')"}}}]}}]',
                'after' => NULL,
                'states' => '{"has": {"step": {"type": "int", "value": 0}, "steps": {"type": "int", "value": 3, "constant": true}, "isDone": {"type": "bool", "value": false}, "waiting": {"type": "bool", "value": false}}}',
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:43:19',
                'updated_at' => '2025-04-14 17:07:03',
            ),
        ));
        
        
    }
}