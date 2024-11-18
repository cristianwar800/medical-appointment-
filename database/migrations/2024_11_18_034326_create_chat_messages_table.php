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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->text('message');
            $table->string('type')->default('user'); // user/bot
            $table->string('user_type')->nullable(); // doctor/receptionist
            $table->string('intent')->nullable(); // tipo de consulta
            $table->json('context')->nullable(); // contexto de la conversación
            $table->boolean('resolved')->default(false);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
