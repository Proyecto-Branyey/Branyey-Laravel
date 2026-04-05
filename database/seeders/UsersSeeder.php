<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 👇 Usuario administrador
        User::create([
            'name' => 'Admin',
            'username' => 'admin', // 👈 obligatorio
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'rol_id' => 1,
        ]);
        }
    }