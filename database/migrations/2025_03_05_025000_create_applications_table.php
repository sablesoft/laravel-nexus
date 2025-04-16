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
        Schema::create('app.applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()->index()
                ->constrained()->nullOnDelete();
            $table->json('title')->nullable(false);
            $table->json('description')->nullable();
            $table->boolean('is_public')->nullable(false)->default(false);
            $table->unsignedSmallInteger('seats')->nullable(false)->default(1);

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_applications_states_index', 'gin');

            $table->jsonb('character_states')->nullable();
            $table->index('character_states', 'app_applications_character_states_index', 'gin');

            $table->jsonb('behaviors')->nullable();
            $table->index('behaviors', 'app_applications_behaviors_index', 'gin');

            $table->json('init')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.applications');
    }
};
