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
        Schema::create('app.masks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()
                ->constrained('app.images')->nullOnDelete();
            $table->foreignId('portrait_id')->nullable()
                ->constrained('app.images')->nullOnDelete();
            $table->string('name')->nullable(false)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_public')->nullable(false)->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.masks');
    }
};
