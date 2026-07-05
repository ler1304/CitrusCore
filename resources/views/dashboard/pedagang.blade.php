@extends('layouts.app')

@section('title', 'CitrusCore - Portal Pedagang')
@section('header', 'Portal Pedagang')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Portal Pedagang Pengumpul</h1>
                <p class="text-slate-500 mt-1">Kelola kuota pembelian, kontrak aktif, dan tren harga pasar.</p>
            </div>
            <div class="flex gap-2">
                <a href="#form-publikasi-harga" class="btn-soft">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span> Publikasi Harga
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-kpi-card judul="Total Kuota Aktif" :nilai="number_format($totalKuota, 0, ',', '.') . ' Kg'" ikon="shopping_basket" subtitle="Akumulasi kuota kontrak"
                warna="secondary" />
            <x-kpi-card judul="Rata-rata Harga Beli" :nilai="'Rp ' . number_format($hargaRataBeli, 0, ',', '.')" ikon="payments" subtitle="Harga beli dari petani"
                warna="primary" />
            <x-kpi-card judul="Rata-rata Harga Konsumen" :nilai="'Rp ' . number_format($hargaRataKonsumen, 0, ',', '.')" ikon="trending_up"
                subtitle="Referensi margin pasar" warna="accent" />
        </div>

        <div id="form-publikasi-harga" class="card p-4">
            <h3 class="card-title mb-3">Publikasi Harga Beli</h3>
            <form method="POST" action="{{ route('dashboard.pedagang.publish-harga') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-3 js-rupiah-form">
                @csrf
                <div>
                    <label class="text-xs text-slate-500">Petani</label>
                    <select name="petani_id" class="w-full rounded-lg border-slate-300" required>
                        @foreach ($listPetani as $petani)
                            <option value="{{ $petani->id }}">{{ $petani->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Pedagang</label>
                    <select name="pedagang_id" class="w-full rounded-lg border-slate-300" required>
                        @foreach ($listPedagang as $pedagang)
                            <option value="{{ $pedagang->id }}">{{ $pedagang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="w-full rounded-lg border-slate-300" required>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Volume (Kg)</label>
                    <input type="number" step="0.01" min="1" name="volume_kg"
                        class="w-full rounded-lg border-slate-300" required>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Harga Beli / Kg (Rp)</label>
                    <input type="text" data-rupiah-display class="w-full rounded-lg border-slate-300"
                        placeholder="Rp 3.300">
                    <input type="hidden" name="harga_per_kg" data-rupiah-value required>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Harga Konsumen / Kg (Rp)</label>
                    <input type="text" data-rupiah-display class="w-full rounded-lg border-slate-300"
                        placeholder="Rp 6.100">
                    <input type="hidden" name="harga_konsumen_per_kg" data-rupiah-value>
                </div>
                <div class="md:col-span-3">
                    <button type="submit" class="btn-primary">Publikasikan Harga</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <div class="lg:col-span-8 card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kontrak</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-citrus">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Petani</th>
                                <th>Pedagang</th>
                                <th>Kuota</th>
                                <th>Harga Acuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kontrakAktif as $kontrak)
                                <tr>
                                    <td>#{{ $kontrak->id }}</td>
                                    <td>{{ $kontrak->petani?->nama }}</td>
                                    <td>{{ $kontrak->pedagang?->nama }}</td>
                                    <td>{{ number_format((float) $kontrak->kuota_kg, 0, ',', '.') }} Kg</td>
                                    <td>Rp {{ number_format((float) $kontrak->harga_acuan_per_kg, 0, ',', '.') }}</td>
                                    <td><x-status-badge :status="$kontrak->status_kontrak" /></td>
                                    <td>
                                        <a href="{{ route('kontrak.show', $kontrak->id) }}"
                                            class="text-citrus-primary hover:underline text-sm font-semibold">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-slate-500">Belum ada kontrak.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="lg:col-span-4 card">
                <div class="card-header">
                    <h3 class="card-title">Tren Permintaan</h3>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($trenPermintaan as $tren)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-sm font-semibold text-slate-800">{{ $tren->judul_survei }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $tren->periode?->format('F Y') }}</p>
                            <div class="mt-2 text-citrus-primary font-semibold">
                                {{ number_format((float) $tren->estimasi_permintaan_kg, 0, ',', '.') }} Kg
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500">Belum ada data tren.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.js-rupiah-form');

            const formatRupiah = (value) => {
                const numeric = (value || '').replace(/[^\d]/g, '');
                if (!numeric) return '';
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(numeric));
            };

            forms.forEach((form) => {
                const displays = form.querySelectorAll('[data-rupiah-display]');
                displays.forEach((displayInput) => {
                    const hidden = displayInput.parentElement.querySelector('[data-rupiah-value]');
                    displayInput.addEventListener('input', () => {
                        const raw = displayInput.value.replace(/[^\d]/g, '');
                        hidden.value = raw || '';
                        displayInput.value = formatRupiah(displayInput.value);
                    });
                });

                form.addEventListener('submit', () => {
                    form.querySelectorAll('[data-rupiah-display]').forEach((displayInput) => {
                        const hidden = displayInput.parentElement.querySelector(
                            '[data-rupiah-value]');
                        hidden.value = (hidden.value || '').replace(/[^\d]/g, '');
                    });
                });
            });
        });
    </script>
@endsection
