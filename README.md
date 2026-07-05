# CitrusCore - Enterprise Supply Chain Management (SCM) Jeruk

CitrusCore adalah aplikasi web berbasis **Laravel 11** untuk simulasi dan demo manajemen rantai pasok jeruk dari hulu ke hilir.  
Sistem ini dirancang untuk menampilkan alur operasional yang realistis untuk aktor:

- **Petani**
- **Pedagang Pengumpul**
- **Admin / Manajer SCM**

Aplikasi berfokus pada transparansi harga, pengelolaan kontrak, logistik, serta komunikasi terpusat.

---

## 1) Tujuan Aplikasi

CitrusCore dibangun untuk:

- Memonitor produksi lahan dan kualitas komoditas jeruk.
- Menghubungkan petani dan pedagang melalui transaksi serta kontrak digital.
- Menyediakan dashboard operasional untuk admin, pedagang, dan logistik.
- Menunjukkan data pasar, margin harga, serta status distribusi/logistik secara jelas.
- Menjadi prototype/demo enterprise yang langsung berjalan dengan data dummy realistis.

---

## 2) Teknologi yang Digunakan

### Backend
- **PHP 8.3**
- **Laravel 11**
- **Eloquent ORM** (relasi model dan query data)
- **Laravel Validation** (validasi input form)
- **Laravel Migrations & Seeders** (struktur DB dan data awal)
- **Route Web Laravel** (server-rendered form flow)

### Frontend
- **Blade Template Engine**
- **CSS kustom + utilitas layout komponen**
- **Vite** untuk build asset frontend
- **JavaScript ringan** (format input Rupiah di form tertentu)

### Database
- **MySQL** (target utama sesuai rancangan)
- Kompatibel pengembangan lokal tertentu dengan **SQLite** (beberapa query sudah dibuat portable).

---

## 3) Arsitektur Singkat

Struktur utama:

- `app/Http/Controllers/DashboardController.php`  
  Mengelola dashboard utama (admin, pedagang, logistik), export CSV, publish harga, status kontrak, dsb.

- `app/Http/Controllers/ScmModuleController.php`  
  Mengelola modul enterprise SCM:
  - Demand & Market Intelligence
  - Agro-Sensing
  - Marketplace
  - Komunikasi
  - Kontrak

- `app/Models/*`  
  Mendefinisikan entitas bisnis dan relasi database.

- `resources/views/*`  
  Halaman UI Blade bahasa Indonesia.

- `routes/web.php`  
  Semua endpoint web berbasis form/action.

---

## 4) Alur Utama Aplikasi

## 4.1 Alur Data Inti SCM
1. **Petani** mengisi data produksi lahan.
2. Produksi diklasifikasi dalam **grading komoditas**.
3. **Pedagang** melakukan publikasi harga/transaksi.
4. Sistem menghitung nilai transaksi (termasuk total bayar dan margin).
5. **Kontrak kemitraan** mengikat relasi petani-pedagang.
6. Status logistik dipantau sampai pengiriman selesai.
7. **Admin** melihat ringkasan KPI, filter transaksi, dan ekspor data.
8. Informasi kebijakan disebar melalui **pengumuman terpusat**.

## 4.2 Alur Dashboard
- **Dashboard Admin**  
  KPI SCM, tabel transaksi, filter + sorting, export CSV, ringkasan status.
- **Dashboard Pedagang**  
  Kuota, tren demand, publikasi harga beli, monitoring kontrak.
- **Dashboard Logistik**  
  Status logistik transaksi, kerusakan, alert operasional.

---

## 5) Desain Database (Ringkasan Entitas)

Tabel utama:

1. `users`
   - Menyimpan user lintas role (`petani`, `pedagang`, `admin`).
2. `produksi_lahan`
   - Data lahan, estimasi panen, realisasi panen.
3. `komoditas_grading`
   - Kelas ukuran, kemanisan, warna, volume, status validasi.
4. `transaksi_pasar`
   - Transaksi petani-pedagang, harga beli, harga konsumen, status transaksi/logistik.
5. `kontrak_kemitraan`
   - Kuota, harga acuan, status kontrak, periode kontrak.
6. `preferensi_konsumen`
   - Data demand pasar hasil survei.
7. `jadwal_pemupukan`
   - Kegiatan agro (pemupukan/hama/lainnya).
8. `pengumuman`
   - Informasi resmi dan operasional ke role target.

