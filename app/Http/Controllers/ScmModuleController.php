<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemupukan;
use App\Models\KontrakKemitraan;
use App\Models\Pengumuman;
use App\Models\PreferensiKonsumen;
use App\Models\TransaksiPasar;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScmModuleController extends Controller
{
    public function demandIndex(): View
    {
        $preferensi = PreferensiKonsumen::with('pembuat')->latest('periode')->get();

        $forecast = [
            'total_permintaan_kg' => (float) PreferensiKonsumen::sum('estimasi_permintaan_kg'),
            'rata_permintaan_kg' => (float) PreferensiKonsumen::avg('estimasi_permintaan_kg'),
            'tren' => PreferensiKonsumen::orderBy('periode')->get(['periode', 'estimasi_permintaan_kg']),
        ];

        $adminList = User::where('role', 'admin')->orderBy('nama')->get(['id', 'nama']);

        return view('modules.demand.index', compact('preferensi', 'forecast', 'adminList'));
    }

    public function demandStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'dibuat_oleh' => ['required', 'exists:users,id'],
            'judul_survei' => ['required', 'string', 'max:255'],
            'warna_favorit' => ['nullable', 'in:Hijau,Oranye'],
            'ukuran_favorit' => ['nullable', 'in:Kecil,Sedang,Besar'],
            'estimasi_permintaan_kg' => ['nullable', 'numeric', 'min:0'],
            'periode' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
        ]);

        PreferensiKonsumen::create($data);

        return back()->with('success', 'Preferensi konsumen berhasil ditambahkan.');
    }

    public function agroIndex(): View
    {
        $jadwal = JadwalPemupukan::with('user')->orderBy('tanggal')->get();
        $petani = User::where('role', 'petani')->orderBy('nama')->get(['id', 'nama']);

        return view('modules.agro.index', compact('jadwal', 'petani'));
    }

    public function agroStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'tanggal' => ['required', 'date'],
            'jenis_kegiatan' => ['required', 'in:Pemupukan,Pengendalian Hama,Lainnya'],
            'jenis_pupuk_obat' => ['nullable', 'string', 'max:255'],
            'biaya_estimasi' => ['nullable', 'numeric', 'min:0'],
            'rekomendasi_varietas' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);

        $data['sudah_dilaksanakan'] = false;
        JadwalPemupukan::create($data);

        return back()->with('success', 'Jadwal kegiatan agro berhasil ditambahkan.');
    }

    public function agroUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'sudah_dilaksanakan' => ['required', 'in:0,1'],
        ]);

        $jadwal = JadwalPemupukan::findOrFail($id);
        $jadwal->update([
            'sudah_dilaksanakan' => $request->string('sudah_dilaksanakan')->toString() === '1',
        ]);

        return back()->with('success', 'Status jadwal agro berhasil diperbarui.');
    }

    public function marketplaceIndex(): View
    {
        $transaksi = TransaksiPasar::with(['petani', 'pedagang'])->latest('tanggal_transaksi')->get();

        return view('modules.marketplace.index', compact('transaksi'));
    }

    public function marketplaceUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status_transaksi' => ['required', 'in:Menunggu Validasi,Ditawar,Kontrak Terbit,Dikirim,Diterima,Dibayar'],
        ]);

        $transaksi = TransaksiPasar::findOrFail($id);
        $transaksi->update($data);

        return back()->with('success', 'Status transaksi marketplace berhasil diperbarui.');
    }

    public function komunikasiIndex(): View
    {
        $pengumuman = Pengumuman::with('pembuat')->latest('tanggal_terbit')->get();

        return view('modules.komunikasi.index', compact('pengumuman'));
    }

    public function komunikasiStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'dibuat_oleh' => ['required', 'exists:users,id'],
            'target_role' => ['required', 'in:semua,petani,pedagang'],
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tanggal_terbit' => ['required', 'date'],
        ]);

        Pengumuman::create($data);

        Log::info('Simulasi WA Gateway: Pengumuman baru diterbitkan', [
            'judul' => $data['judul'],
            'target_role' => $data['target_role'],
        ]);

        return back()->with('success', 'Pengumuman berhasil dibuat dan notifikasi WA simulasi tercatat di log.');
    }

    public function kontrakIndex(): View
    {
        $kontrak = KontrakKemitraan::with(['petani', 'pedagang'])->latest()->get();
        $petani = User::where('role', 'petani')->orderBy('nama')->get(['id', 'nama']);
        $pedagang = User::where('role', 'pedagang')->orderBy('nama')->get(['id', 'nama']);

        return view('modules.kontrak.index', compact('kontrak', 'petani', 'pedagang'));
    }

    public function kontrakStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'petani_id' => ['required', 'exists:users,id'],
            'pedagang_id' => ['required', 'exists:users,id'],
            'kuota_kg' => ['required', 'numeric', 'min:1'],
            'harga_acuan_per_kg' => ['required', 'numeric', 'min:1'],
            'status_kontrak' => ['required', 'in:Draft,Menunggu Persetujuan,Aktif,Selesai,Ditolak'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'mekanisme_sengketa' => ['nullable', 'string'],
        ]);

        KontrakKemitraan::create($data);

        return back()->with('success', 'Kontrak kemitraan berhasil dibuat.');
    }
}
