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
                'id' => 2,
                'user_id' => 1,
                'application_id' => 3,
                'image_id' => NULL,
                'code' => 'sed',
                'title' => 'Voluptatum',
                'description' => 'At repudiandae ut sint ex. Nulla laudantium dolor atque. Velit et quia voluptatem aliquam nihil harum.',
                'is_default' => false,
                'constants' => NULL,
                'template' => NULL,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            1 =>
            array (
                'id' => 12,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 34,
                'code' => 'journey',
                'title' => 'Journey',
                'description' => 'Sint libero reprehenderit ad. Qui nisi quo molestias sit impedit non. Cumque voluptate et et dolorem ullam repellendus.',
                'is_default' => true,
                'constants' => NULL,
                'template' => NULL,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-19 21:23:24',
            ),
            2 =>
            array (
                'id' => 8,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 30,
                'code' => 'inventory',
                'title' => 'Inventory',
                'description' => 'Sed amet beatae deserunt beatae. Et reprehenderit odio dolores iste adipisci quam eaque omnis.',
                'is_default' => false,
                'constants' => NULL,
                'template' => NULL,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-19 21:24:58',
            ),
            3 =>
            array (
                'id' => 6,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 33,
                'code' => 'camp',
                'title' => 'Camp',
                'description' => 'Non laborum quaerat reiciendis accusantium vel ipsam. Recusandae expedita et incidunt ipsum adipisci voluptas et repellat.',
                'is_default' => false,
                'constants' => NULL,
                'template' => NULL,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 22:57:55',
            ),
            4 =>
            array (
                'id' => 3,
                'user_id' => 1,
                'application_id' => 4,
                'image_id' => 31,
                'code' => 'journal',
                'title' => 'Journal',
                'description' => 'Consectetur quasi dolor voluptate officiis. Quo molestias odit ad est enim laborum. Corrupti consequatur nisi qui eius ab veniam. Libero aspernatur accusantium sed qui.',
                'is_default' => false,
                'constants' => NULL,
                'template' => NULL,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:17:35',
            ),
        ));


    }
}
