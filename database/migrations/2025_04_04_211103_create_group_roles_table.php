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
        Schema::create('app.group_roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->nullable(false)
                ->constrained()->cascadeOnDelete();

            $table->string('name')->nullable(false);
            $table->text('description')->nullable();

            $table->unsignedSmallInteger('limit')->nullable();
            $table->foreignId('screen_id')->nullable()
                ->constrained()->nullOnDelete();

            $table->unique(['application_id', 'role_id']);

            $table->jsonb('behaviors')->nullable();
            $table->index('behaviors', 'app_group_roles_behaviors_index', 'gin');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.group_roles');
    }
};
