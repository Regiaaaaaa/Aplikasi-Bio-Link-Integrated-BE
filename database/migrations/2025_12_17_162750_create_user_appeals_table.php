<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_appeals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');

            // Default Messages 
            $table->text('message');

            // Admin Reply
            $table->text('admin_reply')->nullable();

            // Banding Status
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->timestamps();

            // Relation
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_appeals');
    }
};
