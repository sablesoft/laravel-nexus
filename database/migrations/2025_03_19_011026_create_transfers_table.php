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
            $table->foreignId('application_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('screen_from_id')->nullable(false)
                ->constrained('app.screens')->cascadeOnDelete();
            $table->foreignId('screen_to_id')->nullable(false)
                ->constrained('app.screens')->cascadeOnDelete();
            $table->string('code')->nullable(false);
            $table->string('title')->nullable();
            $table->string('tooltip')->nullable();
            $table->json('active')->nullable();

            $table->unique(['application_id', 'code']);

            $table->timestamps();
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
