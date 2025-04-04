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
            $table->foreignId('parent_id')->nullable(false)->index()
                ->constrained('app.scenarios')->cascadeOnDelete();
            $table->unsignedSmallInteger('number')->nullable(false)->index();
            $table->foreignId('scenario_id')->nullable()->index()
                ->constrained('app.scenarios')->cascadeOnDelete();
            $table->string('description')->nullable();

            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->unique(['parent_id', 'number']);

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
