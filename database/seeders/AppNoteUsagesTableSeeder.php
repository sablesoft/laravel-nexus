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
                'note_id' => 2,
                'noteable_type' => 'App\\Models\\Application',
                'noteable_id' => 1,
                'code' => 'dsds',
                'created_at' => '2025-04-19 07:10:29',
                'updated_at' => '2025-04-19 07:10:29',
            ),
            1 => 
            array (
                'note_id' => 3,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 4,
                'code' => 'instruction',
                'created_at' => '2025-04-19 08:32:21',
                'updated_at' => '2025-04-19 08:32:21',
            ),
            2 => 
            array (
                'note_id' => 5,
                'noteable_type' => 'App\\Models\\Screen',
                'noteable_id' => 1,
                'code' => 'greetings',
                'created_at' => '2025-04-19 09:15:53',
                'updated_at' => '2025-04-19 09:15:53',
            ),
            3 => 
            array (
                'note_id' => 6,
                'noteable_type' => 'App\\Models\\Transfer',
                'noteable_id' => 1,
                'code' => 'transfer',
                'created_at' => '2025-04-19 09:18:04',
                'updated_at' => '2025-04-19 09:18:04',
            ),
            4 => 
            array (
                'note_id' => 4,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 2,
                'code' => 'instruction',
                'created_at' => '2025-04-19 09:20:04',
                'updated_at' => '2025-04-19 09:20:04',
            ),
            5 => 
            array (
                'note_id' => 7,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 3,
                'code' => 'instruction',
                'created_at' => '2025-04-19 09:23:40',
                'updated_at' => '2025-04-19 09:23:40',
            ),
            6 => 
            array (
                'note_id' => 2,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'default-message',
                'created_at' => '2025-04-19 10:53:34',
                'updated_at' => '2025-04-19 10:53:34',
            ),
            7 => 
            array (
                'note_id' => 1,
                'noteable_type' => 'App\\Models\\Step',
                'noteable_id' => 12,
                'code' => 'room-desc',
                'created_at' => '2025-04-19 11:11:07',
                'updated_at' => '2025-04-19 11:11:07',
            ),
        ));
        
        
    }
}