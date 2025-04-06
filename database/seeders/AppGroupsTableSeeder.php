<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.groups')->delete();
        
        \DB::table('app.groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'application_id' => 2,
                'name' => 'Origins',
                'description' => NULL,
                'number' => 1,
                'roles_per_member' => 1,
                'is_required' => true,
                'created_at' => '2025-04-06 04:17:07',
                'updated_at' => '2025-04-06 04:17:07',
            ),
            1 => 
            array (
                'id' => 2,
                'application_id' => 2,
                'name' => 'Factions',
                'description' => NULL,
                'number' => 2,
                'roles_per_member' => 1,
                'is_required' => true,
                'created_at' => '2025-04-06 04:50:51',
                'updated_at' => '2025-04-06 04:50:51',
            ),
            2 => 
            array (
                'id' => 3,
                'application_id' => 2,
                'name' => 'Traits',
                'description' => NULL,
                'number' => 3,
                'roles_per_member' => 1,
                'is_required' => true,
                'created_at' => '2025-04-06 05:01:08',
                'updated_at' => '2025-04-06 05:01:08',
            ),
        ));
        
        
    }
}