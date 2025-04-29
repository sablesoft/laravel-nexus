<?php

use App\Models\Enums\NoteType;
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
        Schema::create('app.notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();

            $table->json('title')->nullable(false);
            $table->json('content')->nullable(false);
            $table->enum('type', NoteType::values())->nullable(false)
                ->default(NoteType::getDefault()->value)->index();
            $table->jsonb('meta')->nullable();

            $table->index('meta', 'app_notes_meta_index', 'gin');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.notes');
    }
};
