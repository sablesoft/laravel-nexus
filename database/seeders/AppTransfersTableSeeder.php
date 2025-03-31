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
                'id' => 1,
                'screen_from_id' => 4,
                'screen_to_id' => 3,
                'code' => '4|3',
                'title' => 'Journey',
                'tooltip' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 05:53:52',
                'updated_at' => '2025-03-28 20:29:31',
            ),
            1 => 
            array (
                'id' => 3,
                'screen_from_id' => 3,
                'screen_to_id' => 5,
                'code' => '3|5',
                'title' => 'Ice Peak',
                'tooltip' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 20:31:30',
                'updated_at' => '2025-03-28 23:48:48',
            ),
            2 => 
            array (
                'id' => 2,
                'screen_from_id' => 3,
                'screen_to_id' => 4,
                'code' => '3|4',
                'title' => 'Coast',
                'tooltip' => NULL,
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 05:55:10',
                'updated_at' => '2025-03-28 23:48:57',
            ),
            3 => 
            array (
                'id' => 4,
                'screen_from_id' => 5,
                'screen_to_id' => 3,
                'code' => '5|3',
                'title' => 'Journey',
                'tooltip' => 'Return back',
                'description' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 23:55:36',
                'updated_at' => '2025-03-28 23:55:36',
            ),
        ));
        
        
    }
}