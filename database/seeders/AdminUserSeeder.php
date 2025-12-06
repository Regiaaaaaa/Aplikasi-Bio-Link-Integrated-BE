<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id'           => Str::uuid(),
            'name'         => 'Super Admin',
            'username'     => 'admin',
            'email'        => 'admin@example.com',
            'phone_number' => '08123456789',
            'password'     => Hash::make('adminaja'), 
            'role'         => 'admin',
            'is_active'    => true,
        ]);
    }
}
