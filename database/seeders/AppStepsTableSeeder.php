<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppStepsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.steps')->delete();
        
        \DB::table('app.steps')->insert(array (
            0 => 
            array (
                'id' => 8,
                'parent_id' => 12,
                'number' => 4,
                'scenario_id' => 2,
                'name' => '{"en":"Chat Completion"}',
                'description' => '{"en":null}',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-17 17:55:51',
                'updated_at' => '2025-04-17 19:49:09',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 12,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Audio Log - Apocalipsys","ru":"Audio Log - Doomsday"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 2","then":[{"set":{"meta.tags":[">>audio-log"],"author":"character.id()"}},{"merge":{"messages":[{"role":">>system","content":">>Lore: {{ doomsday_virus}}. {{ fractions }}."},{"role":">>system","content":"media.note(\'instruction\')"}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:24:01',
                'updated_at' => '2025-04-19 09:20:19',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 12,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"en":"House by the Road"}',
                'description' => '{"ru":"Wonderful luck","en":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 3","then":[{"merge":{"messages":[{"role":">>system","content":"media.note(\'instruction\')"}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 05:45:45',
                'updated_at' => '2025-04-19 09:23:55',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 12,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Forest Road","ru":"Forest Road"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 1","then":[{"merge":{"messages":[{"role":">>system","content":"media.note(\'instruction\')"}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 16:51:43',
                'updated_at' => '2025-04-19 08:58:33',
            ),
        ));
        
        
    }
}