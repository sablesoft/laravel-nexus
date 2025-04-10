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
                'title' => '{"en":"Ask Memory"}',
                'description' => '{"en":"Just add member ask to screen memories"}',
                'before' => '[{"validate":{"ask":"required|string"}},{"memory.create":{"type":"screen.code","data":{"author_id":"member.id","content":"ask"}}},{"chat.refresh":["screen.code"]}]',
                'after' => NULL,
                'created_at' => '2025-03-28 05:51:03',
                'updated_at' => '2025-04-01 04:48:32',
            ),
            1 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'title' => '{"en":"Completion Template","ru":"\\u0428\\u0430\\u0431\\u043b\\u043e\\u043d \\u0433\\u0435\\u043d\\u0435\\u0440\\u0430\\u0446\\u0438\\u0438"}',
                'description' => '{"ru":null}',
            'before' => '[{"comment":">>Validate context required for chat completion"},{"validate":{"messages":"required|array|min:1","messages.*.role":"required|string|in:user,assistant,system,tool","messages.*.content":"required|string","content_handler":"sometimes|array","tool_choice":"sometimes|string","tools":"sometimes|array","calls_handlers":"sometimes|array","model":"sometimes|string"}},{"comment":">>Prepare context variables"},{"set":{"model":"model ?? \'gpt-4-turbo\'","tools":"tools ?? null","tool_choice":"tools ? (tool_choice ?? \'auto\') : null","calls_handlers":"calls_handlers ?? null","content_handler":"content_handler ?? null"}},{"comment":">>Run chat completion"},{"chat.completion":{"model":"model","messages":"messages","tool_choice":"tool_choice","tools":"tools","calls":"calls_handlers","content":"content_handler"}}]',
                'after' => NULL,
                'created_at' => '2025-04-02 04:23:13',
                'updated_at' => '2025-04-10 05:30:19',
            ),
            2 => 
            array (
                'id' => 11,
                'user_id' => 1,
                'title' => '{"en":"Actions Classificator Tool","ru":"\\u0418\\u043d\\u0441\\u0442\\u0440\\u0443\\u043c\\u0435\\u043d\\u0442 - \\u041a\\u043b\\u0430\\u0441\\u0441\\u0438\\u0444\\u0438\\u043a\\u0430\\u0446\\u0438\\u044f \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0439"}',
                'description' => '{"ru":null}',
            'before' => '[{"comment":">>Validate context required for actions classificator"},{"validate":{"ask":"required|string","actions":"required|array","actions.*":"required|string","action_handler":"required|array","fail_handler":"required|array"}},{"comment":">>Prepare instructions and ask for classification"},{"merge":{"messages":[{"role":">>system","content":">>Interpret the user\'s input as an in-game action. Classify it by selecting a single action from the list of available options below, and respond using the classification tool. Available actions: {{ json_encode(actions) }}"},{"role":">>user","content":"ask"}]}},{"comment":">>Prepare completion tool and handlers"},{"set":{"tool_choice":">>required","tools":{"classification":{"description":">>Classification of user actions","parameters":{"type":">>object","properties":{"action":{"type":">>string","enum":"array_keys(actions)","description":">>The type of action the user is trying to perform. Must match one of the predefined keywords"},"target":{"type":">>string","description":">>The target of the action \\u2014 what it is aimed at. Can be a specific object, part of the environment, a concept, or even a direction. Should be a short phrase or keyword on English language."}},"required":[">>action",">>target"]}}},"!calls_handlers":{"classification":[{"comment":">> TODO: if member.can(call[\'action\'])"},{"if":{"condition":"true","then":[{"comment":">>Start action {{ call.action }} with target {{ call.target }}"},{"run":"action_handler"}],"else":[{"comment":">>Fail action {{ call.action }} with target {{ call.target }}"},{"run":"fail_handler"}]}}]}}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:07:51',
                'updated_at' => '2025-04-10 05:31:01',
            ),
        ));
        
        
    }
}