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
                'id' => 1,
                'user_id' => 1,
                'image_id' => 51,
                'title' => '{"en":"In The Dust","ru":"Пыльный Мир"}',
                'description' => '{"en":"A post-apocalyptic setting. A slow-burning mystery. A world that remembers.\\nThis story invites you into a quiet, persistent narrative experience where survival is only part of the challenge. Explore forgotten places, make meaningful decisions, and adapt as the story unfolds — dynamically shaped by a new kind of generative storytelling engine. Every object, every detail, every choice matters.\\nYour journey begins in the dust of the ruined world. What follows is yours to uncover.","ru":"Постапокалиптический мир. Медленно разворачивающаяся тайна. Мир, который помнит.  \\nЭта история приглашает тебя в тихое, устойчивое повествование, где выживание — лишь часть испытания.  \\nИсследуй забытые места, принимай важные решения и подстраивайся под сюжет, который разворачивается динамически — при помощи нового генеративного движка.  \\nКаждый объект, каждая деталь, каждый выбор имеет значение.  \\nТвое путешествие начинается в пыли разрушенного мира. Что будет дальше — зависит от тебя."}',
                'is_public' => true,
                'seats' => 1,
                'states' => '{"has": {"time": {"type": "enum", "value": "evening", "options": ["morning", "noon", "evening", "night"]}, "weather": {"type": "enum", "value": "cloudy", "options": ["clear", "cloudy", "overcast", "rain", "storm", "fog"]}}}',
                'member_states' => NULL,
                'member_behaviors' => NULL,
            'before' => '[{"comment":">>Prepare weather and time"},{"chat.state":{"weather":"chat.randomState(\'weather\')","time":"chat.randomState(\'time\')"}}]',
                'after' => NULL,
                'created_at' => '2025-04-08 19:35:33',
                'updated_at' => '2025-04-12 00:38:03',
            ),
        ));
        
        
    }
}