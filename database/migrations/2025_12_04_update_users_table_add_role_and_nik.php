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
        Schema::table('users', function (Blueprint $table) {
            // Drop old foreign key and column
            if (Schema::hasColumn('users', 'karyawan_id')) {
                $table->dropForeign(['karyawan_id']);
                $table->dropColumn('karyawan_id');
            }

            // Add role column
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'karyawan'])->default('karyawan')->after('email');
            }

            // Add nik column for linking to karyawan
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->nullable()->unique()->after('role');
                $table->foreign('nik')
                    ->references('nik')
                    ->on('karyawans')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop new columns and restore old structure
            if (Schema::hasColumn('users', 'nik')) {
                $table->dropForeign(['nik']);
                $table->dropColumn('nik');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            // Restore old karyawan_id
            $table->unsignedBigInteger('karyawan_id')->nullable()->after('id');
            $table->foreign('karyawan_id')
                ->references('id')
                ->on('karyawans')
                ->onDelete('set null');
        });
    }
};
