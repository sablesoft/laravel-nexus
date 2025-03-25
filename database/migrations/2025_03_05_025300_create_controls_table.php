<?php

use App\Models\Enums\ControlType;
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
        Schema::create('app.controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->nullable(false)
                ->constrained('app.screens')->cascadeOnDelete();
            $table->foreignId('scenario_id')->nullable()
                ->constrained('app.scenarios')->cascadeOnDelete();
            $table->string('command')->nullable(); // todo enum - system commands
            $table->enum('type', ControlType::values())->nullable(false)
                ->default(ControlType::getDefault()->value)->index();
            $table->string('title')->nullable(false);
            $table->string('tooltip')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();

            $table->unique(['screen_id', 'scenario_id', 'command']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.controls');
    }
};
