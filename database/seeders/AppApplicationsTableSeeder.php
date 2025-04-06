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
                'id' => 2,
                'user_id' => 1,
                'image_id' => 3,
                'title' => 'Wild Crash',
                'description' => NULL,
                'is_public' => true,
                'states' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 04:15:22',
                'updated_at' => '2025-03-28 05:25:37',
            ),
        ));
        
        
    }
}