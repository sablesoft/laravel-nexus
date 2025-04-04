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
        Schema::create('app.transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_from_id')->nullable(false)
                ->constrained('app.screens')->cascadeOnDelete();
            $table->foreignId('screen_to_id')->nullable(false)
                ->constrained('app.screens')->cascadeOnDelete();
            $table->string('title')->nullable(false);
            $table->string('tooltip')->nullable();
            $table->string('description')->nullable();

            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->text('visible')->nullable();
            $table->text('enabled')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.transfers');
    }
};
