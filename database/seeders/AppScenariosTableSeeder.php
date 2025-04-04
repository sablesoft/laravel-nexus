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
                'id' => 4,
                'user_id' => 1,
                'title' => 'Chat - Prompt Preparation',
                'description' => 'Assembles a ready-to-use array of chat messages for the OpenAI Chat Completion API by composing system and user messages from modular scenarios.',
                'before' => '[{"validate":{"ask":"required|string"}},{"set":{"messages":[]}}]',
                'after' => '[{"validate":{"messages":"required|array|size:2","messages.0.role":"required|in:system","messages.0.content":"required|string","messages.1.role":"required|in:user","messages.1.content":"required|string"}}]',
                'created_at' => '2025-03-25 21:03:29',
                'updated_at' => '2025-03-31 08:00:50',
            ),
            1 =>
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
            2 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'title' => 'Chat - Build User Message',
            'description' => 'Converts the user\'s raw input (ask) into a chat message with the \'user\' role for the OpenAI chat completion.',
            'before' => '[{"validate":{"ask":"required|string"}},{"set":{"user_message":{"role":">>user","content":"ask"},"messages":"append(messages, user_message)"}},{"unset":["user_message"]}]',
                'after' => NULL,
                'created_at' => '2025-03-25 17:55:49',
                'updated_at' => '2025-04-01 05:35:22',
            ),
            3 =>
            array (
                'id' => 3,
                'user_id' => 1,
                'title' => 'Chat - System Parts',
                'description' => 'Provides basic system prompt components instructing the assistant to act as a professional DALL·E 2 prompt engineer.',
                'before' => '[{"set":{"system_parts":[">>You act as a professional prompt engineer for DALL-E 2.",">>Your task is to detect the language of the user\'s request, then understand its meaning and generate a detailed prompt in English.",">>Return the result using the generate-prompt function. Use the second parameter \'comment\' to describe your reasoning in the original user language."]}}]',
                'after' => NULL,
                'created_at' => '2025-03-25 20:59:52',
                'updated_at' => '2025-04-01 05:36:13',
            ),
            4 =>
            array (
                'id' => 2,
                'user_id' => 1,
                'title' => 'Chat - Build System Message',
                'description' => 'Generates a system message for the OpenAI chat completion based on predefined instructional parts for the assistant role. Required "system_parts" array.',
            'before' => '[{"validate":{"system_parts":"required|array|min:1","system_parts.*":"required|string"}},{"set":{"system_message":{"role":">>system","content":"join(system_parts, \' \')"},"messages":"append(messages, system_message)"}},{"unset":["system_parts","system_message"]}]',
                'after' => NULL,
                'created_at' => '2025-03-25 17:58:41',
                'updated_at' => '2025-04-01 05:37:08',
            ),
            5 =>
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
            6 =>
            array (
                'id' => 7,
                'user_id' => 1,
                'title' => 'Completion Template',
                'description' => NULL,
            'before' => '[{"validate":{"messages":"required|array|min:1","messages.*.role":"required|string|in:user,assistant,system,tool","messages.*.content":"required|string","content_handler":"sometimes|array","tool_choice":"sometimes|string","tools":"sometimes|array","calls_handlers":"sometimes|array","model":"sometimes|string"}},{"set":{"model":"model ?? \'gpt-4-turbo\'","tools":"tools ?? null","tool_choice":"tools ? (tool_choice ?? \'auto\') : null","calls_handlers":"calls_handlers ?? null","content_handler":"content_handler ?? null"}},{"chat.completion":{"model":"model","messages":"messages","tool_choice":"tool_choice","tools":"tools","calls":"calls_handlers","content":"content_handler"}}]',
                'after' => NULL,
                'created_at' => '2025-04-02 04:23:13',
                'updated_at' => '2025-04-02 05:34:25',
            ),
            7 =>
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
        ));


    }
}
