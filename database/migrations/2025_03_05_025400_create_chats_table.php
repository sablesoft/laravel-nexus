<?php

use App\Models\Enums\ChatStatus;
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
        Schema::create('app.chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->json('title')->nullable(false);
            $table->unsignedSmallInteger('seats')->nullable(false)->default(1);
            $table->enum('status', ChatStatus::values())->index()
                ->nullable(false)->default(ChatStatus::Created->value);

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_chats_states_index', 'gin');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.chats');
    }
};
