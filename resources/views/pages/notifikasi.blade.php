@extends('layouts.app')

@section('title', 'CitrusCore - Notifikasi')
@section('header', 'Notifikasi')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Pusat Notifikasi</h1>
            <p class="text-slate-500 mt-1">Pantau pengumuman resmi dan alert transaksi penting.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengumuman Terbaru</h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse ($pengumuman as $item)
                        <article class="rounded-lg border border-slate-200 bg-white p-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-slate-800">{{ $item->judul }}</p>
                                <span class="text-xs text-slate-500">{{ $item->tanggal_terbit?->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1">{{ $item->isi }}</p>
                            <p class="text-xs text-slate-500 mt-2">Oleh: {{ $item->pembuat?->nama ?? 'Admin' }}</p>
                        </article>
                    @empty
                        <p class="text-slate-500">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Alert Transaksi</h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse ($alertTransaksi as $trx)
                        <article class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-slate-800">
                                    {{ $trx->petani?->nama }} → {{ $trx->pedagang?->nama }}
                                </p>
                                <x-status-badge :status="$trx->status_transaksi" />
                            </div>
                            <p class="text-sm text-slate-600 mt-1">
                                {{ $trx->tanggal_transaksi?->format('d M Y') }} •
                                Kerusakan: {{ number_format((float) $trx->tingkat_kerusakan_persen, 2, ',', '.') }}%
                            </p>
                        </article>
                    @empty
                        <p class="text-slate-500">Belum ada alert transaksi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
