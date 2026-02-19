<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Guru
        User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Guru Satu',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ]
        );

        // Siswa (pakai NIS)
        User::updateOrCreate(
            ['nis' => '123456'],
            [
                'name' => 'Siswa Uji Coba',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );
    }
}
