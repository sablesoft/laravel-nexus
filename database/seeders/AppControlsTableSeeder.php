<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppControlsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app.controls')->delete();
        
        \DB::table('app.controls')->insert(array (
            0 => 
            array (
                'id' => 1,
                'screen_id' => 1,
                'scenario_id' => 12,
                'type' => 'action',
                'title' => '{"en":"Continue","ru":"Далее"}',
                'tooltip' => '{"en":"Press to continue your story","ru":"Нажмите чтобы продолжить историю"}',
                'description' => '{"en":"Advances the prologue one step forward. Visible as long as the prologue is not yet finished. \\nEach press progresses the narrative. After the final part, the button disappears and marks the prologue as complete.","ru":"Продвигает пролог на один шаг вперёд. Видна до тех пор, пока пролог не завершён.\\nКаждое нажатие продвигает повествование. После последней части кнопка исчезает, а пролог считается завершённым."}',
                'before' => '[{"screen.state":{"values":{"waiting":true}}}]',
                'after' => NULL,
            'visible_condition' => 'not screen.state(\'isDone\')',
            'enabled_condition' => 'not screen.state(\'waiting\')',
                'created_at' => '2025-04-08 20:05:14',
                'updated_at' => '2025-04-14 04:50:15',
            ),
        ));
        
        
    }
}