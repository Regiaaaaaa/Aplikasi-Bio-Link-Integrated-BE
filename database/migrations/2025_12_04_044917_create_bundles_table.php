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
    Schema::create('bundles', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('user_id');
        $table->uuid('theme_id')->nullable(); // penting!

        $table->string('name');
        $table->string('slug')->unique();

        $table->text('description')->nullable();
        $table->string('profile_image')->nullable();

        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();

        $table->foreign('theme_id')
            ->references('id')
            ->on('themes')
            ->nullOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
