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
            // Tambah kolom yang belum ada
            if (!Schema::hasColumn('karyawans', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('karyawans', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('no_telepon');
            }
            if (!Schema::hasColumn('karyawans', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('karyawans', 'pendidikan')) {
                $table->string('pendidikan')->nullable()->after('tempat_lahir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
            if (Schema::hasColumn('karyawans', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }
            if (Schema::hasColumn('karyawans', 'tempat_lahir')) {
                $table->dropColumn('tempat_lahir');
            }
            if (Schema::hasColumn('karyawans', 'pendidikan')) {
                $table->dropColumn('pendidikan');
            }
        });
    }
};
