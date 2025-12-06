<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, // Seeder admin
        ]);

        // Kalau nanti mau generate dummy user:
        // \App\Models\User::factory(10)->create();
    }
}
