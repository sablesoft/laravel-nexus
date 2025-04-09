<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppApplicationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.applications')->delete();
        
        \DB::table('app.applications')->insert(array (
            0 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'image_id' => 51,
                'title' => 'In The Dust',
                'description' => 'A post-apocalyptic setting. A slow-burning mystery. A world that remembers.

This story invites you into a quiet, persistent narrative experience where survival is only part of the challenge. Explore forgotten places, make meaningful decisions, and adapt as the story unfolds — dynamically shaped by a new kind of generative storytelling engine. Every object, every detail, every choice matters.

Your journey begins in the dust of the ruined world. What follows is yours to uncover.',
                'is_public' => false,
                'states' => '{"has": {"time": {"type": "enum", "value": "evening", "options": ["morning", "noon", "evening", "night"]}, "weather": {"type": "enum", "value": "cloudy", "options": ["clear", "cloudy", "overcast", "rain", "storm", "fog"]}}}',
                'member_states' => NULL,
                'member_behaviors' => NULL,
            'before' => '[{"comment":">>Prepare weather and time"},{"chat.state":{"weather":"chat.randomState(\'weather\')","time":"chat.randomState(\'time\')"}}]',
                'after' => NULL,
                'created_at' => '2025-04-08 19:35:33',
                'updated_at' => '2025-04-09 05:03:08',
            ),
        ));
        
        
    }
}