@extends('layouts.app')

@section('title', 'Modul Communication Hub - CitrusCore')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Centralized Communication Hub</h1>
            <p class="text-sm text-slate-500">Kelola pengumuman terpusat dan notifikasi operasional rantai pasok.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Buat Pengumuman Baru</h2>
                <form method="POST" action="{{ route('modules.komunikasi.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-sm text-slate-600">Dibuat Oleh (Admin ID)</label>
                        <input type="number" name="dibuat_oleh" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Target Role</label>
                        <select name="target_role" class="w-full rounded-lg border-slate-300">
                            <option value="semua">Semua</option>
                            <option value="petani">Petani</option>
                            <option value="pedagang">Pedagang</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Judul</label>
                        <input type="text" name="judul" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Isi</label>
                        <textarea name="isi" rows="4" class="w-full rounded-lg border-slate-300" required></textarea>
                    </div>
                    <div>
                        <label class="text-sm text-slate-600">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" class="w-full rounded-lg border-slate-300" required>
                    </div>
                    <button
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg px-4 py-2">Terbitkan</button>
                </form>
            </div>

            <div class="lg:col-span-2 rounded-xl bg-white border border-slate-200 p-4">
                <h2 class="font-semibold text-slate-800 mb-3">Papan Pengumuman Digital</h2>
                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($pengumuman as $item)
                        <div class="rounded-lg border border-slate-200 p-3">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-semibold text-slate-800">{{ $item->judul }}</h3>
                                <span
                                    class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600">{{ $item->target_role }}</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1">{{ $item->isi }}</p>
                            <div class="text-xs text-slate-400 mt-2">
                                Terbit: {{ optional($item->tanggal_terbit)->format('d-m-Y') }} • Oleh:
                                {{ $item->pembuat?->nama ?? 'Admin' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-slate-500">Belum ada pengumuman.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
