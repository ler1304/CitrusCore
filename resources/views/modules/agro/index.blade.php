@extends('layouts.app')

@section('title', 'Modul Farm & Agro-Sensing - CitrusCore')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Farm & Agro-Sensing Management</h1>
            <p class="text-sm text-slate-500">Kelola jadwal pemupukan, pengendalian hama, dan rekomendasi varietas.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Tambah Jadwal Kegiatan</h2>
                <form method="POST" action="{{ route('modules.agro.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-sm text-slate-600">Petani</label>
                        <select name="user_id" class="w-full rounded-lg border-slate-300" required>
                            @foreach ($petani as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Jenis Kegiatan</label>
                        <select name="jenis_kegiatan" class="w-full rounded-lg border-slate-300" required>
                            <option value="Pemupukan">Pemupukan</option>
                            <option value="Pengendalian Hama">Pengendalian Hama</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Jenis Pupuk/Obat</label>
                        <input type="text" name="jenis_pupuk_obat" class="w-full rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Biaya Estimasi</label>
                        <input type="number" step="0.01" name="biaya_estimasi"
                            class="w-full rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Rekomendasi Varietas</label>
                        <input type="text" name="rekomendasi_varietas" class="w-full rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Catatan</label>
                        <textarea name="catatan" rows="3" class="w-full rounded-lg border-slate-300"></textarea>
                    </div>
                    <button class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg px-4 py-2">Simpan
                        Jadwal</button>
                </form>
            </div>

            <div class="lg:col-span-2 rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Daftar Jadwal Kegiatan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 border-b">
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Petani</th>
                                <th class="py-2">Kegiatan</th>
                                <th class="py-2">Pupuk/Obat</th>
                                <th class="py-2">Biaya</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwal as $item)
                                <tr class="border-b">
                                    <td class="py-2">{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                                    <td class="py-2">{{ $item->user?->nama }}</td>
                                    <td class="py-2">{{ $item->jenis_kegiatan }}</td>
                                    <td class="py-2">{{ $item->jenis_pupuk_obat ?? '-' }}</td>
                                    <td class="py-2">Rp {{ number_format((float) $item->biaya_estimasi, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2">
                                        @if ($item->sudah_dilaksanakan)
                                            <span
                                                class="px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-700">Selesai</span>
                                        @else
                                            <span
                                                class="px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">Belum</span>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <form method="POST" action="{{ route('modules.agro.status', $item->id) }}">
                                            @csrf
                                            <input type="hidden" name="sudah_dilaksanakan"
                                                value="{{ $item->sudah_dilaksanakan ? '0' : '1' }}">
                                            <button
                                                class="text-xs px-3 py-1 rounded-lg bg-sky-600 text-white hover:bg-sky-700">
                                                {{ $item->sudah_dilaksanakan ? 'Set Belum' : 'Set Selesai' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-slate-500">Belum ada jadwal kegiatan.
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
