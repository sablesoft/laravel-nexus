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
        Schema::create('app.chat_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chat_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('character_id')->nullable()->constrained()->nullOnDelete();

            $table->string('effect_key'); // examples: "set", "comment", "memory.create"
            $table->enum('level', ['info', 'error'])->index()->default('info');
            $table->text('message');      // log message

            $table->jsonb('context')->nullable();

            $table->index(['chat_id', 'created_at']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.chat_logs');
    }
};
