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
        Schema::create('app.chat_role_member', function (Blueprint $table) {
            $table->foreignId('chat_role_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable(false)->index()
                ->constrained()->cascadeOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app.chat_role_member');
    }
};
