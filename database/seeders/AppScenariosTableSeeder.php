<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppScenariosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.scenarios')->delete();
        
        \DB::table('app.scenarios')->insert(array (
            0 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'title' => 'Ask Memory',
                'description' => 'Just add member ask to screen memories',
                'before' => '[{"validate":{"ask":"required|string"}},{"memory.create":{"type":"screen.code","data":{"author_id":"member.id","content":"ask"}}},{"chat.refresh":["screen.code"]}]',
                'after' => NULL,
                'created_at' => '2025-03-28 05:51:03',
                'updated_at' => '2025-04-01 04:48:32',
            ),
            1 => 
            array (
                'id' => 10,
                'user_id' => 1,
                'title' => 'Test Completion Pipe',
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-03 21:27:47',
                'updated_at' => '2025-04-03 21:27:47',
            ),
            2 => 
            array (
                'id' => 9,
                'user_id' => 1,
                'title' => 'Prepare Location Generation',
                'description' => NULL,
            'before' => '[{"merge":{"messages":[{"role":">>system","content":">>You are a skillful GM. Be original and have a sense of humor."},{"role":">>system","content":">>Create a game location card for player story. Let it has danger level 1."}],"tools":{"card_location":{"description":">>Creating a game location card with description and parameters","parameters":{"type":">>object","properties":{"title":{"type":">>string","description":">>Short name of the location"},"description":{"type":">>string","description":">>Narrative description of the location"},"tags":{"type":">>array","items":{"type":">>string","description":">>List of thematic or gameplay tags in lowercase letters"}},"danger_level":{"type":">>integer","description":">>Level of danger (1-10)"}},"required":[">>title",">>description",">>tags",">>danger_level"]}}},"!calls_handlers":{"card_location":[{"memory.create":{"type":">>location","data":{"title":"call.title","content":"call.description","meta":{"tags":"call.tags","danger_level":"call.danger_level"}}}}]}}},{"set":{"tool_choice":">>required"}}]',
                'after' => NULL,
                'created_at' => '2025-04-03 15:20:44',
                'updated_at' => '2025-04-03 21:38:05',
            ),
            3 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'title' => 'Completion Template',
                'description' => NULL,
            'before' => '[{"comment":">>Validate context required for chat completion"},{"validate":{"messages":"required|array|min:1","messages.*.role":"required|string|in:user,assistant,system,tool","messages.*.content":"required|string","content_handler":"sometimes|array","tool_choice":"sometimes|string","tools":"sometimes|array","calls_handlers":"sometimes|array","model":"sometimes|string"}},{"comment":">>Prepare context variables"},{"set":{"model":"model ?? \'gpt-4-turbo\'","tools":"tools ?? null","tool_choice":"tools ? (tool_choice ?? \'auto\') : null","calls_handlers":"calls_handlers ?? null","content_handler":"content_handler ?? null"}},{"comment":">>Run chat completion"},{"chat.completion":{"model":"model","messages":"messages","tool_choice":"tool_choice","tools":"tools","calls":"calls_handlers","content":"content_handler"}}]',
                'after' => NULL,
                'created_at' => '2025-04-02 04:23:13',
                'updated_at' => '2025-04-08 00:52:47',
            ),
            4 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'title' => 'Smart Lift Input',
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 00:42:50',
                'updated_at' => '2025-04-08 00:42:50',
            ),
            5 => 
            array (
                'id' => 14,
                'user_id' => 1,
                'title' => 'Smart Lift Description',
                'description' => NULL,
                'before' => '[{"set":{"lift_description":">>This is a futuristic elevator cabin designed with a luxurious and serene ambiance. The interior is bathed in natural light pouring through large floor-to-ceiling windows that offer a panoramic view of a modern city skyline. The space is unusually spacious for an elevator and resembles a small indoor lounge or garden room. Two stylish sofas with soft cushions sit opposite each other, inviting relaxation. Between them lies a sleek coffee table with minimalistic design. The walls are adorned with vertical and horizontal shelves holding a lush variety of live plants \\u2014 ferns, succulents, and flowering pots \\u2014 giving the space a vibrant, organic feel. Potted plants of various shapes and sizes are placed thoughtfully on the floor, enhancing the greenery. A large, high-tech touch screen is embedded into the side wall, subtly integrated into the modern paneling. The ceiling features embedded linear LED lighting that creates a warm, ambient glow, contributing to the overall peaceful atmosphere. This elevator feels more like a tranquil sky lounge, blending futuristic technology with biophilic design, offering not just transportation but a moment of calm between destinations."}}]',
                'after' => NULL,
                'created_at' => '2025-04-08 02:07:44',
                'updated_at' => '2025-04-08 02:08:13',
            ),
            6 => 
            array (
                'id' => 11,
                'user_id' => 1,
                'title' => 'Actions Classificator Tool',
                'description' => NULL,
            'before' => '[{"comment":">>Validate context required for actions classificator"},{"validate":{"ask":"required|string","actions":"required|array","actions.*":"required|string","action_handler":"required|array","fail_handler":"required|array"}},{"comment":">>Prepare instructions and ask for classification"},{"merge":{"messages":[{"role":">>system","content":">>Interpret the user\'s input as an in-game action. Classify it by selecting a single action from the list of available options below, and respond using the classification tool. Available actions: {{ json_encode(actions) }}"},{"role":">>user","content":"ask"}]}},{"comment":">>Prepare completion tool and handlers"},{"set":{"tool_choice":">>required","tools":{"classification":{"description":">>Classification of user actions","parameters":{"type":">>object","properties":{"action":{"type":">>string","enum":"array_keys(actions)","description":">>The type of action the user is trying to perform. Must match one of the predefined keywords"},"target":{"type":">>string","description":">>The target of the action \\u2014 what it is aimed at. Can be a specific object, part of the environment, a concept, or even a direction. Should be a short phrase or keyword on English language."}},"required":[">>action",">>target"]}}},"!calls_handlers":{"classification":[{"comment":">> TODO: if member.can(call[\'action\'])"},{"if":{"condition":"true","then":[{"comment":">>Start action {{ call.action }} with target {{ call.target }}"},{"run":"action_handler"}],"else":[{"comment":">>Fail action {{ call.action }} with target {{ call.target }}"},{"run":"fail_handler"}]}}]}}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:07:51',
                'updated_at' => '2025-04-08 03:22:24',
            ),
            7 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => 'Smart Lift Main Actions',
                'description' => NULL,
            'before' => '[{"comment":">>Prepare list of allowed actions for main screen"},{"set":{"!actions":{"look":"Look around and observe the surroundings.","inspect":"Examine a specific object in detail.","analyze":"Try to understand how something works or what it does.","search":"Search for hidden or useful items.","listen":"Listen carefully for any sounds.","smell":"Smell the environment or something specific.","touch":"Touch or feel an object or surface.","taste":"Taste something to identify if it\'s edible or has flavor.","say":"Say something out loud into the space.","shout":"Shout loudly with the intention of being heard.","whisper":"Whisper quietly, perhaps to oneself or nearby.","call":"Call for help or attempt to contact someone.","ask":"Ask a question to someone","insult":"Say something rude or offensive.","flatter":"Say something flattering or try to gain favor.","use":"Attempt to use an item or interface.","sleep":"Lie down or try to sleep.","wait":"Wait and let time pass.","eat":"Try to eat something available.","pee":"Relieve oneself out of necessity.","cry":"Cry due to emotional stress.","laugh":"Laugh as a reaction to something.","meditate":"Try to calm down or meditate.","yell":"Yell in frustration or despair.","think":"Think or reflect internally.","remember":"Try to recall a memory.","dream":"Drift into imagination or daydreaming.","other":"None of the above \\u2014 something entirely different."},"!action_handler":[{"comment":">> TODO: Create real action handler"},{"memory.create":{"content":"json_encode(call)"}},{"chat.refresh":null}],"!fail_handler":[{"comment":">> TODO: Create real fail handler"},{"set":{"test":true}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:58:22',
                'updated_at' => '2025-04-08 03:47:16',
            ),
        ));
        
        
    }
}