### Relasi penting
- `users` (petani) -> banyak `produksi_lahan`
- `produksi_lahan` -> banyak `komoditas_grading`
- `users` (petani/pedagang) -> banyak `transaksi_pasar`
- `users` (petani/pedagang) -> banyak `kontrak_kemitraan`
- `users` (admin) -> banyak `preferensi_konsumen` dan `pengumuman`

---

## 6) Modul Enterprise SCM yang Diimplementasikan

1. **Demand & Market Intelligence**
   - Kelola preferensi konsumen dan estimasi permintaan.
2. **Farm & Agro-Sensing Management**
   - Jadwal kegiatan petani dan status pelaksanaan.
3. **B2B Marketplace & Financial Transparency**
   - Transaksi pasar, status transaksi, transparansi harga.
4. **Inventory & Logistics Tracking**
   - Monitoring status logistik dan kualitas pengiriman.
5. **Centralized Communication Hub**
   - Pengumuman dan simulasi notifikasi WA (via log).
6. **Contract & Relationship Management**
   - Pembuatan dan pemantauan kontrak kemitraan.

---

## 7) Endpoint / API yang Ada

Aplikasi ini saat ini menggunakan **web routes** Laravel (server-rendered), bukan REST API terpisah.

Contoh endpoint penting:

- Dashboard:
  - `GET /dashboard/admin`
  - `GET /dashboard/admin/export`
  - `GET /dashboard/pedagang`
  - `POST /dashboard/pedagang/publish-harga`
  - `GET /dashboard/logistik`

- Modul:
  - `GET/POST /modul/demand`
  - `GET/POST /modul/agro`
  - `GET /modul/marketplace`
  - `GET/POST /modul/komunikasi`
  - `GET/POST /modul/kontrak`
  - plus route update/delete/status untuk CRUD lanjutan modul.

---

## 8) Fungsi Program Penting (Penjelasan)

## 8.1 DashboardController
- `admin()`  
  Mengambil data KPI admin + transaksi dengan filter/sort.
- `adminExport()`  
  Ekspor data transaksi ke CSV.
- `pedagang()`  
  Menyusun data kuota, harga, kontrak, tren demand.
- `publishHarga()`  
  Membuat transaksi baru dari input pedagang.
- `updateStatusKontrak()` / `renegosiasiKontrak()`  
  Update status dan nilai kontrak.
- `logistik()` / `updateLogistik()`  
  Monitoring dan update status logistik.
- `kontrakDetail()` / `kontrakUpdateStatus()`  
  Detail kontrak dan perubahan status dari halaman detail.

## 8.2 ScmModuleController
- `demandIndex()`, `demandStore()`  
  Kelola data preferensi konsumen.
- `agroIndex()`, `agroStore()`, `agroUpdateStatus()`  
  Kelola jadwal kegiatan agro petani.
- `marketplaceIndex()`, `marketplaceUpdateStatus()`  
  Kelola status transaksi marketplace.
- `komunikasiIndex()`, `komunikasiStore()`  
  Kelola pengumuman + simulasi WA log.
- `kontrakIndex()`, `kontrakStore()`  
  Kelola kontrak kemitraan pada modul kontrak.

---

## 9) Cara Menjalankan Proyek

1. Install dependency:
```bash
composer install
npm install
```

2. Copy env dan generate key:
```bash
cp .env.example .env
php artisan key:generate
```

3. Atur koneksi database di `.env` (disarankan MySQL).

4. Migrasi + seeder:
```bash
php artisan migrate:fresh --seed
```

5. Build asset:
```bash
npm run build
```

6. Jalankan server:
```bash
php artisan serve
```

Buka:
- `http://127.0.0.1:8000/dashboard/admin`

---

## 10) Catatan Pengembangan Lanjutan

- Beberapa route CRUD lanjutan modul sudah disiapkan dan perlu dipastikan seluruh method controller + tombol aksi UI terhubung penuh end-to-end.
- Testing mendalam (thorough) disarankan untuk semua flow update/delete, validasi edge case, dan konsistensi format angka rupiah di seluruh form.
- Jika ingin API publik/terpisah, dapat ditambahkan `routes/api.php` + controller API resources.

---

## 11) Identitas UI & UX

- Nama aplikasi: **CitrusCore**
- Bahasa antarmuka: **Bahasa Indonesia**
- Fokus desain: **modern, profesional, responsive**
- Komponen utama: sidebar, topbar, kartu KPI, tabel operasional, badge status.
