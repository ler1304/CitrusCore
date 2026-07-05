@extends('layouts.app')

@section('title', 'CitrusCore - Detail Kontrak')
@section('header', 'Detail Kontrak')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-ibm font-bold text-slate-900">Kontrak #{{ $kontrak->id }}</h1>
                <p class="text-slate-500 mt-1">Detail kemitraan digital antara petani dan pedagang.</p>
            </div>
            <div class="flex items-center gap-2">
                <x-status-badge :status="$kontrak->status_kontrak" />
                <a href="{{ route('dashboard.pedagang') }}" class="btn-soft">Kembali</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Inti Kontrak</h3>
                </div>
                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="info-item">
                        <span>Petani</span>
                        <strong>{{ $kontrak->petani?->nama }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Pedagang</span>
                        <strong>{{ $kontrak->pedagang?->nama }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Kuota</span>
                        <strong>{{ number_format((float) $kontrak->kuota_kg, 0, ',', '.') }} Kg</strong>
                    </div>
                    <div class="info-item">
                        <span>Harga Acuan</span>
                        <strong>Rp {{ number_format((float) $kontrak->harga_acuan_per_kg, 0, ',', '.') }}/Kg</strong>
                    </div>
                    <div class="info-item">
                        <span>Tanggal Mulai</span>
                        <strong>{{ $kontrak->tanggal_mulai?->format('d M Y') ?: '-' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Tanggal Selesai</span>
                        <strong>{{ $kontrak->tanggal_selesai?->format('d M Y') ?: '-' }}</strong>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mekanisme Sengketa</h3>
                </div>
                <div class="p-4">
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $kontrak->mekanisme_sengketa ?: 'Belum ada mekanisme sengketa yang dicantumkan.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Transaksi Terkait</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table-citrus">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Volume</th>
                            <th>Harga Beli</th>
                            <th>Harga Konsumen</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerkait as $trx)
                            <tr>
                                <td>{{ $trx->tanggal_transaksi?->format('d M Y') }}</td>
                                <td>{{ number_format((float) $trx->volume_kg, 0, ',', '.') }} Kg</td>
                                <td>Rp {{ number_format((float) $trx->harga_per_kg, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $trx->harga_konsumen_per_kg, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $trx->total_bayar, 0, ',', '.') }}</td>
                                <td><x-status-badge :status="$trx->status_transaksi" /></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-slate-500">Belum ada transaksi terkait
                                    kontrak ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
