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
        Schema::create('preferensi_konsumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->string('judul_survei');
            $table->enum('warna_favorit', ['Hijau', 'Oranye'])->nullable();
            $table->enum('ukuran_favorit', ['Kecil', 'Sedang', 'Besar'])->nullable();
            $table->decimal('estimasi_permintaan_kg', 10, 2)->nullable();
            $table->date('periode');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_konsumen');
    }
};
