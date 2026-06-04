<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialty_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->unsignedInteger('price')->default(50);
            $table->unsignedInteger('years_experience')->default(1);
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
