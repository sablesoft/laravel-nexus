<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected array $schemas = ['app'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->schemas as $schema) {
            DB::statement("CREATE SCHEMA IF NOT EXISTS $schema");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->schemas as $schema) {
            DB::statement("DROP SCHEMA IF EXISTS $schema CASCADE");
        }
    }
};
