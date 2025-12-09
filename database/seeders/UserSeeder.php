<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'id'           => Str::uuid(),
                'name'         => 'User ' . $i,
                'username'     => 'user' . $i,
                'email'        => 'user' . $i . '@example.com',
                'phone_number' => '08123' . rand(100000, 999999),
                'password'     => Hash::make('password123'),
                'role'         => 'user',
                'is_active'    => true,
            ]);
        }
    }
}
