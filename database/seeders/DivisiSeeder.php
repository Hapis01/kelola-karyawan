<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        Divisi::insert([
            ['nama' => 'IT / Information Technology'],  // ID 1
            ['nama' => 'HRD / Human Resources'],         // ID 2
            ['nama' => 'Keuangan / Finance'],            // ID 3
            ['nama' => 'Marketing / Brand Development'], // ID 4
            ['nama' => 'Sales / Business Development'],  // ID 5
            ['nama' => 'Operasional / Administration'],  // ID 6
            ['nama' => 'Produksi / Manufacturing'],      // ID 7
            ['nama' => 'Legal / Compliance'],            // ID 8
            ['nama' => 'Logistik / Warehouse'],          // ID 9
            ['nama' => 'Keamanan / Security'],           // ID 10
        ]);
    }
}
