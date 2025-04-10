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
                'title' => '{"en":"In The Dust","ru":"\\u041f\\u044b\\u043b\\u044c\\u043d\\u044b\\u0439 \\u041c\\u0438\\u0440"}',
                'description' => '{"en":"A post-apocalyptic setting. A slow-burning mystery. A world that remembers.\\nThis story invites you into a quiet, persistent narrative experience where survival is only part of the challenge. Explore forgotten places, make meaningful decisions, and adapt as the story unfolds \\u2014 dynamically shaped by a new kind of generative storytelling engine. Every object, every detail, every choice matters.\\nYour journey begins in the dust of the ruined world. What follows is yours to uncover.","ru":"\\u041f\\u043e\\u0441\\u0442\\u0430\\u043f\\u043e\\u043a\\u0430\\u043b\\u0438\\u043f\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0439 \\u043c\\u0438\\u0440. \\u041c\\u0435\\u0434\\u043b\\u0435\\u043d\\u043d\\u043e \\u0440\\u0430\\u0437\\u0432\\u043e\\u0440\\u0430\\u0447\\u0438\\u0432\\u0430\\u044e\\u0449\\u0430\\u044f\\u0441\\u044f \\u0442\\u0430\\u0439\\u043d\\u0430. \\u041c\\u0438\\u0440, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u043f\\u043e\\u043c\\u043d\\u0438\\u0442.  \\n\\u042d\\u0442\\u0430 \\u0438\\u0441\\u0442\\u043e\\u0440\\u0438\\u044f \\u043f\\u0440\\u0438\\u0433\\u043b\\u0430\\u0448\\u0430\\u0435\\u0442 \\u0442\\u0435\\u0431\\u044f \\u0432 \\u0442\\u0438\\u0445\\u043e\\u0435, \\u0443\\u0441\\u0442\\u043e\\u0439\\u0447\\u0438\\u0432\\u043e\\u0435 \\u043f\\u043e\\u0432\\u0435\\u0441\\u0442\\u0432\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435, \\u0433\\u0434\\u0435 \\u0432\\u044b\\u0436\\u0438\\u0432\\u0430\\u043d\\u0438\\u0435 \\u2014 \\u043b\\u0438\\u0448\\u044c \\u0447\\u0430\\u0441\\u0442\\u044c \\u0438\\u0441\\u043f\\u044b\\u0442\\u0430\\u043d\\u0438\\u044f.  \\n\\u0418\\u0441\\u0441\\u043b\\u0435\\u0434\\u0443\\u0439 \\u0437\\u0430\\u0431\\u044b\\u0442\\u044b\\u0435 \\u043c\\u0435\\u0441\\u0442\\u0430, \\u043f\\u0440\\u0438\\u043d\\u0438\\u043c\\u0430\\u0439 \\u0432\\u0430\\u0436\\u043d\\u044b\\u0435 \\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u044f \\u0438 \\u043f\\u043e\\u0434\\u0441\\u0442\\u0440\\u0430\\u0438\\u0432\\u0430\\u0439\\u0441\\u044f \\u043f\\u043e\\u0434 \\u0441\\u044e\\u0436\\u0435\\u0442, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0440\\u0430\\u0437\\u0432\\u043e\\u0440\\u0430\\u0447\\u0438\\u0432\\u0430\\u0435\\u0442\\u0441\\u044f \\u0434\\u0438\\u043d\\u0430\\u043c\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438 \\u2014 \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0449\\u0438 \\u043d\\u043e\\u0432\\u043e\\u0433\\u043e \\u0433\\u0435\\u043d\\u0435\\u0440\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e\\u0433\\u043e \\u0434\\u0432\\u0438\\u0436\\u043a\\u0430.  \\n\\u041a\\u0430\\u0436\\u0434\\u044b\\u0439 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442, \\u043a\\u0430\\u0436\\u0434\\u0430\\u044f \\u0434\\u0435\\u0442\\u0430\\u043b\\u044c, \\u043a\\u0430\\u0436\\u0434\\u044b\\u0439 \\u0432\\u044b\\u0431\\u043e\\u0440 \\u0438\\u043c\\u0435\\u0435\\u0442 \\u0437\\u043d\\u0430\\u0447\\u0435\\u043d\\u0438\\u0435.  \\n\\u0422\\u0432\\u043e\\u0435 \\u043f\\u0443\\u0442\\u0435\\u0448\\u0435\\u0441\\u0442\\u0432\\u0438\\u0435 \\u043d\\u0430\\u0447\\u0438\\u043d\\u0430\\u0435\\u0442\\u0441\\u044f \\u0432 \\u043f\\u044b\\u043b\\u0438 \\u0440\\u0430\\u0437\\u0440\\u0443\\u0448\\u0435\\u043d\\u043d\\u043e\\u0433\\u043e \\u043c\\u0438\\u0440\\u0430. \\u0427\\u0442\\u043e \\u0431\\u0443\\u0434\\u0435\\u0442 \\u0434\\u0430\\u043b\\u044c\\u0448\\u0435 \\u2014 \\u0437\\u0430\\u0432\\u0438\\u0441\\u0438\\u0442 \\u043e\\u0442 \\u0442\\u0435\\u0431\\u044f."}',
                'is_public' => true,
                'states' => '{"has": {"time": {"type": "enum", "value": "evening", "options": ["morning", "noon", "evening", "night"]}, "weather": {"type": "enum", "value": "cloudy", "options": ["clear", "cloudy", "overcast", "rain", "storm", "fog"]}}}',
                'member_states' => NULL,
                'member_behaviors' => NULL,
            'before' => '[{"comment":">>Prepare weather and time"},{"chat.state":{"weather":"chat.randomState(\'weather\')","time":"chat.randomState(\'time\')"}}]',
                'after' => NULL,
                'created_at' => '2025-04-08 19:35:33',
                'updated_at' => '2025-04-10 05:31:41',
            ),
        ));
        
        
    }
}