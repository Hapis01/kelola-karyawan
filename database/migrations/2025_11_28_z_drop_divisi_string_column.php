<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if divisi column exists before dropping
        if (Schema::hasColumn('karyawans', 'divisi')) {
            Schema::table('karyawans', function (Blueprint $table) {
                $table->dropColumn('divisi');
            });
        }
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('divisi')->nullable()->after('jenis_kelamin');
        });
    }
};
