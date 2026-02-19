<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Admin',
                'password' => Hash::make('password123'),
                'role' => 'guru',
            ]
        );
    }
}
