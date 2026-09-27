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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // FK to karyawans
            $table->string('training_name'); // Nama pelatihan
            $table->date('training_date'); // Tanggal pelatihan
            $table->string('training_provider'); // Penyelenggara pelatihan
            $table->string('certificate_file'); // Path ke file sertifikat (PDF/Image)
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status verifikasi admin
            $table->text('admin_notes')->nullable(); // Catatan admin
            $table->unsignedBigInteger('approved_by')->nullable(); // User ID yang approve
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('nik')
                ->references('nik')
                ->on('karyawans')
                ->onDelete('cascade');

            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
