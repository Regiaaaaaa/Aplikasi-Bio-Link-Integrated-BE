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
    Schema::create('log_links', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('link_id');
        $table->string('ip_address', 45)->nullable();
        $table->string('user_agent')->nullable();

        $table->timestamps();

        $table->foreign('link_id')->references('id')->on('links')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_links');
    }
};
