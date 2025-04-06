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
        Schema::create('app.groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();

            $table->string('name')->nullable(false);
            $table->text('description')->nullable();

            $table->unsignedSmallInteger('number')->nullable(false);
            $table->unsignedSmallInteger('roles_per_member')->nullable(false)->default(1);
            $table->boolean('is_required')->nullable(false)->default(true);
            $table->string('allowed')->nullable();

            $table->unique(['application_id', 'name']);
            $table->unique(['application_id', 'number']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.groups');
    }
};
