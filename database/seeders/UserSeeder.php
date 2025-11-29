<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Use firstOrCreate to avoid truncate issues with foreign keys
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin PT PASIFIK ENERGI TRANS',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}