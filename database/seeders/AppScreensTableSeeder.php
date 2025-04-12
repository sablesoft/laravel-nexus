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
                'id' => 8,
                'user_id' => 1,
                'application_id' => 4,
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
                'id' => 7,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 52,
                'title' => '{"en":"Prologue","ru":"Пролог"}',
                'code' => 'prologue',
                'description' => '{"ru":null}',
                'is_start' => true,
                'query' => '":type" == screen.code',
                'template' => NULL,
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 0","then":[{"comment":">>Generating first prologue message"},{"screen.state":{"values":{"waiting":true}}},{"chat.completion":{"model":">>gpt-4-turbo","messages":[{"role":">>system","content":">>You are an AI narrator for an interactive post-apocalyptic story. Tell the user that he is alone, driving his sedan down a gravel road through a dense forest. It\'s currently {{ chat.state(\'time\') }}, and the weather is {{ chat.state(\'weather\') }}. Gas is almost gone. There\\u2019s no one around. Generate a vivid, immersive paragraph (4\\u20136 sentences) describing what the player sees, hears, and feels in this moment. Use a vivid, immersive style inspired by Jeff VanderMeer: poetic but grounded in physical sensation. Focus on textures, sounds, colors, small details. End with a slow shift in tone: the player begins to remember something and then turns on his voice recorder. Add an ellipsis at the end."},{"role":">>system","content":">>The user\\u2019s preferred language is {{ member.language }}. Always respond in this language unless instructed otherwise."}],"content":[{"memory.create":{"content":"content"}}]}},{"screen.state":{"values":{"waiting":false,"step":"screen.nextState(\'step\')"}}},{"chat.refresh":null}]}}]',
                'after' => NULL,
                'states' => '{"has": {"step": {"type": "int", "value": 0}, "steps": {"type": "int", "value": 3, "constant": true}, "isDone": {"type": "bool", "value": false}, "waiting": {"type": "bool", "value": false}}}',
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:43:19',
                'updated_at' => '2025-04-12 00:39:35',
            ),
        ));
        
        
    }
}