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
        Schema::create('jadwal_pemupukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->enum('jenis_kegiatan', ['Pemupukan', 'Pengendalian Hama', 'Lainnya']);
            $table->string('jenis_pupuk_obat')->nullable();
            $table->decimal('biaya_estimasi', 10, 2)->nullable();
            $table->string('rekomendasi_varietas')->nullable();
            $table->boolean('sudah_dilaksanakan')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemupukan');
    }
};
