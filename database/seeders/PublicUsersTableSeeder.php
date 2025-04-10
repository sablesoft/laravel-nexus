<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PublicUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('public.users')->delete();
        
        \DB::table('public.users')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Vasia',
                'email' => 'vasia@gmail.com',
                'email_verified_at' => '2025-03-10 20:07:28',
                'password' => '$2y$12$QU5xODGgTmlARwR1D.KTy.MIh5fv7z5X6jlNvpA85md6lAAQ4Plhu',
                'remember_token' => '3nvDItTm2qpjwKgVYhNLAiZtEuDMLQA21EwwhlE7GDTWhux89Tw9uOIKd6qa',
                'created_at' => '2025-03-10 20:06:57',
                'updated_at' => '2025-03-10 20:07:28',
                'language' => 'en',
            ),
            1 => 
            array (
                'id' => 1,
                'name' => 'Raman',
                'email' => 'sable.lair@gmail.com',
                'email_verified_at' => '2025-03-05 18:48:07',
                'password' => '$2y$12$gqzTj4axfOb/CiY4Ft5Ai.JC.P31L.einegDgA/DaKA.rTB.rCL.y',
                'remember_token' => 'jWes7vm78i10mYUMyunjPs4iHXWm3ojdhUMjq1tZg3Kf6dn2atWt90K5uCWF',
                'created_at' => '2025-03-04 21:17:48',
                'updated_at' => '2025-04-10 05:23:15',
                'language' => 'ru',
            ),
        ));
        
        
    }
}