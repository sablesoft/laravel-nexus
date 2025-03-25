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
        Schema::create('app.screens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()
                ->constrained()->nullOnDelete();
            $table->string('code')->nullable(false)->index();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable();
            $table->boolean('is_default')->nullable(false)
                ->default(false)->index();
            $table->json('active')->nullable();
            $table->json('setup')->nullable();
            $table->text('template')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['application_id', 'code']);
            $table->unique(['application_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.screens');
    }
};
