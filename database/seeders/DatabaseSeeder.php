<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder dengan urutan yang benar
        // 1. Divisi harus dibuat terlebih dahulu
        // 2. Karyawan & Users akan dibuat bersamaan (relasi karyawan_id ke users)
        // 3. Admin user dibuat di akhir
        
        $this->call(DivisiSeeder::class);
        $this->call(KaryawanSeeder::class); // Seeder ini sudah termasuk pembuatan Users dan Admin
    }
}

