@extends('layouts.app')

@section('title', 'CitrusCore - Batch Baru')
@section('header', 'Batch Baru')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Input Batch Baru</h1>
            <p class="text-slate-500 mt-1">Catat transaksi awal pembelian jeruk dari petani ke pedagang.</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Batch</h3>
            </div>

            <form action="{{ route('batch.baru.store') }}" method="POST" class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-700">Petani</label>
                    <select name="petani_id" class="input mt-1" required>
                        <option value="">Pilih Petani</option>
                        @foreach ($listPetani as $petani)
                            <option value="{{ $petani->id }}" @selected(old('petani_id') == $petani->id)>{{ $petani->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Pedagang</label>
                    <select name="pedagang_id" class="input mt-1" required>
                        <option value="">Pilih Pedagang</option>
                        @foreach ($listPedagang as $pedagang)
                            <option value="{{ $pedagang->id }}" @selected(old('pedagang_id') == $pedagang->id)>{{ $pedagang->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Volume (Kg)</label>
                    <input type="number" step="0.01" min="1" name="volume_kg" value="{{ old('volume_kg') }}"
                        class="input mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Harga Beli per Kg (Rp)</label>
                    <input type="number" step="0.01" min="1" name="harga_per_kg"
                        value="{{ old('harga_per_kg') }}" class="input mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Harga Konsumen per Kg (Rp)</label>
                    <input type="number" step="0.01" min="1" name="harga_konsumen_per_kg"
                        value="{{ old('harga_konsumen_per_kg') }}" class="input mt-1">
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi"
                        value="{{ old('tanggal_transaksi', now()->toDateString()) }}" class="input mt-1" required>
                </div>

                <div class="md:col-span-2 flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('dashboard.admin') }}" class="btn-soft">Batal</a>
                    <button type="submit" class="btn-primary">Simpan Batch</button>
                </div>
            </form>
        </div>
    </div>
@endsection
