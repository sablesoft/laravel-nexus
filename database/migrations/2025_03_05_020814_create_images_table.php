<?php

use App\Services\OpenAI\Enums\ImageAspect;
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
        Schema::create('app.images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable(false)
                ->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(false);
            $table->text('prompt')->nullable();
            $table->boolean('has_glitches')->nullable(false)
                ->default(false)->index();
            $table->unsignedSmallInteger('attempts')->nullable(false)->default(1);
            $table->enum('aspect', ImageAspect::values())->nullable(false)
                ->default(ImageAspect::getDefault()->value)->index();
            $table->string('path')->nullable(false)->unique();
            $table->string('path_thumbnail')->nullable()->unique();
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
        Schema::dropIfExists('app.images');
    }
};
