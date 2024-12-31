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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thread_id'); // Reference to the thread
            $table->unsignedBigInteger('user_id'); // Reference to the user replying
            $table->text('reply_content'); // Reply content
            $table->timestamps();

            // Foreign keys
            $table->foreign('thread_id')->references('id')->on('thread')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
