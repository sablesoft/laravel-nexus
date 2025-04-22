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
                'id' => 14,
                'user_id' => 1,
                'title' => '{"en":"Tool - AI Warning"}',
                'description' => '{"en":null}',
            'before' => '[{"comment":">>Prepare instruction"},{"merge":{"messages":[{"role":">>system","content":">>After generating your final response, carefully inspect the provided context, messages, actions, or any other parameters. If you notice anything inconsistent, duplicated, confusing, or potentially incorrect, you also MUST raise a tool call to \\\\\\"warning\\\\\\" with a description of the issue as an addition to the your main response (content or other tool calls). Be the developer\\u2019s assistant \\u2014 your job is to help catch mistakes in the structure or data flow of the input."}]}},{"comment":">>Prepare tool and handler"},{"merge":{"tools":{"warning":{"description":">>This is just a debug tool. It must never replace or interrupt your main request task. Raise a warning about something unusual or possibly incorrect in the request context only as an addition to the main response.","parameters":{"type":">>object","properties":{"message":{"type":">>string","description":">>The warning message about potential inconsistency or problem"}},"required":[">>message"]}}},"!calls_handlers":{"warning":[{"memory.create":{"type":">>debug","title":">>AI Warning","content":"call.message","meta.tag":[">>warning"]}}]}}}]',
                'after' => NULL,
                'created_at' => '2025-04-17 17:39:28',
                'updated_at' => '2025-04-17 19:45:58',
            ),
            1 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'title' => '{"en":"Porch - Act","ru":"Porch - Act"}',
                'description' => '{"en":"Free action handler","ru":"Free action handler"}',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-17 05:39:11',
                'updated_at' => '2025-04-19 11:07:45',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => '{"en":"Tool - Ask Classification","ru":"Tool - Act Classification"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"comment":">>Validate context required for action classification"},{"validate":{"ask":"required|string","actions":"required|array","action_handler":"required|array"}},{"comment":">>Add fallback \\"other\\" action"},{"set":{"tool_choice":">>required","!actions.other":{"description":"Any user action that does not match the predefined list.","what":"What the user references or affects \\u2014 target, object, item, - e.g. self, body, thought, air.","using":"Use if any object is involved. Leave empty otherwise.","from":"Use according to context","to":"Use according to context","for":"The purpose of this action as you understand it from the context","how":"Tone or manner of the action \\u2014 e.g. quietly, nervously, quickly."}}},{"comment":">>Prepare instruction, tool and handler"},{"merge":{"messages":[{"role":">>system","content":">>You are a text adventure engine that interprets user actions. Given a list of available actions with descriptions, classify the user\'s input by selecting the most appropriate action. Use the classification tool and return values for all parameters. All returned values \\u2014 what, using, from, to, for, and how \\u2014 MUST be in lowercase English only. In all this fields, always include 2 to 6 relevant English words or synonyms. Start with what the user directly refers to, then include 1\\u20133 clearly related terms \\u2014 only if they are strongly implied by context, then add English synonyms to all this keywords. Remember that synonyms in parameters are essential for the system to find matches. In the using field, only include tools, objects, methods, body parts, or items that are explicitly mentioned or strongly implied. Never guess or fill in based on general world knowledge. Only use how if it is explicitly or clearly present in the user input. Leave the how array empty if unsure. If the input does not match any specific action, set \\"do\\" = \\"other\\" and fill in all parameters based on context and understanding."},{"role":">>user","content":"ask"}],"tools":{"classification":{"description":">>Classification of user actions","parameters":{"type":">>object","properties":{"do":{"type":">>string","enum":"array_keys(actions)","description":">>Name of the action to perform (must match predefined list)"},"what":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe what the action is directed at."},"using":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe tool, item, method or body part used to perform the action."},"from":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe origin or starting context of the action."},"to":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe destination, target direction or result of the action."},"for":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe intent or purpose behind the action."},"how":{"type":">>array","items":{"type":">>string","pattern":">>^[a-z]+$"},"description":">>List of 2-6 English keywords \\u2014 related terms and synonyms that describe manner, tone or style of the action."}},"required":[">>do",">>what",">>using",">>from",">>to",">>for",">>how"]}}},"calls_handlers":{"classification":"action_handler"}}}]',
                'after' => NULL,
                'created_at' => '2025-04-07 23:07:51',
                'updated_at' => '2025-04-18 03:59:12',
            ),
            3 => 
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
            4 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Continue","ru":"Prologue - Continue"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"meta":{"weather":"chat.state(\'weather\')","time":"chat.state(\'time\')"},"author":null,"async":true,"messages":["note.message(\'rules-game\', \'Rules:\')","note.message(\'rules-content\', \'Rules:\')"],"!content_handler":[{"memory.create":{"author_id":"author","content":"content","meta":"meta"}},{"screen.state":{"values":{"waiting":false,"step":"screen.nextState(\'step\')","isDone":"screen.state(\'step\') == screen.state(\'steps\')"}}},{"chat.refresh":null}]}},{"merge":{"messages":"memory.messages(\'\\":type\\" == screen.code\')"}},{"screen.waiting":true}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:12:20',
                'updated_at' => '2025-04-21 21:16:32',
            ),
            5 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'title' => '{"en":"Completion Template","ru":"Шаблон генерации"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"comment":">>Validate context required for chat completion"},{"validate":{"content_handler":"sometimes|array","tool_choice":"sometimes|string","tools":"sometimes|array","calls_handlers":"sometimes|array","model":"sometimes|string","async":"sometimes|boolean"}},{"comment":">>Prepare context variables"},{"set":{"model":"model ?? null","tools":"tools ?? null","tool_choice":"tools ? (tool_choice ?? \'auto\') : null","calls_handlers":"calls_handlers ?? null","content_handler":"content_handler ?? null"}},{"comment":">>Run chat completion"},{"chat.completion":{"model":"model","async":"async ?? false","messages":"messages","tool_choice":"tool_choice","tools":"tools","calls":"calls_handlers","content":"content_handler"}}]',
                'after' => NULL,
                'created_at' => '2025-04-02 04:23:13',
                'updated_at' => '2025-04-21 21:39:26',
            ),
        ));
        
        
    }
}