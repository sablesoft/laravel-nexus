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
        Schema::create('app.memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->nullable()->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->nullable()->index()
                ->constrained('app.members')->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()->index()
                ->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('type', 20)->nullable(false)->index();
            $table->string('language', 2)->nullable(false)->default('en');
            $table->jsonb('meta')->nullable();

            $table->index('meta', 'app_memories_meta_index', 'gin');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.memories');
    }
};
