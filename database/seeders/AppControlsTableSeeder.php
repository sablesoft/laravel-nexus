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
                'title' => '{"en": "Continue"}',
                'tooltip' => '{"en":"Press to continue your story"}',
                'description' => '{"en":"Advances the prologue one step forward. Visible as long as the prologue is not yet finished. \nEach press progresses the narrative. After the final part, the button disappears and marks the prologue as complete."}',
                'before' => NULL,
                'after' => NULL,
            'visible_condition' => 'not screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:05:14',
                'updated_at' => '2025-04-09 03:57:57',
            ),
        ));


    }
}
