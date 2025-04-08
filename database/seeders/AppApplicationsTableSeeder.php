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
                'states' => '{"has": {"camp": {"type": "bool", "value": false}}}',
                'member_states' => '{"has": {"battle": {"type": "bool", "value": false}}}',
                'member_behaviors' => '{"can": {"fight": true}}',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-03-28 04:15:22',
                'updated_at' => '2025-04-06 06:20:58',
            ),
            1 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'image_id' => 46,
                'title' => 'Smart City',
                'description' => NULL,
                'is_public' => true,
                'states' => NULL,
                'member_states' => NULL,
                'member_behaviors' => NULL,
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-08 01:17:41',
                'updated_at' => '2025-04-08 01:42:36',
            ),
        ));
        
        
    }
}