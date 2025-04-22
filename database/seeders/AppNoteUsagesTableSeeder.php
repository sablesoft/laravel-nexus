<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppNoteUsagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.note_usages')->delete();
        
        \DB::table('app.note_usages')->insert(array (
            0 => 
            array (
                'note_id' => 12,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'rules-content',
                'created_at' => '2025-04-22 06:14:30',
                'updated_at' => '2025-04-22 06:14:30',
            ),
            1 => 
            array (
                'note_id' => 34,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-has-key',
                'created_at' => '2025-04-22 06:34:59',
                'updated_at' => '2025-04-22 06:34:59',
            ),
            2 => 
            array (
                'note_id' => 3,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 4,
                'code' => 'make-forest-road',
                'created_at' => '2025-04-19 18:42:53',
                'updated_at' => '2025-04-19 18:42:53',
            ),
            3 => 
            array (
                'note_id' => 4,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'make-audio-log',
                'created_at' => '2025-04-19 18:43:51',
                'updated_at' => '2025-04-19 18:43:51',
            ),
            4 => 
            array (
                'note_id' => 9,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'lore-fractions',
                'created_at' => '2025-04-19 18:47:17',
                'updated_at' => '2025-04-19 18:47:17',
            ),
            5 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'lore-virus',
                'created_at' => '2025-04-19 18:47:28',
                'updated_at' => '2025-04-19 18:47:28',
            ),
            6 => 
            array (
                'note_id' => 7,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'make-house',
                'created_at' => '2025-04-19 18:47:55',
                'updated_at' => '2025-04-19 18:47:55',
            ),
            7 => 
            array (
                'note_id' => 35,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-take-key',
                'created_at' => '2025-04-22 06:36:37',
                'updated_at' => '2025-04-22 06:36:37',
            ),
            8 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'lore-virus',
                'created_at' => '2025-04-19 19:04:12',
                'updated_at' => '2025-04-19 19:04:12',
            ),
            9 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'make-greeting',
                'created_at' => '2025-04-19 19:07:11',
                'updated_at' => '2025-04-19 19:07:11',
            ),
            10 => 
            array (
                'note_id' => 9,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'lore-fractions',
                'created_at' => '2025-04-19 19:14:11',
                'updated_at' => '2025-04-19 19:14:11',
            ),
            11 => 
            array (
                'note_id' => 36,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-unknown-key',
                'created_at' => '2025-04-22 06:38:17',
                'updated_at' => '2025-04-22 06:38:17',
            ),
            12 => 
            array (
                'note_id' => 12,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 14:55:38',
                'updated_at' => '2025-04-20 14:55:38',
            ),
            13 => 
            array (
                'note_id' => 10,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 14:55:44',
                'updated_at' => '2025-04-20 14:55:44',
            ),
            14 => 
            array (
                'note_id' => 12,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 14:56:28',
                'updated_at' => '2025-04-20 14:56:28',
            ),
            15 => 
            array (
                'note_id' => 10,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 14:56:34',
                'updated_at' => '2025-04-20 14:56:34',
            ),
            16 => 
            array (
                'note_id' => 10,
                'noteable_type' => 'App\\Models\\Scenario',
                'noteable_id' => 12,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 15:04:12',
                'updated_at' => '2025-04-20 15:04:12',
            ),
            17 => 
            array (
                'note_id' => 12,
                'noteable_type' => 'App\\Models\\Scenario',
                'noteable_id' => 12,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 15:04:26',
                'updated_at' => '2025-04-20 15:04:26',
            ),
            18 => 
            array (
                'note_id' => 10,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 15:10:20',
                'updated_at' => '2025-04-20 15:10:20',
            ),
            19 => 
            array (
                'note_id' => 2,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-fun',
                'created_at' => '2025-04-21 16:51:41',
                'updated_at' => '2025-04-21 16:51:41',
            ),
            20 => 
            array (
                'note_id' => 22,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'place-room',
                'created_at' => '2025-04-21 18:31:47',
                'updated_at' => '2025-04-21 18:31:47',
            ),
            21 => 
            array (
                'note_id' => 23,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'place-house',
                'created_at' => '2025-04-21 18:34:42',
                'updated_at' => '2025-04-21 18:34:42',
            ),
            22 => 
            array (
                'note_id' => 24,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'layout-place',
                'created_at' => '2025-04-21 19:40:59',
                'updated_at' => '2025-04-21 19:40:59',
            ),
            23 => 
            array (
                'note_id' => 24,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'layout-place',
                'created_at' => '2025-04-21 19:43:25',
                'updated_at' => '2025-04-21 19:43:25',
            ),
            24 => 
            array (
                'note_id' => 25,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'place-porch',
                'created_at' => '2025-04-21 20:58:34',
                'updated_at' => '2025-04-21 20:58:34',
            ),
            25 => 
            array (
                'note_id' => 23,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'place-house',
                'created_at' => '2025-04-21 21:05:11',
                'updated_at' => '2025-04-21 21:05:11',
            ),
            26 => 
            array (
                'note_id' => 25,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'place-porch',
                'created_at' => '2025-04-21 21:05:39',
                'updated_at' => '2025-04-21 21:05:39',
            ),
            27 => 
            array (
                'note_id' => 6,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'make-transfer',
                'created_at' => '2025-04-21 22:40:24',
                'updated_at' => '2025-04-21 22:40:24',
            ),
            28 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'rules-place',
                'created_at' => '2025-04-21 23:14:41',
                'updated_at' => '2025-04-21 23:14:41',
            ),
            29 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'rules-place',
                'created_at' => '2025-04-21 23:20:24',
                'updated_at' => '2025-04-21 23:20:24',
            ),
            30 => 
            array (
                'note_id' => 28,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-inspect-place',
                'created_at' => '2025-04-22 02:05:45',
                'updated_at' => '2025-04-22 02:05:45',
            ),
            31 => 
            array (
                'note_id' => 27,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-look-place',
                'created_at' => '2025-04-22 02:06:26',
                'updated_at' => '2025-04-22 02:06:26',
            ),
            32 => 
            array (
                'note_id' => 1,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-look-inside',
                'created_at' => '2025-04-22 02:06:55',
                'updated_at' => '2025-04-22 02:06:55',
            ),
            33 => 
            array (
                'note_id' => 29,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-look-anything',
                'created_at' => '2025-04-22 02:07:29',
                'updated_at' => '2025-04-22 02:07:29',
            ),
            34 => 
            array (
                'note_id' => 20,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-no-keys',
                'created_at' => '2025-04-22 02:07:59',
                'updated_at' => '2025-04-22 02:07:59',
            ),
            35 => 
            array (
                'note_id' => 21,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-unlock-door',
                'created_at' => '2025-04-22 02:08:11',
                'updated_at' => '2025-04-22 02:08:11',
            ),
            36 => 
            array (
                'note_id' => 13,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-locked-door',
                'created_at' => '2025-04-22 02:23:28',
                'updated_at' => '2025-04-22 02:23:28',
            ),
            37 => 
            array (
                'note_id' => 30,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-empty-mat',
                'created_at' => '2025-04-22 02:59:34',
                'updated_at' => '2025-04-22 02:59:34',
            ),
            38 => 
            array (
                'note_id' => 31,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-mat-key',
                'created_at' => '2025-04-22 03:01:39',
                'updated_at' => '2025-04-22 03:01:39',
            ),
            39 => 
            array (
                'note_id' => 32,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-found-key',
                'created_at' => '2025-04-22 03:05:06',
                'updated_at' => '2025-04-22 03:05:06',
            ),
            40 => 
            array (
                'note_id' => 33,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-move-anywhere',
                'created_at' => '2025-04-22 04:48:47',
                'updated_at' => '2025-04-22 04:48:47',
            ),
        ));
        
        
    }
}