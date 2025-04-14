<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppStepsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.steps')->delete();
        
        \DB::table('app.steps')->insert(array (
            0 => 
            array (
                'id' => 3,
                'parent_id' => 12,
                'number' => 3,
                'scenario_id' => NULL,
                'description' => '{"ru":"Wonderful luck","en":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 3","then":[{"merge":{"messages":[{"role":">>system","content":">>You are an AI narrator for an interactive post-apocalyptic story. The character suddenly notices a small house on the left side of the road. Describe what the character sees from outside: the house, its condition, and the atmosphere it creates. Reflect the character\\u2019s emotional state \\u2014 tension, caution, curiosity. Avoid exposition; focus on mood, texture, and sensory detail. End the narration with a physical action: the character slows down and pulls over to the roadside."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 05:45:45',
                'updated_at' => '2025-04-14 16:56:22',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 12,
                'number' => 2,
                'scenario_id' => NULL,
                'description' => '{"en":"Log One - Apocalipsys","ru":"Log One - Apocalipsys"}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 2","then":[{"set":{"meta.tags":[">>audio-log"],"author":"member.id()"}},{"merge":{"messages":[{"role":">>system","content":">>You are now the player\'s character speaking into a voice recorder. This is their personal audio log. Write a short monologue (5\\u20137 sentences) in the first person, in the voice of the character. The first sentence must begin with: It\\u2019s been [number] years since it happened. The character doesn\\u2019t explain the event as a historian or scientist \\u2014 they describe what they remember, what they saw, and how it changed everything. The cause of the collapse must be original and believable (not just nuclear war or zombie virus). Be imaginative. Then, describe their personal experience:  how they survived, what they lost, and how they ended up in the current moment. The tone and vocabulary should match their character and roles. Avoid exposition or info dumps. It should feel like a real, emotionally grounded reflection.  At the end of this message, something unexpectedly distracts the character and so he interrupts his recording. You may include a quick, spontaneous reaction in their voice \\u2014 a short comment, whisper, or even an expletive \\u2014 something emotionally honest and unfiltered. But don\'t say anything specific about what the character noticed."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:24:01',
                'updated_at' => '2025-04-14 16:56:50',
            ),
            2 => 
            array (
                'id' => 4,
                'parent_id' => 12,
                'number' => 1,
                'scenario_id' => NULL,
                'description' => '{"en":"Forest Road"}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 1","then":[{"merge":{"messages":[{"role":">>system","content":">>You are an AI narrator for an interactive post-apocalyptic story. Tell the user that he is alone, driving his sedan down a gravel road through a dense forest. It\'s currently {{ chat.state(\'time\') }}, and the weather is {{ chat.state(\'weather\') }}. Gas is almost gone. There\\u2019s no one around. Generate a vivid, immersive paragraph (4\\u20136 sentences) describing what the player sees, hears, and feels in this moment. Use a vivid, immersive style inspired by Jeff VanderMeer: poetic but grounded in physical sensation. Integrate the user\\u2019s character into the scene when possible \\u2014 reflect their appearance, personality, or mood subtly through phrasing, perspective, or internal tone. Focus on textures, sounds, colors, small details. End with a slow shift in tone: the player begins to remember something and then turns on his voice recorder. Add an ellipsis at the end."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 16:51:43',
                'updated_at' => '2025-04-14 16:54:28',
            ),
        ));
        
        
    }
}