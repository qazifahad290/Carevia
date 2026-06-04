<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('status', 20)->default('confirmed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id', 'date', 'time']);
            $table->index(['patient_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
