<?php

use App\Models\Enums\ScenarioType;
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
            $table->foreignId('user_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->foreignId('screen_id')
                ->constrained()->cascadeOnDelete();
            $table->string('code')->nullable(false)->index();
            $table->enum('type', ScenarioType::values())->nullable(false)
                ->default(ScenarioType::getDefault()->value)->index();
            $table->string('title')->nullable(false);
            $table->string('tooltip')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_default')->nullable(false)
                ->default(false)->index();
            $table->json('constants')->nullable();
            $table->json('active')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['screen_id', 'code']);
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
