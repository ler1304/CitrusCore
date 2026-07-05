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
        Schema::create('transaksi_pasar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('users');
            $table->foreignId('pedagang_id')->constrained('users');
            $table->foreignId('komoditas_grading_id')->nullable()->constrained('komoditas_grading');
            $table->decimal('volume_kg', 10, 2);
            $table->decimal('harga_per_kg', 10, 2);
            $table->decimal('harga_konsumen_per_kg', 10, 2)->nullable();
            $table->decimal('total_bayar', 12, 2);
            $table->enum('status_logistik', ['Belum Diproses', 'Di Gudang Sementara', 'Dalam Pengiriman', 'Terkirim'])->default('Belum Diproses');
            $table->decimal('tingkat_kerusakan_persen', 5, 2)->nullable()->default(0);
            $table->enum('status_transaksi', ['Menunggu Validasi', 'Ditawar', 'Kontrak Terbit', 'Dikirim', 'Diterima', 'Dibayar'])->default('Menunggu Validasi');
            $table->date('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pasar');
    }
};
