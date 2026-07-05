@extends('layouts.app')

@section('title', 'Modul Contract Management - CitrusCore')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Contract & Relationship Management</h1>
            <p class="text-sm text-slate-500">Buat kontrak kemitraan digital dan pantau progres kuota distribusi.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Buat Kontrak Baru</h2>
                <form method="POST" action="{{ route('modules.kontrak.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-sm text-slate-600">Petani</label>
                        <select name="petani_id" class="w-full rounded-lg border-slate-300" required>
                            @foreach ($petani as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Pedagang</label>
                        <select name="pedagang_id" class="w-full rounded-lg border-slate-300" required>
                            @foreach ($pedagang as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Kuota (kg)</label>
                        <input type="number" step="0.01" name="kuota_kg" class="w-full rounded-lg border-slate-300"
                            required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Harga Acuan / kg</label>
                        <input type="number" step="0.01" name="harga_acuan_per_kg"
                            class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Status Kontrak</label>
                        <select name="status_kontrak" class="w-full rounded-lg border-slate-300">
                            @foreach (['Draft', 'Menunggu Persetujuan', 'Aktif', 'Selesai', 'Ditolak'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-sm text-slate-600">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="w-full rounded-lg border-slate-300">
                        </div>
                        <div>
                            <label class="text-sm text-slate-600">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="w-full rounded-lg border-slate-300">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Mekanisme Sengketa</label>
                        <textarea name="mekanisme_sengketa" rows="3" class="w-full rounded-lg border-slate-300"></textarea>
                    </div>
                    <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg px-4 py-2">Simpan
                        Kontrak</button>
                </form>
            </div>

            <div class="lg:col-span-2 rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Daftar Kontrak Kemitraan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 border-b">
                                <th class="py-2">Petani</th>
                                <th class="py-2">Pedagang</th>
                                <th class="py-2">Kuota</th>
                                <th class="py-2">Harga Acuan</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kontrak as $k)
                                <tr class="border-b">
                                    <td class="py-2">{{ $k->petani?->nama }}</td>
                                    <td class="py-2">{{ $k->pedagang?->nama }}</td>
                                    <td class="py-2">{{ number_format((float) $k->kuota_kg, 2, ',', '.') }} kg</td>
                                    <td class="py-2">Rp {{ number_format((float) $k->harga_acuan_per_kg, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-700">{{ $k->status_kontrak }}</span>
                                    </td>
                                    <td class="py-2">
                                        {{ optional($k->tanggal_mulai)->format('d-m-Y') ?? '-' }}
                                        s/d
                                        {{ optional($k->tanggal_selesai)->format('d-m-Y') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-slate-500">Belum ada kontrak kemitraan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
