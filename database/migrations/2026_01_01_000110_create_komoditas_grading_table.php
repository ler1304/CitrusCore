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
        Schema::create('komoditas_grading', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_lahan_id')->constrained('produksi_lahan')->cascadeOnDelete();
            $table->enum('kelas_ukuran', ['Kecil', 'Sedang', 'Besar']);
            $table->unsignedTinyInteger('tingkat_kemanisan');
            $table->enum('warna', ['Hijau', 'Oranye']);
            $table->decimal('volume_kg', 10, 2);
            $table->enum('status_validasi', ['Draft', 'Divalidasi Pedagang', 'Perlu Revisi'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditas_grading');
    }
};
