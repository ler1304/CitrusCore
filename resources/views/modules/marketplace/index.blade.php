@extends('layouts.app')

@section('title', 'Modul B2B Marketplace - CitrusCore')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">B2B Marketplace & Financial Transparency</h1>
            <p class="text-sm text-slate-500">Pantau transaksi, transparansi margin, dan update status operasional
                perdagangan.</p>
        </div>

        <div class="rounded-xl bg-white border border-slate-200 p-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-500 border-b">
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Petani</th>
                            <th class="py-2">Pedagang</th>
                            <th class="py-2">Volume (kg)</th>
                            <th class="py-2">Harga Beli</th>
                            <th class="py-2">Harga Konsumen</th>
                            <th class="py-2">Margin</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $trx)
                            <tr class="border-b">
                                <td class="py-2">{{ optional($trx->tanggal_transaksi)->format('d-m-Y') }}</td>
                                <td class="py-2">{{ $trx->petani?->nama }}</td>
                                <td class="py-2">{{ $trx->pedagang?->nama }}</td>
                                <td class="py-2">{{ number_format((float) $trx->volume_kg, 2, ',', '.') }}</td>
                                <td class="py-2">Rp {{ number_format((float) $trx->harga_per_kg, 0, ',', '.') }}</td>
                                <td class="py-2">Rp {{ number_format((float) $trx->harga_konsumen_per_kg, 0, ',', '.') }}
                                </td>
                                <td class="py-2">{{ number_format((float) $trx->margin_persen, 2, ',', '.') }}%</td>
                                <td class="py-2">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-700">{{ $trx->status_transaksi }}</span>
                                </td>
                                <td class="py-2">
                                    <form method="POST" action="{{ route('modules.marketplace.status', $trx->id) }}"
                                        class="flex items-center gap-2">
                                        @csrf
                                        <select name="status_transaksi" class="rounded-lg border-slate-300 text-xs">
                                            @foreach (['Menunggu Validasi', 'Ditawar', 'Kontrak Terbit', 'Dikirim', 'Diterima', 'Dibayar'] as $status)
                                                <option value="{{ $status }}" @selected($trx->status_transaksi === $status)>
                                                    {{ $status }}</option>
                                            @endforeach
                                        </select>
                                        <button
                                            class="text-xs px-2 py-1 rounded-lg bg-emerald-700 text-white">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-4 text-center text-slate-500">Belum ada transaksi marketplace.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
