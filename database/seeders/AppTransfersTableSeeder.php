<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppTransfersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.transfers')->delete();
        
        \DB::table('app.transfers')->insert(array (
            0 => 
            array (
                'id' => 5,
                'screen_from_id' => 7,
                'screen_to_id' => 8,
                'title' => '{"en":"Explore","ru":"\\u0418\\u0441\\u0441\\u043b\\u0435\\u0434\\u043e\\u0432\\u0430\\u0442\\u044c"}',
                'tooltip' => '{"en":"What else is there to do?","ru":"\\u0410 \\u0447\\u0442\\u043e \\u0435\\u0449\\u0435 \\u043e\\u0441\\u0442\\u0430\\u0435\\u0442\\u0441\\u044f \\u0434\\u0435\\u043b\\u0430\\u0442\\u044c?"}',
                'description' => '{"en":"Transitions to the next screen once the prologue is fully completed. \\nAppears only after all parts of the prologue have been shown. Becomes the player\\u2019s first active choice to explore the world.","ru":"\\u041f\\u0435\\u0440\\u0435\\u0445\\u043e\\u0434\\u0438\\u0442 \\u043d\\u0430 \\u0441\\u043b\\u0435\\u0434\\u0443\\u044e\\u0449\\u0438\\u0439 \\u044d\\u043a\\u0440\\u0430\\u043d \\u043f\\u043e\\u0441\\u043b\\u0435 \\u043f\\u043e\\u043b\\u043d\\u043e\\u0433\\u043e \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044f \\u043f\\u0440\\u043e\\u043b\\u043e\\u0433\\u0430.\\n\\u041f\\u043e\\u044f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u0442\\u043e\\u043b\\u044c\\u043a\\u043e \\u043f\\u043e\\u0441\\u043b\\u0435 \\u0442\\u043e\\u0433\\u043e, \\u043a\\u0430\\u043a \\u043f\\u043e\\u043a\\u0430\\u0437\\u0430\\u043d\\u044b \\u0432\\u0441\\u0435 \\u0447\\u0430\\u0441\\u0442\\u0438 \\u043f\\u0440\\u043e\\u043b\\u043e\\u0433\\u0430. \\u0421\\u0442\\u0430\\u043d\\u043e\\u0432\\u0438\\u0442\\u0441\\u044f \\u043f\\u0435\\u0440\\u0432\\u044b\\u043c \\u0430\\u043a\\u0442\\u0438\\u0432\\u043d\\u044b\\u043c \\u0432\\u044b\\u0431\\u043e\\u0440\\u043e\\u043c \\u0438\\u0433\\u0440\\u043e\\u043a\\u0430 \\u0434\\u043b\\u044f \\u043d\\u0430\\u0447\\u0430\\u043b\\u0430 \\u0438\\u0441\\u0441\\u043b\\u0435\\u0434\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u043c\\u0438\\u0440\\u0430."}',
                'before' => NULL,
                'after' => NULL,
            'visible_condition' => 'screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:06:27',
                'updated_at' => '2025-04-10 05:28:27',
            ),
        ));
        
        
    }
}