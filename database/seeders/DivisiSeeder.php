<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        Divisi::insert([
            ['nama' => 'Keuangan'],
            ['nama' => 'HRD'],
            ['nama' => 'Produksi'],
            ['nama' => 'Logistik'],
            ['nama' => 'Maintenance'],
            ['nama' => 'IT Support'],
            ['nama' => 'Marketing'],
            ['nama' => 'Sales'],
            ['nama' => 'Customer Service'],
            ['nama' => 'Quality Control'],
        ]);
    }
}
