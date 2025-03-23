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
                'screen_from_id' => 12,
                'screen_to_id' => 8,
                'code' => '12|8',
                'title' => 'Inventory',
                'tooltip' => 'Manage your inventory',
                'active' => NULL,
                'created_at' => '2025-03-23 05:05:02',
                'updated_at' => '2025-03-23 05:05:02',
            ),
            1 => 
            array (
                'id' => 2,
                'screen_from_id' => 12,
                'screen_to_id' => 3,
                'code' => '12|3',
                'title' => 'Journal',
                'tooltip' => 'Keep eye on your journal!',
                'active' => NULL,
                'created_at' => '2025-03-23 05:05:02',
                'updated_at' => '2025-03-23 05:05:02',
            ),
        ));
        
        
    }
}