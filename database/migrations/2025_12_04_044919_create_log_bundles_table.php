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
    Schema::create('log_bundles', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->uuid('bundle_id');
        $table->string('ip_address', 45)->nullable();
        $table->string('user_agent')->nullable();

        $table->timestamps();

        $table->foreign('bundle_id')->references('id')->on('bundles')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_bundles');
    }
};
