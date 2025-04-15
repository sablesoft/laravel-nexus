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
            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()->index()
                ->constrained()->nullOnDelete();
            $table->json('title')->nullable(false);
            $table->string('code')->nullable(false)->index();
            $table->json('description')->nullable();
            $table->boolean('is_start')->nullable(false)
                ->default(false)->index();

            $table->string('query')->nullable();
            $table->text('template')->nullable();

            $table->text('visible_condition')->nullable();
            $table->text('enabled_condition')->nullable();

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_screens_states_index', 'gin');

            $table->json('init')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['application_id', 'code']);
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
