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
                'description' => '{"en":"Just add character ask to screen memories"}',
                'before' => '[{"validate":{"ask":"required|string"}},{"memory.create":{"type":"screen.code","data":{"author_id":"character.id","content":"ask"}}},{"chat.refresh":["screen.code"]}]',
                'after' => NULL,
                'created_at' => '2025-03-28 05:51:03',
                'updated_at' => '2025-04-01 04:48:32',
            ),
            2 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Continue","ru":"Prologue - Continue"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"meta":null,"author":null,"messages":"character_info"}},{"merge":{"messages":"memory.messages(\'\\":type\\" == screen.code\')"}}]',
            'after' => '[{"chat.completion":{"model":">>gpt-4o","messages":"messages","content":[{"memory.create":{"author_id":"author","content":"content","meta":"meta"}},{"screen.state":{"values":{"waiting":false,"step":"screen.nextState(\'step\')","isDone":"screen.state(\'step\') == screen.state(\'steps\')"}}},{"chat.refresh":null}]}}]',
                'created_at' => '2025-04-14 03:12:20',
                'updated_at' => '2025-04-16 00:47:31',
            ),
            3 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => '{"en":"Actions Classificator Tool","ru":"Инструмент - Классификатор действий"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"comment":">>Validate context required for action classification"},{"validate":{"ask":"required|string","actions":"required|array","action_handler":"required|array"}},{"comment":">>Add fallback \\"other\\" action"},{"set":{"actions.other":{"description":"Any user action that does not match the predefined list. Used when the user input is either unsupported or not meaningful within the current gameplay context","target":"What the user references or affects \\u2014 e.g. self, body, thought, air.","stuff":"Use only if any object is involved. Leave empty otherwise.","modifiers":"Tone or manner of the action \\u2014 e.g. quietly, nervously \\u2014 or leave empty."}}},{"comment":">>Prepare classification message"},{"merge":{"messages":[{"role":">>system","content":"You are a text adventure engine that interprets user actions. Given a list of available actions with descriptions, classify the user\'s input by selecting the most appropriate action. Use the classification tool and return values for all parameters. If the input does not match any specific action, use verb = other and apply the fallback meaning as described in the other action details. Given the allowed actions: {{ json_encode(actions) }}."},{"role":">>user","content":"ask"}]}},{"comment":">>Prepare tool and handler"},{"set":{"tool_choice":">>required","tools":{"classification":{"description":">>Classification of user actions","parameters":{"type":">>object","properties":{"verb":{"type":">>string","enum":"array_keys(actions)","description":">>Exact name of the action to perform (must match predefined verb)"},"target":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of English keywords - synonyms that describe what the action is directed at. Can be empty."},"stuff":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of English keywords - synonyms: tool, item or object names used to perform the action. Can be empty."},"modifiers":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of English keywords and synonyms describes how the action is performed (tone, speed, emotion). Can be empty."}},"required":[">>verb",">>target",">>stuff",">>modifiers"]}}},"!calls_handlers":{"classification":"action_handler"}}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:07:51',
                'updated_at' => '2025-04-17 04:45:33',
            ),
        ));
        
        
    }
}