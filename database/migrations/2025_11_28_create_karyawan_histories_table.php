<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('set null');
            $table->string('karyawan_nama');
            $table->enum('action', ['create', 'update', 'delete']);
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan_histories');
    }
};
