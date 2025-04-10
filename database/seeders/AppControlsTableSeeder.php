<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppControlsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.controls')->delete();
        
        \DB::table('app.controls')->insert(array (
            0 => 
            array (
                'id' => 4,
                'screen_id' => 7,
                'scenario_id' => NULL,
                'type' => 'action',
                'title' => '{"en":"Continue","ru":"\\u0414\\u0430\\u043b\\u0435\\u0435"}',
                'tooltip' => '{"en":"Press to continue your story","ru":"\\u041d\\u0430\\u0436\\u043c\\u0438\\u0442\\u0435 \\u0447\\u0442\\u043e\\u0431\\u044b \\u043f\\u0440\\u043e\\u0434\\u043e\\u043b\\u0436\\u0438\\u0442\\u044c \\u0438\\u0441\\u0442\\u043e\\u0440\\u0438\\u044e"}',
                'description' => '{"en":"Advances the prologue one step forward. Visible as long as the prologue is not yet finished. \\nEach press progresses the narrative. After the final part, the button disappears and marks the prologue as complete.","ru":"\\u041f\\u0440\\u043e\\u0434\\u0432\\u0438\\u0433\\u0430\\u0435\\u0442 \\u043f\\u0440\\u043e\\u043b\\u043e\\u0433 \\u043d\\u0430 \\u043e\\u0434\\u0438\\u043d \\u0448\\u0430\\u0433 \\u0432\\u043f\\u0435\\u0440\\u0451\\u0434. \\u0412\\u0438\\u0434\\u043d\\u0430 \\u0434\\u043e \\u0442\\u0435\\u0445 \\u043f\\u043e\\u0440, \\u043f\\u043e\\u043a\\u0430 \\u043f\\u0440\\u043e\\u043b\\u043e\\u0433 \\u043d\\u0435 \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0451\\u043d.\\n\\u041a\\u0430\\u0436\\u0434\\u043e\\u0435 \\u043d\\u0430\\u0436\\u0430\\u0442\\u0438\\u0435 \\u043f\\u0440\\u043e\\u0434\\u0432\\u0438\\u0433\\u0430\\u0435\\u0442 \\u043f\\u043e\\u0432\\u0435\\u0441\\u0442\\u0432\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435. \\u041f\\u043e\\u0441\\u043b\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0435\\u0439 \\u0447\\u0430\\u0441\\u0442\\u0438 \\u043a\\u043d\\u043e\\u043f\\u043a\\u0430 \\u0438\\u0441\\u0447\\u0435\\u0437\\u0430\\u0435\\u0442, \\u0430 \\u043f\\u0440\\u043e\\u043b\\u043e\\u0433 \\u0441\\u0447\\u0438\\u0442\\u0430\\u0435\\u0442\\u0441\\u044f \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0451\\u043d\\u043d\\u044b\\u043c."}',
                'before' => NULL,
                'after' => NULL,
            'visible_condition' => 'not screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:05:14',
                'updated_at' => '2025-04-10 05:27:19',
            ),
        ));
        
        
    }
}