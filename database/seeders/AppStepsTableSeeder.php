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
                'parent_id' => 4,
                'number' => 3,
                'scenario_id' => 1,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:11:07',
                'updated_at' => '2025-03-25 21:11:07',
            ),
            1 => 
            array (
                'id' => 1,
                'parent_id' => 4,
                'number' => 1,
                'scenario_id' => 3,
                'description' => 'Provides basic system prompt components instructing the assistant to act as a professional DALL·E 2 prompt engineer.',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:04:09',
                'updated_at' => '2025-03-28 23:44:15',
            ),
            2 => 
            array (
                'id' => 2,
                'parent_id' => 4,
                'number' => 2,
                'scenario_id' => 2,
                'description' => 'Generates a system message for the OpenAI chat completion based on predefined instructional parts for the assistant role. Required "system_parts" array.',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:06:31',
                'updated_at' => '2025-03-28 23:44:35',
            ),
        ));
        
        
    }
}