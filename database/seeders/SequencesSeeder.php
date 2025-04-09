<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SequencesSeeder extends Seeder
{

    protected array $tables = [
        'users',
        'images',
        'roles',
        'masks',
        'applications',
        'chat_groups',
        'chat_roles',
        'screens',
        'transfers',
        'scenarios',
        'controls',
        'steps',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tables as $table) {
            DB::select("SELECT setval(pg_get_serial_sequence('$table', 'id'), coalesce(MAX(id), 1)) FROM $table");
        }
    }
}
