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
                'id' => 13,
                'user_id' => 1,
                'title' => '{"en":"Porch - Act","ru":"Porch - Act"}',
                'description' => '{"en":"Free action handler","ru":"Free action handler"}',
                'before' => NULL,
                'after' => NULL,
                'created_at' => '2025-04-17 05:39:11',
                'updated_at' => '2025-04-19 11:07:45',
            ),
            1 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'title' => '{"en":"Prologue - Continue","ru":"Prologue - Continue"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"set":{"meta":{"weather":"chat.state(\'weather\')","time":"chat.state(\'time\')"},"author":null,"messages":["note.message(\'rules-game\', \'Rules:\')","note.message(\'rules-narrator\', \'Rules:\')","note.message(\'rules-content\', \'Rules:\')"]}},{"merge":{"messages":"memory.messages(\'\\":type\\" == screen.code\')"}},{"screen.waiting":true}]',
                'after' => NULL,
                'created_at' => '2025-04-14 03:12:20',
                'updated_at' => '2025-04-24 05:16:08',
            ),
        ));
        
        
    }
}