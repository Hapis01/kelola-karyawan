<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
        });

        Schema::table('karyawans', function (Blueprint $table) {
            $table->foreignId('divisi_id')->nullable()->after('jenis_kelamin')->constrained('divisis')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropForeign(['divisi_id']);
            $table->dropColumn('divisi_id');
        });

        Schema::dropIfExists('divisis');
    }
};
