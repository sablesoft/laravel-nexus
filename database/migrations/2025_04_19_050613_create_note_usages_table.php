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
        Schema::create('app.note_usages', function (Blueprint $table) {
            $table->foreignId('note_id')->index()
                ->constrained()->onDelete('cascade');
            $table->morphs('noteable');
            $table->string('code')->index()->nullable(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['note_id', 'noteable_type', 'noteable_id']);
            $table->unique(['code', 'noteable_type', 'noteable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.note_usages');
    }
};
