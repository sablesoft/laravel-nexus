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
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 2","then":[{"set":{"meta.tags":[">>audio-log"],"author":"character.id()"}},{"merge":{"messages":["note.message(\'lore-virus\', \'Lore:\')","note.message(\'lore-fractions\', \'Lore:\')","note.message(\'make-audio-log\', \'Make:\')"]}},{"memory.card":{"async":true,"type":">>place","layout":"note.content(\'layout-place\')","code":">>house","title":">>House","task":"note.content(\\"place-house\\")"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:24:01',
                'updated_at' => '2025-04-21 21:58:35',
            ),
            2 => 
            array (
                'id' => 14,
                'parent_id' => 13,
                'number' => 8,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Locked Door","en":"Case - Locked Door"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>open","what":[">>door",">>portal",">>entrance"],"then":[{"merge":{"messages":["note.message(\'make-locked-door\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>locked-door"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 02:42:29',
                'updated_at' => '2025-04-22 02:47:25',
            ),
            3 => 
            array (
                'id' => 19,
                'parent_id' => 13,
                'number' => 6,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Search Mat","en":"Case - Search Mat"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>search","what":[">>mat",">>doormat",">>rug",">>cover"],"for":[">>key",">>tool",">>item",">>hidden"],"then":[{"if":{"condition":"screen.state(\'hasKey\')","then":[{"merge":{"messages":["note.message(\'make-empty-mat\', \'Make:\')"]}}],"else":[{"if":{"condition":"screen.state(\'foundKey\')","then":[{"merge":{"messages":["note.message(\'make-mat-key\', \'Make:\')"]}}],"else":[{"merge":{"messages":["note.message(\'make-found-key\', \'Make:\')"]}},{"screen.state":{"values":{"foundKey":true}}}]}}]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>search-mat"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 02:38:08',
                'updated_at' => '2025-04-22 03:08:33',
            ),
            4 => 
            array (
                'id' => 20,
                'parent_id' => 13,
                'number' => 9,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Move Anywhere"}',
                'description' => '{"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>move","then":[{"set":{"pipe":true}},{"merge":{"messages":["note.message(\'make-move-anywhere\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>move-anywhere"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 04:29:23',
                'updated_at' => '2025-04-22 04:31:56',
            ),
            5 => 
            array (
                'id' => 4,
                'parent_id' => 12,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Forest Road","ru":"Forest Road"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 1","then":[{"merge":{"messages":["note.message(\'make-forest-road\', \'Make:\')"]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 16:51:43',
                'updated_at' => '2025-04-21 20:23:19',
            ),
            6 => 
            array (
                'id' => 3,
                'parent_id' => 12,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"en":"House by the Road","ru":"House by the Road"}',
                'description' => '{"ru":"Wonderful luck","en":"Wonderful luck"}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 3","then":[{"merge":{"messages":["memory.card(\'house\', \'place\')","note.message(\'rules-place\', \'Rules:\')","note.message(\'make-house\', \'Make:\')"]}},{"memory.card":{"async":true,"layout":"note.content(\'layout-place\')","type":">>place","code":">>porch","title":">>Porch","task":"note.content(\'place-porch\')"}},{"memory.card":{"async":true,"layout":"note.content(\'layout-place\')","type":">>place","code":">>room","title":">>Room","task":"note.content(\'place-room\')"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 05:45:45',
                'updated_at' => '2025-04-21 23:14:31',
            ),
            7 => 
            array (
                'id' => 12,
                'parent_id' => 13,
                'number' => 11,
                'scenario_id' => NULL,
                'name' => '{"en":"Character Action","ru":"Character Action"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"comment":">>Classify character ask"},{"character.action":{"async":true,"pipeFlag":">>pipe","messages":"messages","allowed":[">>look",">>search",">>open",">>take",">>move"],"before":[{"merge":{"messages":["note.message(\'rules-content\', \'Rules:\')"]}},{"memory.create":{"author_id":"character.id()","content":"ask","meta":{"weather":"chat.state(\'weather\')","time":"chat.state(\'time\')"}}},{"chat.refresh":null}],"always":[{"merge":{"messages":[{"role":">>user","content":"ask"}]}}],"cases":"cases","default":[{"merge":{"messages":["note.message(\'make-fun\', \'Make:\')"]}},{"chat.completion":{"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"act":"act.toArray()","case":">>default"}}}]}},{"chat.refresh":null}]}},{"screen.waiting":true}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:52:50',
                'updated_at' => '2025-04-22 06:21:26',
            ),
            8 => 
            array (
                'id' => 13,
                'parent_id' => 13,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Rules & Place","ru":"Rules & Context"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"messages":["note.message(\'rules-game\', \'Rules:\')","note.message(\'rules-place\', \'Rules:\')","memory.card(\'porch\', \'place\')"]}}]',
                'after' => NULL,
                'created_at' => '2025-04-19 18:53:05',
                'updated_at' => '2025-04-21 23:19:59',
            ),
            9 => 
            array (
                'id' => 11,
                'parent_id' => 13,
                'number' => 4,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Look Inside","ru":"Case - Look Inside"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>look","what":[">>keyhole",">>window"],"to":[">>inside",">>room",">>interior"],"then":[{"merge":{"messages":["memory.card(\'room\', \'place\')","note.message(\'make-look-inside\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>look-inside"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:47:21',
                'updated_at' => '2025-04-22 00:34:35',
            ),
            10 => 
            array (
                'id' => 18,
                'parent_id' => 13,
                'number' => 5,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Look Anything"}',
                'description' => '{"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>look","then":[{"merge":{"messages":["note.message(\'make-look-anything\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>look-anything"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 01:51:26',
                'updated_at' => '2025-04-22 01:52:59',
            ),
            11 => 
            array (
                'id' => 16,
                'parent_id' => 13,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Look Place","en":"Case - Look Place"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>look","what":[">>around",">>environment",">>surroundings"],"then":[{"merge":{"messages":["note.message(\'make-look-place\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>look-around"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 23:45:14',
                'updated_at' => '2025-04-22 02:12:42',
            ),
            12 => 
            array (
                'id' => 21,
                'parent_id' => 13,
                'number' => 10,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Take Key","en":"Case - Take Key"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>take","what":[">>key"],"then":[{"if":{"condition":"screen.state(\'hasKey\')","then":[{"merge":{"messages":["note.message(\'make-has-key\', \'Make:\')"]}}],"else":[{"if":{"condition":"screen.state(\'foundKey\')","then":[{"screen.state":{"values":{"hasKey":true}}},{"merge":{"messages":["note.message(\'make-take-key\', \'Make:\')"]}}],"else":[{"merge":{"messages":["note.message(\'make-unknown-key\', \'Make:\')"]}}]}}]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>take-key"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 06:21:20',
                'updated_at' => '2025-04-22 06:28:07',
            ),
            13 => 
            array (
                'id' => 15,
                'parent_id' => 13,
                'number' => 7,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Door Key"}',
                'description' => '{"en":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>open","what":[">>door",">>portal",">>entrance"],"using":[">>key",">>keys"],"then":[{"if":{"condition":"screen.state(\'hasKey\')","then":[{"merge":{"messages":["note.message(\'make-unlock-door\', \'Make:\')"]}},{"screen.state":{"values":{"opened":true}}}],"else":[{"merge":{"messages":["note.message(\'make-no-keys\', \'Make:\')"]}}]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>door-key"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 06:13:44',
                'updated_at' => '2025-04-22 06:41:25',
            ),
            14 => 
            array (
                'id' => 17,
                'parent_id' => 13,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Inspect Place","ru":"Case - Inspect Place"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"merge":{"!cases":[{"do":">>look","what":[">>around",">>environment",">>surroundings"],"how":[">>intently",">>carefully",">>attentively",">>diligently"],"then":[{"merge":{"messages":["note.message(\'make-inspect-place\', \'Make:\')"]}},{"chat.completion":{"async":false,"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","case":">>inspect-place"}}},{"chat.refresh":null}]}}]}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 00:33:01',
                'updated_at' => '2025-04-22 02:12:27',
            ),
        ));
        
        
    }
}