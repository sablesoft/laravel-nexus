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
        Schema::create('app.scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable();

            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['user_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.scenarios');
    }
};
