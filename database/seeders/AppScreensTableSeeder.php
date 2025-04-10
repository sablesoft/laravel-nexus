<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppScreensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('app.screens')->delete();

        \DB::table('app.screens')->insert(array (
            0 =>
            array (
                'id' => 8,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 53,
                'title' => '{"en":"Porch"}',
                'code' => 'porch',
                'description' => NULL,
                'is_start' => false,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'states' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:54:06',
                'updated_at' => '2025-04-08 19:55:52',
            ),
            1 =>
            array (
                'id' => 7,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 52,
                'title' => '{"en":"Prologue"}',
                'code' => 'prologue',
                'description' => NULL,
                'is_start' => true,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'states' => '{"has": {"step": {"type": "int", "value": 0}, "steps": {"type": "int", "value": 3, "constant": true}, "isDone": {"type": "bool", "value": false}}}',
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 19:43:19',
                'updated_at' => '2025-04-09 04:57:42',
            ),
        ));


    }
}
