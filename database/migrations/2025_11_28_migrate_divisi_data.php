<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Divisi;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure divisi table has our 5 standard divisis
        // If divisis table already has data from seeder, skip

        // Get all karyawans and assign them to a divisi
        // Since we don't have old divisi data, assign all to first divisi
        $firstDivisiId = Divisi::orderBy('id')->first()?->id ?? 1;

        DB::table('karyawans')
            ->whereNull('divisi_id')
            ->update(['divisi_id' => $firstDivisiId]);
    }

    public function down(): void
    {
        // Reset divisi_id on rollback
        DB::table('karyawans')->update(['divisi_id' => null]);
    }
};
