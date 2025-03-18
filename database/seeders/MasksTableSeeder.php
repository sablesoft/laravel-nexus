<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MasksTableSeeder extends Seeder
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
                'id' => 4,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Khalil Bailey',
                'description' => 'Non est quia aliquid dolores nihil. Voluptatum ut doloribus repudiandae error vitae totam. Dignissimos omnis porro autem. Minima voluptas magnam officia eos.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            1 =>
            array (
                'id' => 6,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Dr. Gabriel Weimann',
                'description' => 'Et omnis ut aut. Perspiciatis facilis fugit molestiae est aut. Id et magnam eos itaque omnis enim totam itaque.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            2 =>
            array (
                'id' => 7,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Ms. Callie Bosco',
                'description' => 'Quia qui qui animi eveniet fuga. Qui tempora non voluptatibus consectetur commodi laboriosam magnam similique. Et architecto omnis laudantium sunt consequatur similique.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 16:40:32',
            ),
            3 =>
            array (
                'id' => 14,
                'user_id' => 1,
                'image_id' => 26,
                'name' => 'Jennifer Gorczany',
                'description' => 'Eum doloribus quaerat laboriosam ex. Sed non ullam at cupiditate rerum inventore magnam. Est velit at pariatur inventore velit voluptas. Sunt quia deleniti dolor qui.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:17:50',
            ),
            4 =>
            array (
                'id' => 13,
                'user_id' => 1,
                'image_id' => 28,
                'name' => 'Cordelia Waelchi',
                'description' => 'Fuga non consectetur id quasi dolor quod iure. Voluptatem numquam dolores nihil nobis cumque. Quia non excepturi voluptatem voluptates. Perspiciatis natus cum fugit architecto.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:18:06',
            ),
            5 =>
            array (
                'id' => 12,
                'user_id' => 1,
                'image_id' => 27,
                'name' => 'Gaetano Quitzon',
                'description' => 'Cumque consequatur cupiditate fugiat et mollitia et est sunt. Sunt veritatis quod sed qui. In repellat exercitationem aut dolores impedit sunt molestiae eius. Laboriosam est molestias fugit id.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:18:25',
            ),
            6 =>
            array (
                'id' => 10,
                'user_id' => 1,
                'image_id' => 20,
                'name' => 'Sally Balistreri',
                'description' => 'Repudiandae esse qui exercitationem. Numquam perspiciatis voluptatem sed sed voluptatem placeat. Omnis molestiae tempora consequatur vel.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:18:54',
            ),
            7 =>
            array (
                'id' => 11,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Dr. Jensen Glover Sr.',
                'description' => 'Distinctio aut aut deserunt. Occaecati est nobis aut doloribus sed porro enim. Sapiente non dolorem quos.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:19:42',
            ),
            8 =>
            array (
                'id' => 9,
                'user_id' => 1,
                'image_id' => 23,
                'name' => 'Zack Kreiger IV',
                'description' => 'Atque amet nemo nam id commodi soluta molestiae. Velit et voluptas perferendis autem minima est porro.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:19:51',
            ),
            9 =>
            array (
                'id' => 5,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Brenda Eichmann',
                'description' => 'Molestiae sit iste excepturi consequatur sequi recusandae. Temporibus voluptatibus qui illo laudantium. Explicabo nemo consequatur assumenda labore aut facere sed.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 17:20:40',
            ),
            10 =>
            array (
                'id' => 3,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Octavia Stoltenberg I',
                'description' => 'Hic vitae aliquid aut et perspiciatis nihil ipsam. Natus officiis ut error qui quo sed quia soluta.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 17:20:52',
            ),
            11 =>
            array (
                'id' => 2,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Vivian Schneider',
                'description' => 'Sed unde nemo facere qui. Ipsum voluptatibus voluptatem aut eligendi iusto earum tempore. Modi repudiandae quis magnam et nam maiores veritatis. Esse officia est animi recusandae doloremque.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 17:20:57',
            ),
            12 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'image_id' => NULL,
                'name' => 'Mrs. Zoie Rohan III',
                'description' => 'Velit aut explicabo consequatur sit quibusdam beatae. Excepturi similique qui ea consequatur. Ea tempora rerum labore excepturi dolore est rem.',
                'is_public' => false,
                'created_at' => '2025-03-16 16:40:32',
                'updated_at' => '2025-03-16 17:21:02',
            ),
            13 =>
            array (
                'id' => 8,
                'user_id' => 1,
                'image_id' => 22,
                'name' => 'Lamont Hodkiewicz',
                'description' => 'Est dolor tenetur blanditiis vero. Sint iste nihil et et soluta inventore aut. Sunt vel consequatur quo corrupti dolor voluptas.',
                'is_public' => true,
                'created_at' => '2025-03-16 16:47:12',
                'updated_at' => '2025-03-16 17:21:49',
            ),
        ));


    }
}
