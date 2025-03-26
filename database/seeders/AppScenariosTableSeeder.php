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
                'id' => 1,
                'user_id' => 1,
                'code' => 'chat-build-user-message',
                'title' => 'Chat - Build User Message',
            'description' => 'Converts the user\'s raw input (ask) into a chat message with the \'user\' role for the OpenAI chat completion.',
            'before' => '{"user_message":{"role":"user","content": "{{ ask }}"},"messages": "{{ append(messages, user_message) }}"}',
                'after' => NULL,
                'created_at' => '2025-03-25 17:55:49',
                'updated_at' => '2025-03-25 21:12:20',
            ),
            1 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'code' => 'chat-prompt-preparation',
                'title' => 'Chat - Prompt Preparation',
                'description' => 'Assembles a ready-to-use array of chat messages for the OpenAI Chat Completion API by composing system and user messages from modular scenarios.',
                'before' => '{"messages" : []}',
                'after' => NULL,
                'created_at' => '2025-03-25 21:03:29',
                'updated_at' => '2025-03-25 21:04:46',
            ),
            2 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'code' => 'chat-build-system-message',
                'title' => 'Chat - Build System Message',
                'description' => 'Generates a system message for the OpenAI chat completion based on predefined instructional parts for the assistant role. Required "system_parts" array.',
            'before' => '{"data":{"system_message": {"role": "system","content":"{{ join(system_parts, \' \') }}"},"messages":"{{ append(messages, system_message) }}"}}',
                'after' => NULL,
                'created_at' => '2025-03-25 17:58:41',
                'updated_at' => '2025-03-25 22:46:53',
            ),
            3 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'code' => 'chat-system-parts',
                'title' => 'Chat - System Parts',
                'description' => 'Provides basic system prompt components instructing the assistant to act as a professional DALL·E 2 prompt engineer.',
                'before' => '{"data":{"system_parts": ["You act as a professional prompt engineer for DALL-E 2.","Your task is to detect the language of the user\'s request, then understand its meaning and generate a detailed prompt in English.","Return the result using the generate-prompt function. Use the second parameter \'comment\' to describe your reasoning in the original user language."]}}',
                'after' => '{"rules": {"system_parts": "required|array"}}',
                'created_at' => '2025-03-25 20:59:52',
                'updated_at' => '2025-03-25 22:45:52',
            ),
        ));
        
        
    }
}