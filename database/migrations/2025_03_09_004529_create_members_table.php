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
        Schema::create('app.members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('mask_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained()->nullOnDelete();
            $table->foreignId('screen_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->boolean('is_confirmed')->nullable(false)->default(false);

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_members_states_index', 'gin');

            $table->unique(['chat_id', 'mask_id']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.members');
    }
};
