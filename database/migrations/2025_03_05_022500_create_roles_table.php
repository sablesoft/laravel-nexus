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
        Schema::create('app.roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();

            $table->string('name')->nullable(false)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_public')->nullable(false)->default(false);

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_roles_states_index', 'gin');

            $table->jsonb('behaviors')->nullable();
            $table->index('behaviors', 'app_roles_behaviors_index', 'gin');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.roles');
    }
};
