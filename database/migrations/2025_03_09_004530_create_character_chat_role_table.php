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
        Schema::create('app.character_chat_role', function (Blueprint $table) {
            $table->foreignId('character_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('chat_role_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.character_chat_role');
    }
};
