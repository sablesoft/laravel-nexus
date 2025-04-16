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
                'id' => 2,
                'user_id' => 1,
                'title' => '{"en":"Completion Template","ru":"Шаблон генерации"}',
                'description' => '{"ru":null}',
            'before' => '[{"comment":">>Validate context required for chat completion"},{"validate":{"messages":"required|array|min:1","messages.*.role":"required|string|in:user,assistant,system,tool","messages.*.content":"required|string","content_handler":"sometimes|array","tool_choice":"sometimes|string","tools":"sometimes|array","calls_handlers":"sometimes|array","model":"sometimes|string"}},{"comment":">>Prepare context variables"},{"set":{"model":"model ?? \'gpt-4-turbo\'","tools":"tools ?? null","tool_choice":"tools ? (tool_choice ?? \'auto\') : null","calls_handlers":"calls_handlers ?? null","content_handler":"content_handler ?? null"}},{"comment":">>Run chat completion"},{"chat.completion":{"model":"model","messages":"messages","tool_choice":"tool_choice","tools":"tools","calls":"calls_handlers","content":"content_handler"}}]',
                'after' => NULL,
                'created_at' => '2025-04-02 04:23:13',
                'updated_at' => '2025-04-12 00:41:11',
            ),
            1 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'title' => '{"en":"Ask Memory"}',
                'description' => '{"en":"Just add member ask to screen memories"}',
                'before' => '[{"validate":{"ask":"required|string"}},{"memory.create":{"type":"screen.code","data":{"author_id":"member.id","content":"ask"}}},{"chat.refresh":["screen.code"]}]',
                'after' => NULL,
                'created_at' => '2025-03-28 05:51:03',
                'updated_at' => '2025-04-01 04:48:32',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => '{"en":"Actions Classificator Tool","ru":"Инструмент - Классификатор действий"}',
                'description' => '{"ru":null}',
            'before' => '[{"comment":">>Validate context required for actions classificator"},{"validate":{"ask":"required|string","actions":"required|array","actions.*":"required|string","action_handler":"required|array","fail_handler":"required|array"}},{"comment":">>Prepare instructions and ask for classification"},{"merge":{"messages":[{"role":">>system","content":">>Interpret the user\'s input as an in-game action. Classify it by selecting a single action from the list of available options below, and respond using the classification tool. Available actions: {{ json_encode(actions) }}"},{"role":">>user","content":"ask"}]}},{"comment":">>Prepare completion tool and handlers"},{"set":{"tool_choice":">>required","tools":{"classification":{"description":">>Classification of user actions","parameters":{"type":">>object","properties":{"action":{"type":">>string","enum":"array_keys(actions)","description":">>The type of action the user is trying to perform. Must match one of the predefined keywords"},"target":{"type":">>string","description":">>The target of the action \\u2014 what it is aimed at. Can be a specific object, part of the environment, a concept, or even a direction. Should be a short phrase or keyword on English language."}},"required":[">>action",">>target"]}}},"!calls_handlers":{"classification":[{"comment":">> TODO: if member.can(call[\'action\'])"},{"if":{"condition":"true","then":[{"comment":">>Start action {{ call.action }} with target {{ call.target }}"},{"run":"action_handler"}],"else":[{"comment":">>Fail action {{ call.action }} with target {{ call.target }}"},{"run":"fail_handler"}]}}]}}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:07:51',
                'updated_at' => '2025-04-12 00:40:56',
            ),
            3 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Continue","ru":"Prologue - Continue"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"meta":null,"author":null,"messages":"member_info"}},{"merge":{"messages":"memory.messages(\'\\":type\\" == screen.code\')"}}]',
            'after' => '[{"chat.completion":{"model":">>gpt-4o","messages":"messages","content":[{"memory.create":{"author_id":"author","content":"content","meta":"meta"}},{"screen.state":{"values":{"waiting":false,"step":"screen.nextState(\'step\')","isDone":"screen.state(\'step\') == screen.state(\'steps\')"}}},{"chat.refresh":null}]}}]',
                'created_at' => '2025-04-14 03:12:20',
                'updated_at' => '2025-04-16 00:47:31',
            ),
        ));
        
        
    }
}