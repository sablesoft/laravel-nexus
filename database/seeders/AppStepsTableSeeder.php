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
                'id' => 2,
                'parent_id' => 12,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Audio Log - Apocalipsys","ru":"Audio Log - Doomsday"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 2","then":[{"set":{"meta.tags":[">>audio-log"],"author":"character.id()"}},{"merge":{"messages":[{"role":">>system","content":">>Lore: {{ doomsday_virus}}. {{ fractions }}."},{"role":">>system","content":">>You are now the player\'s character speaking into a voice recorder. This is their personal audio log. Write a short monologue (8\\u201310 sentences) in the first person, in the voice of the character. The first sentence must begin with: \\u201cIt\\u2019s been [number] years since it happened.\\u201d The event refers to the outbreak of Doomsday Virus. So, let\'s character describe it from his point of view. Also the character should express their attitude toward Walkers and Shells \\u2014 with empathy, resentment, irony, distrust, or however it fits their personality. Let it feel personal and grounded, not ideological. Remember about character\'s fraction. Then, describe how the character survived, what they\\u2019ve been through, and finally \\u2014 articulate their current purpose. Where are they headed, and why? What are they looking for \\u2014 a person, a place, an answer? This is their personal quest \\u2014 make it clear and specific. At the end of the message, the character suddenly notices a small structure by the side of the road \\u2014 just as they\'re finishing their thought. They interrupt the recording mid-sentence or immediately after, reacting briefly and spontaneously. You may include a quick, emotionally honest reaction \\u2014 a whisper, a fragment, or even an expletive \\u2014 but do not describe the structure itself."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:24:01',
                'updated_at' => '2025-04-17 19:46:35',
            ),
            1 => 
            array (
                'id' => 3,
                'parent_id' => 12,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"en":"House by the Road"}',
                'description' => '{"ru":"Wonderful luck","en":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 3","then":[{"merge":{"messages":[{"role":">>system","content":">>You are an AI narrator for an interactive post-apocalyptic story set in a world abandoned by people, where nature has reclaimed much of what was once civilization. The character, a lone survivor, suddenly notices a small house on the left side of the road. Describe what the character sees from the road \\u2014 but only what is realistically visible through the trees. The house is old but intact. Its windows appear unbroken, and the front door looks solid. The structure is partially obscured by overgrowth and branches, making details hard to discern. Do not invent any signs of human presence \\u2014 no movement inside, no lights, no voices. However, natural sounds and distant animal or bird activity are acceptable if appropriate. The place should feel abandoned by people, but not by life. Emphasize the texture of the scene, the mood of abandonment, and the tension in the character\\u2019s perception. Remind the player that the gas tank is almost empty. Write 4\\u20135 sentences total. End the narration with a concrete action: the character slows down and pulls over to the roadside."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 05:45:45',
                'updated_at' => '2025-04-17 19:46:38',
            ),
            2 => 
            array (
                'id' => 8,
                'parent_id' => 12,
                'number' => 4,
                'scenario_id' => 2,
                'name' => '{"en":"Chat Completion"}',
                'description' => '{"en":null}',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-17 17:55:51',
                'updated_at' => '2025-04-17 19:49:09',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 12,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Forest Road","ru":"Forest Road"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 1","then":[{"merge":{"messages":[{"role":">>system","content":">>You are an AI narrator for an interactive post-apocalyptic story. The character is alone, driving their sedan down a gravel road that winds through a dense, overgrown forest. Gas is almost gone. There\\u2019s no one around \\u2014 not anymore. Describe what the player sees, hears, and feels in this moment. The world has been without people for a long time, and nature has flourished in their absence \\u2014 wild vegetation, animals, and ambient life are all present and active. Let the specific details of plants and wildlife be appropriate to the current weather and time. Use a poetic but grounded style inspired by Jeff VanderMeer. Subtly reflect the character\\u2019s appearance or internal mood through phrasing and tone. Focus on texture, color, sound, and movement. End the message with a gradual shift in tone: the character begins to recall something important... and reaches for their voice recorder. Add an ellipsis at the end. Write a 4\\u20136 sentences in total."}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 16:51:43',
                'updated_at' => '2025-04-17 19:46:32',
            ),
        ));
        
        
    }
}