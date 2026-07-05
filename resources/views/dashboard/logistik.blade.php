@extends('layouts.app')

@section('title', 'CitrusCore - Manajemen Logistik')
@section('header', 'Manajemen Logistik')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Monitoring Logistik & Inventaris</h1>
                <p class="text-slate-500 mt-1">Pantau status pengiriman, kerusakan komoditas, dan jadwal operasional
                    lapangan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-kpi-card judul="Rata-rata Kerusakan" :nilai="number_format($rataKerusakan, 2, ',', '.') . '%'" ikon="warning" subtitle="Semua transaksi"
                warna="danger" />
            <x-kpi-card judul="Transaksi Logistik" :nilai="$transitData->count()" ikon="local_shipping"
                subtitle="Data pengiriman tercatat" warna="primary" />
            <x-kpi-card judul="Jadwal Terdekat" :nilai="$jadwalTerdekat->count()" ikon="event" subtitle="Agenda pemupukan/kegiatan"
                warna="accent" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="card-title">Tracking Pengiriman</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-citrus">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Petani</th>
                                <th>Pedagang</th>
                                <th>Status Logistik</th>
                                <th>Kerusakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transitData as $item)
                                <tr>
                                    <td>{{ $item->tanggal_transaksi?->format('d M Y') }}</td>
                                    <td>{{ $item->petani?->nama }}</td>
                                    <td>{{ $item->pedagang?->nama }}</td>
                                    <td><x-status-badge :status="$item->status_logistik" /></td>
                                    <td>{{ number_format((float) $item->tingkat_kerusakan_persen, 2, ',', '.') }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-slate-500">Belum ada data logistik.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Status Logistik</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @forelse($ringkasanStatusLogistik as $status)
                            <div
                                class="rounded-lg border border-slate-200 bg-slate-50 p-3 flex items-center justify-between">
                                <x-status-badge :status="$status->status_logistik" />
                                <span class="font-semibold text-slate-700">{{ $status->total }}</span>
                            </div>
                        @empty
                            <p class="text-slate-500">Belum ada ringkasan.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Lapangan Terdekat</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($jadwalTerdekat as $jadwal)
                            <article class="rounded-lg border border-slate-200 p-3 bg-white">
                                <p class="text-sm font-semibold text-slate-800">{{ $jadwal->user?->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $jadwal->tanggal?->format('d M Y') }} •
                                    {{ $jadwal->jenis_kegiatan }}</p>
                                <p class="text-xs text-slate-600 mt-1">
                                    {{ $jadwal->jenis_pupuk_obat ?: 'Tanpa keterangan bahan' }}</p>
                            </article>
                        @empty
                            <p class="text-slate-500">Belum ada jadwal.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
