@extends('layouts.app')

@section('title', 'CitrusCore - Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Kesehatan Rantai Pasok</h1>
                <p class="text-slate-500 mt-1">Ringkasan performa SCM jeruk secara real-time.</p>
            </div>
            <div class="flex gap-2">
                <a class="btn-soft"
                    href="{{ route(
                        'dashboard.admin',
                        array_filter([
                            'status_transaksi' => $filters['status_transaksi'] ?? null,
                            'tanggal_dari' => $filters['tanggal_dari'] ?? null,
                            'tanggal_sampai' => $filters['tanggal_sampai'] ?? null,
                            'sort_by' => $filters['sort_by'] ?? null,
                            'sort_dir' => $filters['sort_dir'] ?? null,
                        ]),
                    ) }}">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span> Filter Aktif
                </a>
                <a class="btn-primary"
                    href="{{ route(
                        'dashboard.admin.export',
                        array_filter([
                            'status_transaksi' => $filters['status_transaksi'] ?? null,
                            'tanggal_dari' => $filters['tanggal_dari'] ?? null,
                            'tanggal_sampai' => $filters['tanggal_sampai'] ?? null,
                        ]),
                    ) }}">
                    <span class="material-symbols-outlined text-[18px]">download</span> Ekspor CSV
                </a>
            </div>
        </div>

        <div class="card p-4">
            <form method="GET" action="{{ route('dashboard.admin') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Status Transaksi</label>
                    <select name="status_transaksi" class="w-full rounded-lg border-slate-300">
                        <option value="">Semua</option>
                        @foreach (['Menunggu Validasi', 'Ditawar', 'Kontrak Terbit', 'Dikirim', 'Diterima', 'Dibayar'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status_transaksi'] ?? '') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" value="{{ $filters['tanggal_dari'] ?? '' }}"
                        class="w-full rounded-lg border-slate-300">
                </div>
                <div>
                    <label class="text-xs text-slate-500">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" value="{{ $filters['tanggal_sampai'] ?? '' }}"
                        class="w-full rounded-lg border-slate-300">
                </div>
                <div>
                    <label class="text-xs text-slate-500">Urutkan</label>
                    <select name="sort_by" class="w-full rounded-lg border-slate-300">
                        @php $sortBy = $filters['sort_by'] ?? 'tanggal_transaksi'; @endphp
                        <option value="tanggal_transaksi" @selected($sortBy === 'tanggal_transaksi')>Tanggal</option>
                        <option value="volume_kg" @selected($sortBy === 'volume_kg')>Volume</option>
                        <option value="harga_per_kg" @selected($sortBy === 'harga_per_kg')>Harga / Kg</option>
                        <option value="total_bayar" @selected($sortBy === 'total_bayar')>Total Bayar</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Arah</label>
                    <select name="sort_dir" class="w-full rounded-lg border-slate-300">
                        @php $sortDir = $filters['sort_dir'] ?? 'desc'; @endphp
                        <option value="desc" @selected($sortDir === 'desc')>Terbaru / Tertinggi</option>
                        <option value="asc" @selected($sortDir === 'asc')>Terlama / Terendah</option>
                    </select>
                </div>
                <div class="md:col-span-6 flex gap-2">
                    <button type="submit" class="btn-primary">Terapkan Filter</button>
                    <a href="{{ route('dashboard.admin') }}" class="btn-soft">Reset</a>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-kpi-card judul="Total Panen Realisasi" :nilai="number_format($totalPanenKg, 0, ',', '.') . ' Kg'" ikon="agriculture"
                subtitle="Akumulasi dari seluruh petani" warna="primary" />
            <x-kpi-card judul="Kontrak Aktif" :nilai="$kontrakAktif" ikon="handshake" subtitle="Kontrak berjalan saat ini"
                warna="secondary" />
            <x-kpi-card judul="Rata-rata Kerusakan" :nilai="number_format($rataKerusakan, 2, ',', '.') . '%'" ikon="warning" subtitle="Monitoring kualitas logistik"
                warna="danger" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-citrus">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Petani</th>
                                <th>Pedagang</th>
                                <th>Volume</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $item)
                                <tr>
                                    <td>{{ $item->tanggal_transaksi?->format('d M Y') }}</td>
                                    <td>{{ $item->petani?->nama }}</td>
                                    <td>{{ $item->pedagang?->nama }}</td>
                                    <td>{{ number_format((float) $item->volume_kg, 0, ',', '.') }} Kg</td>
                                    <td><x-status-badge :status="$item->status_transaksi" /></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-slate-500">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status Transaksi</h3>
                </div>
                <div class="space-y-2 p-4">
                    @forelse($statusTransaksi as $status)
                        <div class="flex items-center justify-between rounded-lg bg-slate-50 border border-slate-200 p-3">
                            <x-status-badge :status="$status->status_transaksi" />
                            <span class="font-semibold text-slate-700">{{ $status->total }}</span>
                        </div>
                    @empty
                        <p class="text-slate-500">Belum ada status transaksi.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengumuman Terbaru</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                @forelse($pengumumanTerbaru as $item)
                    <article class="rounded-xl border border-slate-200 bg-white p-4">
                        <div class="flex items-center justify-between mb-2">
                            <x-status-badge :status="'Target: ' . ucfirst($item->target_role)" />
                            <span class="text-xs text-slate-500">{{ $item->tanggal_terbit?->format('d/m/Y') }}</span>
                        </div>
                        <h4 class="font-semibold text-slate-800">{{ $item->judul }}</h4>
                        <p class="text-sm text-slate-500 mt-2">{{ $item->isi }}</p>
                    </article>
                @empty
                    <p class="text-slate-500">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
