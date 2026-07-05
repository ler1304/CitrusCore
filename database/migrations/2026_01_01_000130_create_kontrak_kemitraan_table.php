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
        Schema::create('kontrak_kemitraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('users');
            $table->foreignId('pedagang_id')->constrained('users');
            $table->decimal('kuota_kg', 10, 2);
            $table->decimal('harga_acuan_per_kg', 10, 2);
            $table->enum('status_kontrak', ['Draft', 'Menunggu Persetujuan', 'Aktif', 'Selesai', 'Ditolak'])->default('Draft');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('mekanisme_sengketa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_kemitraan');
    }
};
