<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->string('instagram_url')->nullable()->after('slug');
            $table->string('github_url')->nullable()->after('instagram_url');
            $table->string('tiktok_url')->nullable()->after('github_url');
            $table->string('facebook_url')->nullable()->after('tiktok_url');
            $table->string('x_url')->nullable()->after('facebook_url');
        });
    }

    public function down(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn([
                'instagram_url',
                'github_url',
                'tiktok_url',
                'facebook_url',
                'x_url',
            ]);
        });
    }
};
