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
                'title' => '{"en":"Explore"}',
                'tooltip' => '{"en":"What else is there to do?"}',
                'description' => '{"en":"Transitions to the next screen once the prologue is fully completed. \nAppears only after all parts of the prologue have been shown. Becomes the player’s first active choice to explore the world."}',
                'before' => NULL,
                'after' => NULL,
            'visible_condition' => 'screen.state(\'isDone\')',
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 20:06:27',
                'updated_at' => '2025-04-09 03:57:27',
            ),
        ));


    }
}
