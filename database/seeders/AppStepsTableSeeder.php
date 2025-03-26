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
                'id' => 1,
                'scenario_id' => 4,
                'number' => 1,
                'nested_id' => 3,
                'command' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:04:09',
                'updated_at' => '2025-03-25 21:04:09',
            ),
            1 => 
            array (
                'id' => 2,
                'scenario_id' => 4,
                'number' => 2,
                'nested_id' => 2,
                'command' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:06:31',
                'updated_at' => '2025-03-25 21:06:31',
            ),
            2 => 
            array (
                'id' => 3,
                'scenario_id' => 4,
                'number' => 3,
                'nested_id' => 1,
                'command' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-25 21:11:07',
                'updated_at' => '2025-03-25 21:11:07',
            ),
        ));
        
        
    }
}