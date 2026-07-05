# TODO - Tahap 1 & Tahap 2 SCM Jeruk (Laravel 11)

## Tahap 1 (Backend Data Layer)

- [x] Update migration `users` sesuai skema final (nama, umur, tingkat_pendidikan, role, id_kelompok_tani, no_hp).
- [x] Tambah migration `produksi_lahan`.
- [x] Tambah migration `komoditas_grading`.
- [x] Tambah migration `transaksi_pasar`.
- [x] Tambah migration `kontrak_kemitraan`.
- [x] Tambah migration `preferensi_konsumen`.
- [x] Tambah migration `jadwal_pemupukan`.
- [x] Tambah migration `pengumuman`.
- [x] Update model `User`.
- [x] Buat model `ProduksiLahan`.
- [x] Buat model `KomoditasGrading`.
- [x] Buat model `TransaksiPasar`.
- [x] Buat model `KontrakKemitraan`.
- [x] Buat model `PreferensiKonsumen`.
- [x] Buat model `JadwalPemupukan`.
- [x] Buat model `Pengumuman`.
- [x] Rewrite `DatabaseSeeder` dengan data dummy realistis dan saling terhubung.
- [x] Jalankan validasi `migrate:fresh --seed`.
- [x] Final check konsistensi skema, relasi, enum, accessor, dan seeder.

## Tahap 2 (UI Blade - Bahasa Indonesia)

- [x] Buat controller dashboard untuk agregasi data admin/pedagang/logistik/kontrak.
- [x] Update route web untuk halaman dashboard & detail kontrak.
- [x] Buat layout Blade utama CitrusCore (sidebar + topbar responsif).
- [x] Buat komponen reusable (kartu KPI & badge status).
- [x] Buat halaman `dashboard/admin`.
- [x] Buat halaman `dashboard/pedagang`.
- [x] Buat halaman `dashboard/logistik`.
- [x] Buat halaman `kontrak/show`.
- [x] Update styling global (`resources/css/app.css`) sesuai palet CitrusCore.
- [x] Build frontend assets dan verifikasi tampilan halaman.

## Tahap 2 Lanjutan (Fitur Lengkap Sesuai UI)

- [x] Tambah filter tanggal/status + sorting + export CSV pada dashboard admin.
- [x] Tambah form publish harga pada portal pedagang.
- [x] Tambah aksi update status kontrak (Draft/Menunggu/Aktif/Selesai/Ditolak).
- [x] Tambah fitur renegosiasi kontrak (kuota/harga acuan/mekanisme sengketa).
- [x] Tambah update status logistik dan tingkat kerusakan transaksi.
- [x] Tambah timeline + aksi status pada detail kontrak.
- [ ] Tambah flash notification sukses/gagal di layout.
- [x] Lengkapi styling badge status untuk semua enum status.
- [ ] Uji endpoint GET/POST fitur baru dan verifikasi update data.

## Tahap 3 (Enterprise SCM Full Feature)

- [ ] Modul Demand & Market Intelligence: halaman analitik + CRUD preferensi + forecast.
- [ ] Modul Farm & Agro-Sensing Management: jadwal kegiatan, rekomendasi, status pelaksanaan.
- [ ] Modul B2B Marketplace & Financial Transparency: transaksi aktif, margin, aksi tawar/validasi/pembayaran.
- [ ] Modul Inventory & Logistics Tracking: kapasitas gudang, armada, SLA pengiriman, kerusakan.
- [ ] Modul Centralized Communication Hub: pengumuman terpusat + notifikasi operasional + simulasi WA gateway.
- [ ] Modul Contract & Relationship Management: pembuatan kontrak lengkap + jadwal distribusi + progres kuota.
- [ ] UI/UX final: semua tombol benar-benar fungsional, responsive, bahasa Indonesia, gaya CitrusCore modern.
- [ ] Validasi alur utama lintas modul (admin/pedagang/petani) tanpa bug.
