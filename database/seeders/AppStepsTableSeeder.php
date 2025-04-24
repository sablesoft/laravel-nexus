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
                'id' => 1,
                'parent_id' => 2,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Forest Road","ru":"Forest Road"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"merge.if":{"condition":"screen.state(\'step\') == 1","values":{"messages":["note.message(\'make-forest-road\', \'Make:\')"]}}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 16:51:43',
                'updated_at' => '2025-04-24 04:05:13',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 2,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"en":"House by the Road","ru":"House by the Road"}',
                'description' => '{"ru":"Wonderful luck","en":"Wonderful luck"}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 3","then":[{"merge":{"messages":["memory.card(\'house\', \'place\')","note.message(\'rules-place\', \'Rules:\')","note.message(\'make-house\', \'Make:\')"]}},{"memory.card":{"async":true,"layout":"note.content(\'layout-place\')","type":">>place","code":">>porch","title":">>Porch","task":"note.content(\'place-porch\')"}},{"memory.card":{"async":true,"layout":"note.content(\'layout-place\')","type":">>place","code":">>room","title":">>Room","task":"note.content(\'place-room\')"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 05:45:45',
                'updated_at' => '2025-04-21 23:14:31',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 1,
                'number' => 3,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Look Place","en":"Case - Look Place"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"set":{"message_look_place":"note.message(\'make-look-place\', \'Make:\')"}},{"action.case":{"name":">>look-around","do":">>look","what":[">>around",">>environment",">>surroundings"],"then":[{"merge":{"messages":["message_look_place"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 23:45:14',
                'updated_at' => '2025-04-24 02:41:13',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 1,
                'number' => 8,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Locked Door","en":"Case - Locked Door"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"set":{"message_locked_door":"note.message(\'make-locked-door\', \'Make:\')"}},{"action.case":{"name":">>locked-door","do":">>open","what":[">>door",">>portal",">>entrance"],"then":[{"merge":{"messages":["message_locked_door"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 02:42:29',
                'updated_at' => '2025-04-24 02:57:13',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 1,
                'number' => 1,
                'scenario_id' => NULL,
                'name' => '{"en":"Rules & Place","ru":"Rules & Context"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"messages":["note.message(\'rules-game\', \'Rules:\')","note.message(\'rules-place\', \'Rules:\')","memory.card(\'porch\', \'place\')"],"opened":"screen.state(\'opened\')","hasKey":"screen.state(\'hasKey\')","foundKey":"screen.state(\'foundKey\')"}},{"function.set":{"name":">>generate_response","effects":[{"chat.completion":{"messages":"messages","content":[{"memory.create":{"content":"content","meta":{"match":"match","act":"act.toArray()","case":"case"}}},{"chat.refresh":null}]}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-19 18:53:05',
                'updated_at' => '2025-04-24 02:25:59',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 1,
                'number' => 5,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Look Anything","ru":"Case - Look Anything"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"message_look_anything":"note.message(\'make-look-anything\', \'Make:\')"}},{"action.case":{"name":">>look","do":">>look","then":[{"merge":{"messages":["message_look_anything"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 01:51:26',
                'updated_at' => '2025-04-24 02:44:33',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 1,
                'number' => 4,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Look Inside","ru":"Case - Look Inside"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"message_look_inside":"note.message(\'make-look-inside\', \'Make:\')"}},{"action.case":{"name":">>look-inside","do":">>look","what":[">>keyhole",">>window"],"to":[">>inside",">>room",">>interior"],"then":[{"merge":{"messages":["memory.card(\'room\', \'place\')","message_look_inside"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:47:21',
                'updated_at' => '2025-04-24 02:43:29',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 1,
                'number' => 6,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Search Mat","en":"Case - Search Mat"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"set":{"message_empty_mat":"note.message(\'make-empty-mat\', \'Make:\')","message_mat_key":"note.message(\'make-mat-key\', \'Make:\')","message_found_key":"note.message(\'make-found-key\', \'Make:\')"}},{"action.case":{"name":">>search-mat","do":">>search","what":[">>mat",">>doormat",">>rug",">>cover"],"for":[">>key",">>tool",">>item",">>hidden"],"then":[{"comment":">>Prepare response instruction"},{"merge.if":{"condition":"hasKey","values":{"messages":["message_empty_mat"]}}},{"merge.if":{"condition":"not hasKey and foundKey","values":{"messages":["message_mat_key"]}}},{"merge.if":{"condition":"not (hasKey or foundKey)","values":{"messages":["message_found_key"]}}},{"comment":">>Update foundKey state"},{"screen.state":{"condition":"not (hasKey or foundKey)","values":{"foundKey":true}}},{"comment":">>Run response handler"},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 02:38:08',
                'updated_at' => '2025-04-24 02:49:17',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 1,
                'number' => 9,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Move Anywhere","ru":"Case - Move Anywhere"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"message_move_anywhere":"note.message(\'make-move-anywhere\', \'Make:\')"}},{"action.case":{"name":">>move-anywhere","do":">>move","then":[{"set":{"pipe":true}},{"merge":{"messages":["message_move_anywhere"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 04:29:23',
                'updated_at' => '2025-04-24 03:01:18',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 2,
                'number' => 4,
                'scenario_id' => NULL,
                'name' => '{"en":"Response"}',
                'description' => '{"en":null}',
            'before' => '[{"chat.completion":{"async":true,"messages":"messages","content":[{"memory.create":{"author_id":"author","content":"content","meta":"meta"}},{"screen.state":{"values":{"step":"screen.nextState(\'step\')","isDone":"screen.state(\'step\') == screen.state(\'steps\')"}}},{"chat.refresh":null}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-17 17:55:51',
                'updated_at' => '2025-04-24 04:22:26',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 1,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Inspect Place","ru":"Case - Inspect Place"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"message_inspect_place":"note.message(\'make-inspect-place\', \'Make:\')"}},{"action.case":{"name":">>inspect-place","do":">>look","what":[">>around",">>environment",">>surroundings"],"how":[">>intently",">>carefully",">>attentively",">>diligently"],"then":[{"merge":{"messages":["message_inspect_place"]}},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 00:33:01',
                'updated_at' => '2025-04-24 02:38:59',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 1,
                'number' => 11,
                'scenario_id' => NULL,
                'name' => '{"en":"Action","ru":"Action"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"comment":">>Classify character ask"},{"action":{"async":true,"pipeFlag":">>pipe","messages":"messages","allowed":[">>look",">>search",">>open",">>take",">>move"],"before":[{"merge":{"messages":["note.message(\'rules-narrator\', \'Rules:\')","note.message(\'rules-content\', \'Rules:\')"]}},{"memory.create":{"author_id":"character.id()","content":"ask","meta":{"weather":"chat.state(\'weather\')","time":"chat.state(\'time\')"}}},{"chat.refresh":null}],"always":[{"merge":{"messages":[{"role":">>user","content":"ask"}]}}],"default":[{"merge":{"messages":["note.message(\'make-fun\', \'Make:\')"]}},{"function.run":{"name":"generate_response"}}]}},{"screen.waiting":true}]',
                'after' => NULL,
                'created_at' => '2025-04-19 10:52:50',
                'updated_at' => '2025-04-24 04:53:19',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 2,
                'number' => 2,
                'scenario_id' => NULL,
                'name' => '{"en":"Audio Log - Apocalipsys","ru":"Audio Log - Doomsday"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"if":{"condition":"screen.state(\'step\') == 2","then":[{"set":{"meta.tags":[">>audio-log"],"author":"character.id()"}},{"merge":{"messages":["note.message(\'lore-virus\', \'Lore:\')","note.message(\'lore-fractions\', \'Lore:\')","memory.card(\'main\', \'quest\')","note.message(\'make-audio-log\', \'Make:\')"]}},{"memory.card":{"async":true,"type":">>place","layout":"note.content(\'layout-place\')","code":">>house","title":">>House","task":"note.content(\\"place-house\\")"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:24:01',
                'updated_at' => '2025-04-24 05:32:14',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 1,
                'number' => 7,
                'scenario_id' => NULL,
                'name' => '{"en":"Case - Door Key","ru":"Case - Door Key"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"message_opened_door":"note.message(\'make-opened-door\', \'Make:\')","message_unlock_door":"note.message(\'make-unlock-door\', \'Make:\')","message_floor_key":"note.message(\'make-floor-key\', \'Make:\')","message_no_keys":"note.message(\'make-no-keys\', \'Make:\')"}},{"action.case":{"name":">>door-key","do":">>open","what":[">>door",">>portal",">>entrance"],"using":[">>key",">>keys"],"then":[{"comment":">>Prepare response instruction"},{"merge.if":{"condition":"hasKey and opened","values":{"messages":["message_opened_door"]}}},{"merge.if":{"condition":"hasKey and not opened","values":{"messages":["message_unlock_door"]}}},{"merge.if":{"condition":"not hasKey and foundKey","values":{"messages":["message_floor_key"]}}},{"merge.if":{"condition":"not (hasKey or foundKey)","values":{"messages":["message_no_keys"]}}},{"comment":">>Update opened state"},{"screen.state":{"condition":"hasKey and not opened","values":{"opened":true}}},{"comment":">>Run response handler"},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-21 06:13:44',
                'updated_at' => '2025-04-24 02:54:28',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 1,
                'number' => 10,
                'scenario_id' => NULL,
                'name' => '{"ru":"Case - Take Key","en":"Case - Take Key"}',
                'description' => '{"ru":null,"en":null}',
            'before' => '[{"set":{"message_has_key":"note.message(\'make-has-key\', \'Make:\')","message_take_key":"note.message(\'make-take-key\', \'Make:\')","message_unknown_key":"note.message(\'make-unknown-key\', \'Make:\')"}},{"action.case":{"name":">>take-key","do":">>take","what":[">>key"],"then":[{"comment":">>Prepare response instruction"},{"merge.if":{"condition":"hasKey","values":{"messages":["message_has_key"]}}},{"merge.if":{"condition":"not hasKey and foundKey","values":{"messages":["message_take_key"]}}},{"merge.if":{"condition":"not (hasKey or foundKey)","values":{"messages":["message_unknown_key"]}}},{"comment":">>Update hasKey state"},{"screen.state":{"condition":"not hasKey and foundKey","values":{"hasKey":true}}},{"comment":">>Run response handler"},{"function.run":{"name":"generate_response"}}]}}]',
                'after' => NULL,
                'created_at' => '2025-04-22 06:21:20',
                'updated_at' => '2025-04-24 03:02:55',
            ),
        ));
        
        
    }
}