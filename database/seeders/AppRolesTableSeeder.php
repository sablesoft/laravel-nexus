<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.roles')->delete();
        
        
        
    }
}