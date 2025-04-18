<?php

use App\Models\Enums\Actor;
use App\Models\Enums\Gender;
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
        Schema::create('app.characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mask_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->nullable()->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('chat_id')->nullable()->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->index()
                ->constrained()->nullOnDelete();
            $table->foreignId('screen_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->enum('actor', Actor::values())->index()
                ->nullable(false)->default(Actor::getDefault()->value);

            $table->boolean('is_confirmed')->nullable(false)->default(false);

            $table->string('language', 2)->nullable(false)->default('en');
            $table->enum('gender', Gender::values())->nullable(false);

            $table->jsonb('states')->nullable();
            $table->index('states', 'app_characters_states_index', 'gin');

            $table->jsonb('behaviors')->nullable();
            $table->index('behaviors', 'app_characters_behaviors_index', 'gin');

            $table->unique(['application_id', 'chat_id', 'mask_id']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.characters');
    }
};
