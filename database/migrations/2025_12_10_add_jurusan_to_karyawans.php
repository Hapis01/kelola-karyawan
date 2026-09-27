<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            // Tambah field untuk jurusan/major pendidikan setelah field pendidikan
            if (!Schema::hasColumn('karyawans', 'jurusan')) {
                $table->string('jurusan')->nullable()->after('pendidikan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'jurusan')) {
                $table->dropColumn('jurusan');
            }
        });
    }
};
