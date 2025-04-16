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
                'before' => '[{"screen.state":{"values":{"waiting":true}}},{"screen.writing":true}]',
                'after' => NULL,
            'visible_condition' => 'not screen.state(\'isDone\')',
            'enabled_condition' => 'not screen.state(\'waiting\')',
                'created_at' => '2025-04-08 20:05:14',
                'updated_at' => '2025-04-15 01:11:32',
            ),
            1 =>
            array (
                'id' => 5,
                'screen_id' => 9,
                'scenario_id' => NULL,
                'type' => 'action',
                'title' => '{"en":"Back","ru":"Назад"}',
                'tooltip' => '{"en":"Return to previous screen","ru":"Вернуться на предыдущий экран"}',
                'description' => '{"en":null,"ru":null}',
                'before' => '[{"screen.back":true}]',
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-14 21:54:16',
                'updated_at' => '2025-04-15 01:12:19',
            ),
            2 =>
            array (
                'id' => 6,
                'screen_id' => 2,
                'scenario_id' => NULL,
                'type' => 'input',
                'title' => '{"ru":"Действие","en":"Act"}',
                'tooltip' => '{"ru":"Что будешь делать?","en":"What you will do?"}',
                'description' => '{"ru":null,"en":null}',
                'before' => NULL,
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-15 00:12:39',
                'updated_at' => '2025-04-15 00:20:32',
            ),
            3 =>
            array (
                'id' => 7,
                'screen_id' => 9,
                'scenario_id' => NULL,
                'type' => 'input',
                'title' => '{"en":"Record","ru":"Записать"}',
                'tooltip' => '{"en":"Make a new audio record","ru":"Сделать новую запись"}',
                'description' => '{"en":null,"ru":null}',
            'before' => '[{"memory.create":{"author_id":"character.id()","content":"ask","meta":{"tags":[">>audio-log"]}}},{"chat.refresh":null}]',
                'after' => NULL,
                'visible_condition' => NULL,
                'enabled_condition' => NULL,
                'created_at' => '2025-04-15 00:36:12',
                'updated_at' => '2025-04-15 00:39:30',
            ),
        ));


    }
}
