<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppMasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.masks')->delete();
        
        \DB::table('app.masks')->insert(array (
            0 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'image_id' => 22,
                'portrait_id' => 45,
                'name' => 'Survivor',
                'description' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-28 05:29:08',
                'updated_at' => '2025-03-28 05:31:17',
            ),
        ));
        
        
    }
}