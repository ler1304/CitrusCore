@extends('layouts.app')

@section('title', 'Modul Demand & Market Intelligence - CitrusCore')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Demand & Market Intelligence</h1>
                <p class="text-sm text-slate-500">Analisis preferensi konsumen dan proyeksi permintaan pasar jeruk.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <p class="text-xs uppercase text-slate-500">Total Estimasi Permintaan</p>
                <p class="text-2xl font-bold text-emerald-700">
                    {{ number_format($forecast['total_permintaan_kg'], 2, ',', '.') }} kg</p>
            </div>
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <p class="text-xs uppercase text-slate-500">Rata-Rata Permintaan</p>
                <p class="text-2xl font-bold text-orange-600">
                    {{ number_format($forecast['rata_permintaan_kg'], 2, ',', '.') }} kg</p>
            </div>
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <p class="text-xs uppercase text-slate-500">Jumlah Survei</p>
                <p class="text-2xl font-bold text-sky-600">{{ $preferensi->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Input Survei Preferensi</h2>
                <form method="POST" action="{{ route('modules.demand.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-sm text-slate-600">Admin Penginput</label>
                        <select name="dibuat_oleh" class="w-full rounded-lg border-slate-300">
                            @foreach ($adminList as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Judul Survei</label>
                        <input type="text" name="judul_survei" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-sm text-slate-600">Warna Favorit</label>
                            <select name="warna_favorit" class="w-full rounded-lg border-slate-300">
                                <option value="">-</option>
                                <option value="Hijau">Hijau</option>
                                <option value="Oranye">Oranye</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-slate-600">Ukuran Favorit</label>
                            <select name="ukuran_favorit" class="w-full rounded-lg border-slate-300">
                                <option value="">-</option>
                                <option value="Kecil">Kecil</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Besar">Besar</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Estimasi Permintaan (kg)</label>
                        <input type="number" step="0.01" name="estimasi_permintaan_kg"
                            class="w-full rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Periode</label>
                        <input type="date" name="periode" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full rounded-lg border-slate-300"></textarea>
                    </div>
                    <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg px-4 py-2">Simpan
                        Survei</button>
                </form>
            </div>

            <div class="lg:col-span-2 rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Daftar Preferensi Konsumen</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 border-b">
                                <th class="py-2">Periode</th>
                                <th class="py-2">Judul Survei</th>
                                <th class="py-2">Warna</th>
                                <th class="py-2">Ukuran</th>
                                <th class="py-2">Estimasi (kg)</th>
                                <th class="py-2">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($preferensi as $row)
                                <tr class="border-b">
                                    <td class="py-2">{{ optional($row->periode)->format('d-m-Y') }}</td>
                                    <td class="py-2">{{ $row->judul_survei }}</td>
                                    <td class="py-2">{{ $row->warna_favorit ?? '-' }}</td>
                                    <td class="py-2">{{ $row->ukuran_favorit ?? '-' }}</td>
                                    <td class="py-2">
                                        {{ number_format((float) $row->estimasi_permintaan_kg, 2, ',', '.') }}</td>
                                    <td class="py-2">{{ $row->pembuat?->nama }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-slate-500">Belum ada data survei.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
