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
            4 => 
            array (
                'id' => 11,
                'parent_id' => 13,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Look Inside"}',
                'description' => '{"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>look","what":[">>keyhole",">>window"],"to":[">>inside",">>room",">>interior"],"then":[{"merge":{"messages":[{"role":">>system","content":"media.note(\'room-desc\')"}]}},{"screen.waiting":true},{"chat.completion":{"async":true,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>look-inside"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:47:21',
                'updated_at' => '2025-04-19 10:47:21',
            ),
            5 => 
            array (
                'id' => 12,
                'parent_id' => 13,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Character Action","ru":"Character Action"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"comment":">>Classify character ask"},{"set":{"messages":"character_info"}},{"merge":{"messages":"screen.messages()"}},{"character.action":{"async":true,"messages":"messages","always":[{"merge":{"messages":[{"role":">>user","content":"ask"}]}},{"memory.create":{"author_id":"character.id()","content":"ask","meta":{"act":"act.toArray()"}}},{"chat.refresh":null}],"cases":"cases","default":[{"merge":{"messages":[{"role":">>system","content":"media.note(\'default-message\')"}]}},{"chat.completion":{"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"case":">>default"}}}]}},{"chat.refresh":null}]}},{"screen.waiting":true}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:52:50',
                'updated_at' => '2025-04-19 11:09:09',
            ),
        ));
        
        
    }
}