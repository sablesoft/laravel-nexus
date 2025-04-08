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
                'id' => 4,
                'user_id' => 1,
                'application_id' => 2,
                'image_id' => 33,
                'title' => 'Coast',
                'description' => NULL,
                'is_start' => false,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-03-28 05:53:06',
                'updated_at' => '2025-04-04 02:28:17',
            ),
            1 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'application_id' => 2,
                'image_id' => 39,
                'title' => 'Ice Peak',
                'description' => NULL,
                'is_start' => false,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-03-28 20:30:12',
                'updated_at' => '2025-04-04 02:28:17',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'application_id' => 2,
                'image_id' => 34,
                'title' => 'Journey',
                'description' => NULL,
                'is_start' => true,
                'query' => '":type" == screen.code',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-03-28 04:15:58',
                'updated_at' => '2025-04-04 02:28:17',
            ),
            3 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'application_id' => 3,
                'image_id' => 50,
                'title' => 'Lift',
                'description' => NULL,
                'is_start' => true,
            'query' => '":type" == screen.code()',
                'template' => NULL,
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-08 01:37:45',
                'updated_at' => '2025-04-08 01:42:12',
            ),
        ));
        
        
    }
}