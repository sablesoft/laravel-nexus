<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppScenariosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('app.scenarios')->delete();

        \DB::table('app.scenarios')->insert(array (
            0 =>
            array (
                'id' => 6,
                'user_id' => 1,
                'code' => 'saepe',
                'title' => 'Ut Error',
                'description' => 'Consequatur harum reprehenderit explicabo libero assumenda. Omnis harum ut et saepe rerum fugit. Dolorum velit impedit possimus molestias minima rerum quis.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            1 =>
            array (
                'id' => 27,
                'user_id' => 1,
                'code' => 'act',
                'title' => 'Act',
                'description' => 'Magnam et consequuntur dolorum eaque. Officiis voluptatem ipsa illum architecto voluptas quia sit.',
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-21 22:51:27',
            ),
            2 =>
            array (
                'id' => 13,
                'user_id' => 1,
                'code' => 'camp',
                'title' => 'Camp',
                'description' => 'Ratione expedita perspiciatis earum qui nesciunt consequatur. Deleniti quia soluta consequatur sit ratione qui.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 22:56:06',
            ),
            3 =>
            array (
                'id' => 7,
                'user_id' => 1,
                'code' => 'set-off',
                'title' => 'Set Off',
                'description' => 'Ex voluptas voluptas culpa neque nihil qui illum. Dignissimos aspernatur aut accusantium iste omnis aut dolor. Animi et ipsum impedit et officiis adipisci. Qui commodi est neque optio distinctio.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:00:23',
            ),
            4 =>
            array (
                'id' => 19,
                'user_id' => 1,
                'code' => 'chat',
                'title' => 'Chat',
                'description' => 'Incidunt sed nulla qui. Veniam mollitia sed quidem maxime. Consequatur modi sint sit eos nihil autem hic eveniet. Dolorum et quasi iusto temporibus sit cumque.',
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-21 23:01:56',
            ),
            5 =>
            array (
                'id' => 18,
                'user_id' => 1,
                'code' => 'rest',
                'title' => 'Rest',
                'description' => 'Quasi omnis deleniti aut id enim. Voluptatem soluta repellat culpa velit et eveniet quae. Et odit dolores iusto similique ipsum sint eum ut. Ullam sit praesentium aut asperiores ipsum aut qui itaque.',
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-21 23:02:58',
            ),
            6 =>
            array (
                'id' => 11,
                'user_id' => 1,
                'code' => 'return',
                'title' => 'Return',
                'description' => 'Quis eum quia excepturi et. Eveniet dolorum magnam eos consequatur dignissimos. Quia soluta iure nobis totam sint ullam.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:07:17',
            ),
            7 =>
            array (
                'id' => 4,
                'user_id' => 1,
                'code' => 'note',
                'title' => 'Note',
                'description' => 'Similique itaque temporibus sit quas est et voluptas minus. Id est placeat officiis. Incidunt pariatur architecto totam ipsa velit soluta.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:19:07',
            ),
            8 =>
            array (
                'id' => 5,
                'user_id' => 1,
                'code' => 'search',
                'title' => 'Search',
                'description' => 'Quae porro ut id. Est magni temporibus et est amet possimus exercitationem. Aut deserunt commodi mollitia commodi.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:20:04',
            ),
            9 =>
            array (
                'id' => 8,
                'user_id' => 1,
                'code' => 'journey-event',
                'title' => 'Road Event',
                'description' => 'Amet ad blanditiis maxime voluptatem. Optio sit a rerum sed possimus aspernatur commodi impedit. Dolor et ipsam molestiae illum iusto.',
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-21 23:41:18',
            ),
        ));


    }
}
