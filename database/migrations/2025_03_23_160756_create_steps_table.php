<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app.steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scenario_id')->nullable(false)
                ->constrained('app.scenarios')->cascadeOnDelete();
            $table->foreignId('nested_id')->nullable()
                ->constrained('app.scenarios')->cascadeOnDelete();
            $table->string('command')->nullable(); // todo enum - system commands
            $table->unsignedSmallInteger('number')->nullable(false)->index();
            $table->json('active')->nullable();
            $table->json('constants')->nullable();

            $table->unique(['scenario_id', 'number']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.steps');
    }
};
