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
                'id' => 6,
                'parent_id' => 10,
                'number' => 2,
                'scenario_id' => 7,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-03 21:30:03',
                'updated_at' => '2025-04-03 21:30:03',
            ),
            1 => 
            array (
                'id' => 5,
                'parent_id' => 10,
                'number' => 1,
                'scenario_id' => 9,
                'description' => NULL,
                'before' => NULL,
                'after' => '[{"push":{"messages":{"role":">>system","content":">>Use a space fantasy setting"}}}]',
                'created_at' => '2025-04-03 21:29:41',
                'updated_at' => '2025-04-03 21:39:21',
            ),
            2 => 
            array (
                'id' => 9,
                'parent_id' => 13,
                'number' => 4,
                'scenario_id' => 7,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 00:43:34',
                'updated_at' => '2025-04-08 02:12:28',
            ),
            3 => 
            array (
                'id' => 8,
                'parent_id' => 13,
                'number' => 3,
                'scenario_id' => 11,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 00:43:20',
                'updated_at' => '2025-04-08 02:12:30',
            ),
            4 => 
            array (
                'id' => 7,
                'parent_id' => 13,
                'number' => 2,
                'scenario_id' => 12,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 00:43:04',
                'updated_at' => '2025-04-08 02:12:32',
            ),
            5 => 
            array (
                'id' => 11,
                'parent_id' => 13,
                'number' => 1,
                'scenario_id' => 14,
                'description' => 'Add lift description',
                'before' => NULL,
                'after' => '[{"push":{"messages":{"role":">>assistant","content":"lift_description"}}},{"set":{"ask":"ask ?? \'Look out the window\'"}}]',
                'created_at' => '2025-04-08 02:11:49',
                'updated_at' => '2025-04-08 03:50:09',
            ),
        ));
        
        
    }
}