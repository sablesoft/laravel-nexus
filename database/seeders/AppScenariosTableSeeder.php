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
                'code' => 'chat-prompt-preparation',
                'title' => 'Chat - Prompt Preparation',
                'description' => 'Assembles a ready-to-use array of chat messages for the OpenAI Chat Completion API by composing system and user messages from modular scenarios.',
                'before' => '{"rules":{"ask":"required|string"},"data":{"messages":[]}}',
                'after' => '{"rules":{"messages":"required|array|size:2","messages.0.role":"required|in:system","messages.0.content":"required|string","messages.1.role":"required|in:user","messages.1.content":"required|string"}}',
                'created_at' => '2025-03-25 21:03:29',
                'updated_at' => '2025-03-26 04:10:41',
            ),
            1 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'code' => 'chat-system-parts',
                'title' => 'Chat - System Parts',
                'description' => 'Provides basic system prompt components instructing the assistant to act as a professional DALL·E 2 prompt engineer.',
                'before' => '{"data":{"system_parts": ["You act as a professional prompt engineer for DALL-E 2.","Your task is to detect the language of the user\'s request, then understand its meaning and generate a detailed prompt in English.","Return the result using the generate-prompt function. Use the second parameter \'comment\' to describe your reasoning in the original user language."]}}',
                'after' => '{"rules":{"system_parts":"required|array|min:1","system_parts.*":"required|string"}}',
                'created_at' => '2025-03-25 20:59:52',
                'updated_at' => '2025-03-26 04:13:42',
            ),
            2 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'code' => 'chat-build-system-message',
                'title' => 'Chat - Build System Message',
                'description' => 'Generates a system message for the OpenAI chat completion based on predefined instructional parts for the assistant role. Required "system_parts" array.',
            'before' => '{"rules":{"system_parts":"required|array|min:1","system_parts.*":"required|string"},"data":{"system_message":{"role":"system","content":"{{ join(system_parts, \' \') }}"},"messages":"{{ append(messages, system_message) }}"}}',
                'after' => '{"rules":{"messages":"required|array|min:1"},"cleanup":["system_parts","system_message"]}',
                'created_at' => '2025-03-25 17:58:41',
                'updated_at' => '2025-03-26 04:19:35',
            ),
            3 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'code' => 'chat-build-user-message',
                'title' => 'Chat - Build User Message',
            'description' => 'Converts the user\'s raw input (ask) into a chat message with the \'user\' role for the OpenAI chat completion.',
            'before' => '{"rules":{"ask":"required|string"},"data":{"user_message":{"role":"user","content":"{{ ask }}"},"messages":"{{ append(messages, user_message) }}"}}',
                'after' => '{"rules":{"messages":"required|array|min:1"},"cleanup":["user_message"]}',
                'created_at' => '2025-03-25 17:55:49',
                'updated_at' => '2025-03-26 04:24:47',
            ),
        ));
        
        
    }
}