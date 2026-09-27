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
        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings');
            $table->foreignId('user_id')->constrained('users');
            $table->string('nik', 20);
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate enrollments
            $table->unique(['training_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participants');
    }
};
