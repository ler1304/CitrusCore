<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemupukan;
use App\Models\KontrakKemitraan;
use App\Models\Pengumuman;
use App\Models\PreferensiKonsumen;
use App\Models\ProduksiLahan;
use App\Models\TransaksiPasar;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function admin(Request $request): View
    {
        $query = TransaksiPasar::with(['petani', 'pedagang']);

        if ($request->filled('status_transaksi')) {
            $query->where('status_transaksi', $request->string('status_transaksi'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->string('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->string('tanggal_sampai'));
        }

        $allowedSort = ['tanggal_transaksi', 'volume_kg', 'harga_per_kg', 'total_bayar'];
        $sortBy = in_array($request->string('sort_by')->toString(), $allowedSort, true)
            ? $request->string('sort_by')->toString()
            : 'tanggal_transaksi';

        $sortDir = $request->string('sort_dir')->toString() === 'asc' ? 'asc' : 'desc';

        $transaksiFiltered = (clone $query)
            ->orderBy($sortBy, $sortDir)
            ->limit(20)
            ->get();

        $totalPanenKg = (float) ProduksiLahan::sum('realisasi_panen');
        $kontrakAktif = KontrakKemitraan::where('status_kontrak', 'Aktif')->count();
        $rataKerusakan = (float) TransaksiPasar::whereNotNull('tingkat_kerusakan_persen')->avg('tingkat_kerusakan_persen');
        $rataHargaBeli = (float) TransaksiPasar::avg('harga_per_kg');
        $rataHargaKonsumen = (float) TransaksiPasar::whereNotNull('harga_konsumen_per_kg')->avg('harga_konsumen_per_kg');
        $totalPedagangAktif = TransaksiPasar::distinct('pedagang_id')->count('pedagang_id');

        $marginPersen = 0.0;
        if ($rataHargaKonsumen > 0) {
            $marginPersen = (($rataHargaKonsumen - $rataHargaBeli) / $rataHargaKonsumen) * 100;
        }

        $statusTransaksi = TransaksiPasar::select('status_transaksi', DB::raw('count(*) as total'))
            ->groupBy('status_transaksi')
            ->orderBy('total', 'desc')
            ->get();

        $pengumumanTerbaru = Pengumuman::with('pembuat')
            ->latest('tanggal_terbit')
            ->limit(3)
            ->get();

        return view('dashboard.admin', [
            'totalPanenKg' => $totalPanenKg,
            'kontrakAktif' => $kontrakAktif,
            'rataKerusakan' => $rataKerusakan,
            'rataHargaBeli' => $rataHargaBeli,
            'rataHargaKonsumen' => $rataHargaKonsumen,
            'marginPersen' => $marginPersen,
            'totalPedagangAktif' => $totalPedagangAktif,
            'statusTransaksi' => $statusTransaksi,
            'transaksiTerbaru' => $transaksiFiltered,
            'pengumumanTerbaru' => $pengumumanTerbaru,
            'filters' => [
                'status_transaksi' => $request->string('status_transaksi')->toString(),
                'tanggal_dari' => $request->string('tanggal_dari')->toString(),
                'tanggal_sampai' => $request->string('tanggal_sampai')->toString(),
                'sort_by' => $sortBy,
                'sort_dir' => $sortDir,
            ],
        ]);
    }

    public function adminExport(Request $request): StreamedResponse
    {
        $query = TransaksiPasar::with(['petani', 'pedagang']);

        if ($request->filled('status_transaksi')) {
            $query->where('status_transaksi', $request->string('status_transaksi'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->string('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->string('tanggal_sampai'));
        }

        $filename = 'transaksi_admin_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Petani', 'Pedagang', 'Volume Kg', 'Harga/Kg', 'Total Bayar', 'Status']);

            $query->orderByDesc('tanggal_transaksi')->chunk(100, function ($rows) use ($handle): void {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        optional($row->tanggal_transaksi)->format('Y-m-d'),
                        $row->petani?->nama,
                        $row->pedagang?->nama,
                        $row->volume_kg,
                        $row->harga_per_kg,
                        $row->total_bayar,
                        $row->status_transaksi,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function pedagang(): View
    {
        $kontrakAktif = KontrakKemitraan::with(['petani', 'pedagang'])
            ->whereIn('status_kontrak', ['Aktif', 'Menunggu Persetujuan', 'Draft'])
            ->latest()
            ->get();

        $totalKuota = (float) $kontrakAktif->sum('kuota_kg');

        $transaksiAktif = TransaksiPasar::whereIn('status_transaksi', ['Menunggu Validasi', 'Ditawar', 'Kontrak Terbit', 'Dikirim', 'Diterima'])->get();
        $kuotaTerpakai = (float) $transaksiAktif->sum('volume_kg');

        $hargaRataBeli = (float) TransaksiPasar::avg('harga_per_kg');
        $hargaRataKonsumen = (float) TransaksiPasar::whereNotNull('harga_konsumen_per_kg')->avg('harga_konsumen_per_kg');

        $trenPermintaan = PreferensiKonsumen::orderBy('periode')
            ->get(['judul_survei', 'estimasi_permintaan_kg', 'periode']);

        $listPetani = User::where('role', 'petani')->orderBy('nama')->get(['id', 'nama']);
        $listPedagang = User::where('role', 'pedagang')->orderBy('nama')->get(['id', 'nama']);

        return view('dashboard.pedagang', [
            'kontrakAktif' => $kontrakAktif,
            'totalKuota' => $totalKuota,
            'kuotaTerpakai' => $kuotaTerpakai,
            'hargaRataBeli' => $hargaRataBeli,
            'hargaRataKonsumen' => $hargaRataKonsumen,
            'trenPermintaan' => $trenPermintaan,
            'listPetani' => $listPetani,
            'listPedagang' => $listPedagang,
        ]);
    }

    public function publishHarga(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'petani_id' => ['required', 'exists:users,id'],
            'pedagang_id' => ['required', 'exists:users,id'],
            'volume_kg' => ['required', 'numeric', 'min:1'],
            'harga_per_kg' => ['required', 'numeric', 'min:1'],
            'harga_konsumen_per_kg' => ['nullable', 'numeric', 'min:1'],
            'tanggal_transaksi' => ['required', 'date'],
        ]);

        $data['status_logistik'] = 'Belum Diproses';
        $data['status_transaksi'] = 'Menunggu Validasi';
        $data['tingkat_kerusakan_persen'] = 0;

        TransaksiPasar::create($data);

        return back()->with('success', 'Harga beli berhasil dipublikasikan sebagai transaksi baru.');
    }

    public function updateStatusKontrak(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status_kontrak' => ['required', 'in:Draft,Menunggu Persetujuan,Aktif,Selesai,Ditolak'],
        ]);

        $kontrak = KontrakKemitraan::findOrFail($id);
        $kontrak->update($data);

        return back()->with('success', 'Status kontrak berhasil diperbarui.');
    }

    public function renegosiasiKontrak(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'kuota_kg' => ['required', 'numeric', 'min:1'],
            'harga_acuan_per_kg' => ['required', 'numeric', 'min:1'],
            'mekanisme_sengketa' => ['nullable', 'string'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $kontrak = KontrakKemitraan::findOrFail($id);
        $kontrak->update($data);

        return back()->with('success', 'Renegosiasi kontrak berhasil disimpan.');
    }

    public function logistik(): View
    {
        $transitData = TransaksiPasar::with(['petani', 'pedagang'])
            ->orderByDesc('tanggal_transaksi')
            ->get();

        $ringkasanStatusLogistik = TransaksiPasar::select('status_logistik', DB::raw('count(*) as total'))
            ->groupBy('status_logistik')
            ->get();

        $rataKerusakan = (float) TransaksiPasar::avg('tingkat_kerusakan_persen');

        $jadwalTerdekat = JadwalPemupukan::with('user')
            ->orderBy('tanggal')
            ->limit(5)
            ->get();

        $alertLogistik = TransaksiPasar::with(['petani', 'pedagang'])
            ->where(function ($q): void {
                $q->where('tingkat_kerusakan_persen', '>=', 5)
                    ->orWhereIn('status_logistik', ['Belum Diproses', 'Di Gudang Sementara']);
            })
            ->orderByDesc('tanggal_transaksi')
            ->limit(5)
            ->get();

        return view('dashboard.logistik', [
            'transitData' => $transitData,
            'ringkasanStatusLogistik' => $ringkasanStatusLogistik,
            'rataKerusakan' => $rataKerusakan,
            'jadwalTerdekat' => $jadwalTerdekat,
            'alertLogistik' => $alertLogistik,
        ]);
    }

    public function updateLogistik(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status_logistik' => ['required', 'in:Belum Diproses,Di Gudang Sementara,Dalam Pengiriman,Terkirim'],
            'tingkat_kerusakan_persen' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $transaksi = TransaksiPasar::findOrFail($id);
        $transaksi->update([
            'status_logistik' => $data['status_logistik'],
            'tingkat_kerusakan_persen' => $data['tingkat_kerusakan_persen'] ?? 0,
        ]);

        return back()->with('success', 'Data logistik transaksi berhasil diperbarui.');
    }

    public function kontrakDetail(int $id): View
    {
        $kontrak = KontrakKemitraan::with(['petani', 'pedagang'])->findOrFail($id);

        $transaksiTerkait = TransaksiPasar::where('petani_id', $kontrak->petani_id)
            ->where('pedagang_id', $kontrak->pedagang_id)
            ->latest('tanggal_transaksi')
            ->limit(10)
            ->get();

        $realisasiKuota = (float) $transaksiTerkait->sum('volume_kg');
        $persentaseRealisasi = $kontrak->kuota_kg > 0 ? ($realisasiKuota / (float) $kontrak->kuota_kg) * 100 : 0;

        $timeline = [
            ['label' => 'Draft', 'aktif' => true],
            ['label' => 'Menunggu Persetujuan', 'aktif' => in_array($kontrak->status_kontrak, ['Menunggu Persetujuan', 'Aktif', 'Selesai'], true)],
            ['label' => 'Aktif', 'aktif' => in_array($kontrak->status_kontrak, ['Aktif', 'Selesai'], true)],
            ['label' => 'Selesai', 'aktif' => $kontrak->status_kontrak === 'Selesai'],
        ];

        return view('kontrak.show', [
            'kontrak' => $kontrak,
            'transaksiTerkait' => $transaksiTerkait,
            'realisasiKuota' => $realisasiKuota,
            'persentaseRealisasi' => $persentaseRealisasi,
            'timeline' => $timeline,
        ]);
    }

    public function kontrakUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status_kontrak' => ['required', 'in:Draft,Menunggu Persetujuan,Aktif,Selesai,Ditolak'],
        ]);

        $kontrak = KontrakKemitraan::findOrFail($id);
        $kontrak->update($data);

        return back()->with('success', 'Status kontrak berhasil diperbarui dari halaman detail.');
    }

    public function batchBaru(): View
    {
        $listPetani = User::where('role', 'petani')->orderBy('nama')->get(['id', 'nama']);
        $listPedagang = User::where('role', 'pedagang')->orderBy('nama')->get(['id', 'nama']);

        return view('pages.batch-baru', compact('listPetani', 'listPedagang'));
    }

    public function batchBaruStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'petani_id' => ['required', 'exists:users,id'],
            'pedagang_id' => ['required', 'exists:users,id'],
            'volume_kg' => ['required', 'numeric', 'min:1'],
            'harga_per_kg' => ['required', 'numeric', 'min:1'],
            'harga_konsumen_per_kg' => ['nullable', 'numeric', 'min:1'],
            'tanggal_transaksi' => ['required', 'date'],
        ]);

        $data['status_logistik'] = 'Belum Diproses';
        $data['status_transaksi'] = 'Menunggu Validasi';
        $data['tingkat_kerusakan_persen'] = 0;

        TransaksiPasar::create($data);

        return redirect()->route('dashboard.admin')->with('success', 'Batch baru berhasil dibuat.');
    }

    public function pengaturan(Request $request): View
    {
        return view('pages.pengaturan', [
            'pengaturan' => [
                'tema' => $request->session()->get('pengaturan.tema', 'light'),
                'bahasa' => $request->session()->get('pengaturan.bahasa', 'id'),
                'notifikasi_email' => $request->session()->get('pengaturan.notifikasi_email', true),
            ],
        ]);
    }

    public function pengaturanUpdate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tema' => ['required', 'in:light,dark'],
            'bahasa' => ['required', 'in:id,en'],
            'notifikasi_email' => ['nullable', 'in:0,1'],
        ]);

        $request->session()->put('pengaturan', [
            'tema' => $data['tema'],
            'bahasa' => $data['bahasa'],
            'notifikasi_email' => ($data['notifikasi_email'] ?? '0') === '1',
        ]);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function profil(): View
    {
        $userDemo = User::query()
            ->orderByRaw("CASE
                WHEN role = 'admin' THEN 1
                WHEN role = 'pedagang' THEN 2
                WHEN role = 'petani' THEN 3
                ELSE 4
            END")
            ->first();

        return view('pages.profil', [
            'userDemo' => $userDemo,
        ]);
    }

    public function notifikasi(): View
    {
        $pengumuman = Pengumuman::with('pembuat')->latest('tanggal_terbit')->limit(20)->get();

        $alertTransaksi = TransaksiPasar::with(['petani', 'pedagang'])
            ->whereIn('status_transaksi', ['Menunggu Validasi', 'Ditawar'])
            ->orWhere('tingkat_kerusakan_persen', '>=', 5)
            ->latest('tanggal_transaksi')
            ->limit(10)
            ->get();

        return view('pages.notifikasi', [
            'pengumuman' => $pengumuman,
            'alertTransaksi' => $alertTransaksi,
        ]);
    }

    public function bantuan(): View
    {
        return view('pages.bantuan');
    }
}
