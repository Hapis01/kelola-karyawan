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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // FK to karyawans
            $table->enum('leave_type', ['annual', 'sick', 'personal', 'other']); // Tipe cuti
            $table->date('start_date'); // Tanggal mulai cuti
            $table->date('end_date'); // Tanggal berakhir cuti
            $table->integer('days_count'); // Jumlah hari cuti
            $table->text('reason'); // Alasan cuti
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
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

            // Index untuk performa query
            $table->index('nik');
            $table->index('status');
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
