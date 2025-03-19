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
                'id' => 1,
                'user_id' => 1,
                'image_id' => NULL,
                'title' => 'Repudiandae Qui',
                'description' => 'Eius autem praesentium deserunt tenetur iure impedit quia. Ipsa neque consequatur voluptatum accusantium odio. Est sed temporibus soluta.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'image_id' => NULL,
                'title' => 'Ratione Velit Qui',
                'description' => 'Iusto perspiciatis nobis temporibus rem. Non ad velit est quis ab. Vero qui odit sit doloribus ut in nulla alias. Veritatis deserunt ducimus ipsum accusamus.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'image_id' => NULL,
                'title' => 'Delectus Distinctio',
                'description' => 'Et minus culpa odio et cumque commodi ut nobis. Iste ullam dolorum earum consectetur rerum illum. Quidem aperiam nesciunt et voluptatibus.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            3 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'image_id' => NULL,
                'title' => 'Enim Consequatur',
                'description' => 'Esse aut aut qui vel. Accusamus ipsam quia perspiciatis sed. Sit et tempore molestias ipsam a alias. Facere optio dolore velit nulla eos.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 16:47:12',
            ),
            4 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'image_id' => NULL,
                'title' => 'Ea Sed Eaque',
                'description' => 'Nihil omnis ratione laboriosam consequatur libero quaerat aut. Dignissimos et suscipit voluptatem et. Nemo distinctio magnam quidem rerum vel.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 16:47:12',
            ),
            5 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'image_id' => 15,
                'title' => 'Eos Pariatur',
                'description' => 'Aut sunt maxime ratione laborum est. Harum inventore quo totam est mollitia. Exercitationem adipisci saepe incidunt omnis iste et fugit. Velit ab id voluptas autem dicta minima perferendis aut.',
                'constants' => NULL,
                'is_public' => false,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-17 06:11:43',
            ),
        ));
        
        
    }
}