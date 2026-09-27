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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // User ID admin yang menerima notif
            $table->string('nik'); // Karyawan yang melakukan action
            $table->enum('type', ['leave_request', 'training_upload', 'profile_update', 'general']); // Tipe notifikasi
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Pesan notifikasi
            $table->string('related_model')->nullable(); // Model yang terkait (Training, Leave, dll)
            $table->unsignedBigInteger('related_id')->nullable(); // ID dari model terkait
            $table->boolean('is_read')->default(false); // Status baca
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('nik')
                ->references('nik')
                ->on('karyawans')
                ->onDelete('cascade');

            // Index
            $table->index('admin_id');
            $table->index('is_read');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
