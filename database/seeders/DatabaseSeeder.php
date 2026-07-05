<?php

namespace Database\Seeders;

use App\Models\JadwalPemupukan;
use App\Models\KomoditasGrading;
use App\Models\KontrakKemitraan;
use App\Models\Pengumuman;
use App\Models\PreferensiKonsumen;
use App\Models\ProduksiLahan;
use App\Models\TransaksiPasar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $passwordDemo = Hash::make('password123');

        // Admin
        $admin = User::create([
            'nama' => 'Rina Prasetyo',
            'email' => 'admin@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 38,
            'tingkat_pendidikan' => 's1',
            'role' => 'admin',
            'id_kelompok_tani' => null,
            'no_hp' => '081298001001',
        ]);

        // Petani
        $petani1 = User::create([
            'nama' => 'Sutrisno Hadi',
            'email' => 'petani1@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 47,
            'tingkat_pendidikan' => 'sd',
            'role' => 'petani',
            'id_kelompok_tani' => 'KT-BERKAH-01',
            'no_hp' => '081300001111',
        ]);

        $petani2 = User::create([
            'nama' => 'Jumilah Wati',
            'email' => 'petani2@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 41,
            'tingkat_pendidikan' => 'smp',
            'role' => 'petani',
            'id_kelompok_tani' => 'KT-MANDIRI-02',
            'no_hp' => '081300002222',
        ]);

        $petani3 = User::create([
            'nama' => 'Andi Saputra',
            'email' => 'petani3@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 33,
            'tingkat_pendidikan' => 'sma',
            'role' => 'petani',
            'id_kelompok_tani' => 'KT-MAJU-03',
            'no_hp' => '081300003333',
        ]);

        // Pedagang
        $pedagang1 = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'pedagang1@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 39,
            'tingkat_pendidikan' => 'diploma',
            'role' => 'pedagang',
            'id_kelompok_tani' => null,
            'no_hp' => '081311110001',
        ]);

        $pedagang2 = User::create([
            'nama' => 'Dewi Kurnia',
            'email' => 'pedagang2@scmjeruk.test',
            'password' => $passwordDemo,
            'umur' => 35,
            'tingkat_pendidikan' => 's1',
            'role' => 'pedagang',
            'id_kelompok_tani' => null,
            'no_hp' => '081311110002',
        ]);

        // Produksi Lahan + Komoditas Grading
        $produksiP1A = ProduksiLahan::create([
            'user_id' => $petani1->id,
            'luas_lahan' => 1.80,
            'jumlah_pohon' => 320,
            'estimasi_panen' => 4200.00,
            'realisasi_panen' => 3950.00,
            'tanggal_estimasi_panen' => Carbon::now()->subDays(15)->toDateString(),
        ]);

        $produksiP1B = ProduksiLahan::create([
            'user_id' => $petani1->id,
            'luas_lahan' => 1.10,
            'jumlah_pohon' => 190,
            'estimasi_panen' => 2350.00,
            'realisasi_panen' => 2200.00,
            'tanggal_estimasi_panen' => Carbon::now()->subDays(8)->toDateString(),
        ]);

        $produksiP2A = ProduksiLahan::create([
            'user_id' => $petani2->id,
            'luas_lahan' => 2.40,
            'jumlah_pohon' => 410,
            'estimasi_panen' => 5100.00,
            'realisasi_panen' => 4800.00,
            'tanggal_estimasi_panen' => Carbon::now()->subDays(12)->toDateString(),
        ]);

        $produksiP3A = ProduksiLahan::create([
            'user_id' => $petani3->id,
            'luas_lahan' => 1.50,
            'jumlah_pohon' => 275,
            'estimasi_panen' => 3100.00,
            'realisasi_panen' => 2950.00,
            'tanggal_estimasi_panen' => Carbon::now()->subDays(10)->toDateString(),
        ]);

        $produksiP3B = ProduksiLahan::create([
            'user_id' => $petani3->id,
            'luas_lahan' => 0.95,
            'jumlah_pohon' => 160,
            'estimasi_panen' => 1650.00,
            'realisasi_panen' => 1500.00,
            'tanggal_estimasi_panen' => Carbon::now()->addDays(7)->toDateString(),
        ]);

        $gradingP1A = KomoditasGrading::create([
            'produksi_lahan_id' => $produksiP1A->id,
            'kelas_ukuran' => 'Besar',
            'tingkat_kemanisan' => 13,
            'warna' => 'Oranye',
            'volume_kg' => 1800.00,
            'status_validasi' => 'Divalidasi Pedagang',
        ]);

        $gradingP1B = KomoditasGrading::create([
            'produksi_lahan_id' => $produksiP1B->id,
            'kelas_ukuran' => 'Sedang',
            'tingkat_kemanisan' => 11,
            'warna' => 'Hijau',
            'volume_kg' => 1200.00,
            'status_validasi' => 'Draft',
        ]);

        $gradingP2A = KomoditasGrading::create([
            'produksi_lahan_id' => $produksiP2A->id,
            'kelas_ukuran' => 'Sedang',
            'tingkat_kemanisan' => 12,
            'warna' => 'Oranye',
            'volume_kg' => 2300.00,
            'status_validasi' => 'Divalidasi Pedagang',
        ]);

        $gradingP3A = KomoditasGrading::create([
            'produksi_lahan_id' => $produksiP3A->id,
            'kelas_ukuran' => 'Kecil',
            'tingkat_kemanisan' => 10,
            'warna' => 'Hijau',
            'volume_kg' => 900.00,
            'status_validasi' => 'Perlu Revisi',
        ]);

        $gradingP3B = KomoditasGrading::create([
            'produksi_lahan_id' => $produksiP3B->id,
            'kelas_ukuran' => 'Besar',
            'tingkat_kemanisan' => 14,
            'warna' => 'Oranye',
            'volume_kg' => 700.00,
            'status_validasi' => 'Draft',
        ]);

        // Transaksi Pasar (minimal 4, status bervariasi)
        TransaksiPasar::create([
            'petani_id' => $petani1->id,
            'pedagang_id' => $pedagang1->id,
            'komoditas_grading_id' => $gradingP1A->id,
            'volume_kg' => 1200.00,
            'harga_per_kg' => 3300.00,
            'harga_konsumen_per_kg' => 6100.00,
            'status_logistik' => 'Belum Diproses',
            'tingkat_kerusakan_persen' => 0.00,
            'status_transaksi' => 'Menunggu Validasi',
            'tanggal_transaksi' => Carbon::now()->subDays(4)->toDateString(),
        ]);

        TransaksiPasar::create([
            'petani_id' => $petani2->id,
            'pedagang_id' => $pedagang2->id,
            'komoditas_grading_id' => $gradingP2A->id,
            'volume_kg' => 1500.00,
            'harga_per_kg' => 3350.00,
            'harga_konsumen_per_kg' => 6150.00,
            'status_logistik' => 'Dalam Pengiriman',
            'tingkat_kerusakan_persen' => 1.20,
            'status_transaksi' => 'Dikirim',
            'tanggal_transaksi' => Carbon::now()->subDays(3)->toDateString(),
        ]);

        TransaksiPasar::create([
            'petani_id' => $petani3->id,
            'pedagang_id' => $pedagang1->id,
            'komoditas_grading_id' => $gradingP3A->id,
            'volume_kg' => 800.00,
            'harga_per_kg' => 3250.00,
            'harga_konsumen_per_kg' => 6000.00,
            'status_logistik' => 'Terkirim',
            'tingkat_kerusakan_persen' => 2.50,
            'status_transaksi' => 'Diterima',
            'tanggal_transaksi' => Carbon::now()->subDays(2)->toDateString(),
        ]);

        TransaksiPasar::create([
            'petani_id' => $petani1->id,
            'pedagang_id' => $pedagang2->id,
            'komoditas_grading_id' => $gradingP1B->id,
            'volume_kg' => 950.00,
            'harga_per_kg' => 3300.00,
            'harga_konsumen_per_kg' => 6100.00,
            'status_logistik' => 'Terkirim',
            'tingkat_kerusakan_persen' => 0.80,
            'status_transaksi' => 'Dibayar',
            'tanggal_transaksi' => Carbon::now()->subDay()->toDateString(),
        ]);

        // Kontrak Kemitraan (minimal 3, status bervariasi)
        KontrakKemitraan::create([
            'petani_id' => $petani1->id,
            'pedagang_id' => $pedagang1->id,
            'kuota_kg' => 5000.00,
            'harga_acuan_per_kg' => 3300.00,
            'status_kontrak' => 'Aktif',
            'tanggal_mulai' => Carbon::now()->subMonth()->toDateString(),
            'tanggal_selesai' => Carbon::now()->addMonths(5)->toDateString(),
            'mekanisme_sengketa' => 'Musyawarah kelompok tani, mediasi dinas pertanian, kemudian arbitrase lokal.',
        ]);

        KontrakKemitraan::create([
            'petani_id' => $petani2->id,
            'pedagang_id' => $pedagang2->id,
            'kuota_kg' => 4200.00,
            'harga_acuan_per_kg' => 3350.00,
            'status_kontrak' => 'Menunggu Persetujuan',
            'tanggal_mulai' => Carbon::now()->addDays(5)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addMonths(4)->toDateString(),
            'mekanisme_sengketa' => 'Penyelesaian internal koperasi lalu fasilitasi kecamatan.',
        ]);

        KontrakKemitraan::create([
            'petani_id' => $petani3->id,
            'pedagang_id' => $pedagang1->id,
            'kuota_kg' => 3000.00,
            'harga_acuan_per_kg' => 3280.00,
            'status_kontrak' => 'Draft',
            'tanggal_mulai' => null,
            'tanggal_selesai' => null,
            'mekanisme_sengketa' => 'Draf menunggu finalisasi klausul kualitas dan jadwal pengiriman.',
        ]);

        // Preferensi Konsumen (minimal 2)
        PreferensiKonsumen::create([
            'dibuat_oleh' => $admin->id,
            'judul_survei' => 'Survei Pasar Kota Bandung Q1',
            'warna_favorit' => 'Oranye',
            'ukuran_favorit' => 'Sedang',
            'estimasi_permintaan_kg' => 12500.00,
            'periode' => Carbon::now()->startOfMonth()->toDateString(),
            'catatan' => 'Permintaan meningkat menjelang Ramadan untuk jeruk ukuran sedang.',
        ]);

        PreferensiKonsumen::create([
            'dibuat_oleh' => $admin->id,
            'judul_survei' => 'Survei Retail Modern Jabodetabek',
            'warna_favorit' => 'Hijau',
            'ukuran_favorit' => 'Besar',
            'estimasi_permintaan_kg' => 9800.00,
            'periode' => Carbon::now()->subMonth()->startOfMonth()->toDateString(),
            'catatan' => 'Segmen premium cenderung pilih ukuran besar untuk hampers.',
        ]);

        // Jadwal Pemupukan (minimal 3)
        JadwalPemupukan::create([
            'user_id' => $petani1->id,
            'tanggal' => Carbon::now()->addDays(2)->toDateString(),
            'jenis_kegiatan' => 'Pemupukan',
            'jenis_pupuk_obat' => 'NPK 16-16-16',
            'biaya_estimasi' => 750000.00,
            'rekomendasi_varietas' => 'Jeruk Keprok Batu 55',
            'sudah_dilaksanakan' => false,
            'catatan' => 'Fokus blok lahan utara, target peningkatan brix.',
        ]);

        JadwalPemupukan::create([
            'user_id' => $petani2->id,
            'tanggal' => Carbon::now()->subDays(3)->toDateString(),
            'jenis_kegiatan' => 'Pengendalian Hama',
            'jenis_pupuk_obat' => 'Insektisida berbahan abamectin',
            'biaya_estimasi' => 540000.00,
            'rekomendasi_varietas' => 'Jeruk Siam Pontianak',
            'sudah_dilaksanakan' => true,
            'catatan' => 'Aplikasi dilakukan pagi hari untuk mengurangi evaporasi.',
        ]);

        JadwalPemupukan::create([
            'user_id' => $petani3->id,
            'tanggal' => Carbon::now()->addDays(5)->toDateString(),
            'jenis_kegiatan' => 'Lainnya',
            'jenis_pupuk_obat' => 'Pupuk organik cair',
            'biaya_estimasi' => 420000.00,
            'rekomendasi_varietas' => 'Jeruk Valencia',
            'sudah_dilaksanakan' => false,
            'catatan' => 'Uji coba peremajaan pada 40 pohon.',
        ]);

        // Pengumuman (minimal 2)
        Pengumuman::create([
            'dibuat_oleh' => $admin->id,
            'target_role' => 'semua',
            'judul' => 'Subsidi Logistik Musim Panen Triwulan Ini',
            'isi' => 'Dinas pertanian membuka subsidi biaya angkut hingga 15% untuk pengiriman antarkota.',
            'tanggal_terbit' => Carbon::now()->subDays(5)->toDateString(),
        ]);

        Pengumuman::create([
            'dibuat_oleh' => $admin->id,
            'target_role' => 'pedagang',
            'judul' => 'Standar Kemasan Baru untuk Mitra Pedagang',
            'isi' => 'Mulai bulan depan, seluruh pengiriman wajib menggunakan label batch dan kode asal kebun.',
            'tanggal_terbit' => Carbon::now()->toDateString(),
        ]);
    }
}
