<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class UserKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            // Generate email dari nama karyawan
            $email = strtolower(str_replace(' ', '.', $karyawan->nama)) . '@pasentra.com';
            
            User::create([
                'karyawan_id' => $karyawan->id,
                'name' => $karyawan->nama,
                'email' => $email,
                'password' => Hash::make('password123'), // Password default
            ]);
        }
    }
}
