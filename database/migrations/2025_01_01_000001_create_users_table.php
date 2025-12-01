<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Relasi ke theme
            $table->foreignId('theme_id')
                ->nullable()
                ->constrained('themes')
                ->nullOnDelete();

            // Data user
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();

            // Role (DEFAULT: user)
            $table->enum('role', ['admin', 'user', 'visitor'])->default('user');

            // Auth
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
