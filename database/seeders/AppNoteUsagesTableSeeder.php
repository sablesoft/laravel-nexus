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
                'note_id' => 4,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 1,
                'code' => 'make-forest-road',
                'created_at' => '2025-04-24 04:04:01',
                'updated_at' => '2025-04-24 04:04:01',
            ),
            1 => 
            array (
                'note_id' => 2,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'lore-fractions',
                'created_at' => '2025-04-19 18:47:17',
                'updated_at' => '2025-04-19 18:47:17',
            ),
            2 => 
            array (
                'note_id' => 1,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'lore-virus',
                'created_at' => '2025-04-19 18:47:28',
                'updated_at' => '2025-04-19 18:47:28',
            ),
            3 => 
            array (
                'note_id' => 11,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'layout-place',
                'created_at' => '2025-04-24 04:11:13',
                'updated_at' => '2025-04-24 04:11:13',
            ),
            4 => 
            array (
                'note_id' => 1,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'lore-virus',
                'created_at' => '2025-04-19 19:04:12',
                'updated_at' => '2025-04-19 19:04:12',
            ),
            5 => 
            array (
                'note_id' => 2,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'lore-fractions',
                'created_at' => '2025-04-19 19:14:11',
                'updated_at' => '2025-04-19 19:14:11',
            ),
            6 => 
            array (
                'note_id' => 6,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'make-house',
                'created_at' => '2025-04-24 04:14:59',
                'updated_at' => '2025-04-24 04:14:59',
            ),
            7 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 14:55:38',
                'updated_at' => '2025-04-20 14:55:38',
            ),
            8 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 14:55:44',
                'updated_at' => '2025-04-20 14:55:44',
            ),
            9 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 14:56:28',
                'updated_at' => '2025-04-20 14:56:28',
            ),
            10 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 14:56:34',
                'updated_at' => '2025-04-20 14:56:34',
            ),
            11 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Scenario',
                'noteable_id' => 2,
                'code' => 'rules-game',
                'created_at' => '2025-04-20 15:04:12',
                'updated_at' => '2025-04-20 15:04:12',
            ),
            12 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Scenario',
                'noteable_id' => 2,
                'code' => 'rules-content',
                'created_at' => '2025-04-20 15:04:26',
                'updated_at' => '2025-04-20 15:04:26',
            ),
            13 => 
            array (
                'note_id' => 19,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 8,
                'code' => 'make-empty-mat',
                'created_at' => '2025-04-24 02:45:48',
                'updated_at' => '2025-04-24 02:45:48',
            ),
            14 => 
            array (
                'note_id' => 12,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'place-room',
                'created_at' => '2025-04-21 18:31:47',
                'updated_at' => '2025-04-21 18:31:47',
            ),
            15 => 
            array (
                'note_id' => 14,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'place-house',
                'created_at' => '2025-04-21 18:34:42',
                'updated_at' => '2025-04-21 18:34:42',
            ),
            16 => 
            array (
                'note_id' => 11,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'layout-place',
                'created_at' => '2025-04-21 19:43:25',
                'updated_at' => '2025-04-21 19:43:25',
            ),
            17 => 
            array (
                'note_id' => 16,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'place-porch',
                'created_at' => '2025-04-21 20:58:34',
                'updated_at' => '2025-04-21 20:58:34',
            ),
            18 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'rules-narrator',
                'created_at' => '2025-04-24 03:16:17',
                'updated_at' => '2025-04-24 03:16:17',
            ),
            19 => 
            array (
                'note_id' => 16,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'place-porch',
                'created_at' => '2025-04-21 21:05:39',
                'updated_at' => '2025-04-21 21:05:39',
            ),
            20 => 
            array (
                'note_id' => 15,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'rules-place',
                'created_at' => '2025-04-21 23:14:41',
                'updated_at' => '2025-04-21 23:14:41',
            ),
            21 => 
            array (
                'note_id' => 27,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 14,
                'code' => 'make-opened-door',
                'created_at' => '2025-04-24 03:20:48',
                'updated_at' => '2025-04-24 03:20:48',
            ),
            22 => 
            array (
                'note_id' => 28,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 14,
                'code' => 'make-floor-key',
                'created_at' => '2025-04-24 03:21:09',
                'updated_at' => '2025-04-24 03:21:09',
            ),
            23 => 
            array (
                'note_id' => 10,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 14,
                'code' => 'make-no-keys',
                'created_at' => '2025-04-24 03:21:23',
                'updated_at' => '2025-04-24 03:21:23',
            ),
            24 => 
            array (
                'note_id' => 13,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 14,
                'code' => 'make-unlock-door',
                'created_at' => '2025-04-24 03:21:30',
                'updated_at' => '2025-04-24 03:21:30',
            ),
            25 => 
            array (
                'note_id' => 29,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 7,
                'code' => 'make-look-inside',
                'created_at' => '2025-04-24 03:23:04',
                'updated_at' => '2025-04-24 03:23:04',
            ),
            26 => 
            array (
                'note_id' => 15,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 5,
                'code' => 'rules-place',
                'created_at' => '2025-04-24 03:25:55',
                'updated_at' => '2025-04-24 03:25:55',
            ),
            27 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 5,
                'code' => 'rules-game',
                'created_at' => '2025-04-24 03:26:56',
                'updated_at' => '2025-04-24 03:26:56',
            ),
            28 => 
            array (
                'note_id' => 30,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'make-look-place',
                'created_at' => '2025-04-24 03:29:24',
                'updated_at' => '2025-04-24 03:29:24',
            ),
            29 => 
            array (
                'note_id' => 17,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 11,
                'code' => 'make-inspect-place',
                'created_at' => '2025-04-24 03:30:15',
                'updated_at' => '2025-04-24 03:30:15',
            ),
            30 => 
            array (
                'note_id' => 25,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 6,
                'code' => 'make-look-anything',
                'created_at' => '2025-04-24 03:32:20',
                'updated_at' => '2025-04-24 03:32:20',
            ),
            31 => 
            array (
                'note_id' => 20,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 8,
                'code' => 'make-found-key',
                'created_at' => '2025-04-24 03:33:14',
                'updated_at' => '2025-04-24 03:33:14',
            ),
            32 => 
            array (
                'note_id' => 23,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 8,
                'code' => 'make-mat-key',
                'created_at' => '2025-04-24 03:33:31',
                'updated_at' => '2025-04-24 03:33:31',
            ),
            33 => 
            array (
                'note_id' => 7,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 4,
                'code' => 'make-locked-door',
                'created_at' => '2025-04-24 03:35:54',
                'updated_at' => '2025-04-24 03:35:54',
            ),
            34 => 
            array (
                'note_id' => 24,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 9,
                'code' => 'make-move-anywhere',
                'created_at' => '2025-04-24 03:37:04',
                'updated_at' => '2025-04-24 03:37:04',
            ),
            35 => 
            array (
                'note_id' => 18,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 15,
                'code' => 'make-has-key',
                'created_at' => '2025-04-24 03:37:39',
                'updated_at' => '2025-04-24 03:37:39',
            ),
            36 => 
            array (
                'note_id' => 21,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 15,
                'code' => 'make-take-key',
                'created_at' => '2025-04-24 03:38:34',
                'updated_at' => '2025-04-24 03:38:34',
            ),
            37 => 
            array (
                'note_id' => 22,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 15,
                'code' => 'make-unknown-key',
                'created_at' => '2025-04-24 03:39:06',
                'updated_at' => '2025-04-24 03:39:06',
            ),
            38 => 
            array (
                'note_id' => 8,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'rules-content',
                'created_at' => '2025-04-24 03:40:23',
                'updated_at' => '2025-04-24 03:40:23',
            ),
            39 => 
            array (
                'note_id' => 9,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'make-fun',
                'created_at' => '2025-04-24 03:42:19',
                'updated_at' => '2025-04-24 03:42:19',
            ),
            40 => 
            array (
                'note_id' => 3,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'make-greeting',
                'created_at' => '2025-04-24 03:52:01',
                'updated_at' => '2025-04-24 03:52:01',
            ),
            41 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'rules-narrator',
                'created_at' => '2025-04-24 03:52:32',
                'updated_at' => '2025-04-24 03:52:32',
            ),
            42 => 
            array (
                'note_id' => 14,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'place-house',
                'created_at' => '2025-04-24 03:56:51',
                'updated_at' => '2025-04-24 03:56:51',
            ),
            43 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'rules-narrator',
                'created_at' => '2025-04-24 03:57:24',
                'updated_at' => '2025-04-24 03:57:24',
            ),
            44 => 
            array (
                'note_id' => 31,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 3,
                'code' => 'make-transfer',
                'created_at' => '2025-04-24 04:00:09',
                'updated_at' => '2025-04-24 04:00:09',
            ),
            45 => 
            array (
                'note_id' => 26,
                'noteable_type' => 'App\\Models\\Scenario',
                'noteable_id' => 2,
                'code' => 'rules-narrator',
                'created_at' => '2025-04-24 04:01:19',
                'updated_at' => '2025-04-24 04:01:19',
            ),
            46 => 
            array (
                'note_id' => 32,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'layout-quest',
                'created_at' => '2025-04-24 05:19:06',
                'updated_at' => '2025-04-24 05:19:06',
            ),
            47 => 
            array (
                'note_id' => 34,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 3,
                'code' => 'quest-main',
                'created_at' => '2025-04-24 05:19:17',
                'updated_at' => '2025-04-24 05:19:17',
            ),
            48 => 
            array (
                'note_id' => 33,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 13,
                'code' => 'make-audio-log',
                'created_at' => '2025-04-24 05:45:21',
                'updated_at' => '2025-04-24 05:45:21',
            ),
        ));
        
        
    }
}