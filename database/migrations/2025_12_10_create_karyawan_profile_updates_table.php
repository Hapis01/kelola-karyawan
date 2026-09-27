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
        Schema::create('karyawan_profile_updates', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // FK to karyawans
            $table->string('field_name'); // Nama field yang diupdate (nama, alamat, no_telepon, dll)
            $table->text('old_value')->nullable(); // Nilai lama
            $table->text('new_value'); // Nilai baru
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->unsignedBigInteger('approved_by')->nullable(); // User ID yang approve
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('nik')
                ->references('nik')
                ->on('karyawans')
                ->onDelete('cascade');

            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->index('nik');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan_profile_updates');
    }
};
