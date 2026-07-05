@extends('layouts.app')

@section('title', 'CitrusCore - Pengaturan')
@section('header', 'Pengaturan')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Pengaturan Aplikasi</h1>
            <p class="text-slate-500 mt-1">Sesuaikan preferensi antarmuka dan notifikasi CitrusCore.</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Preferensi</h3>
            </div>
            <form method="POST" action="{{ route('pengaturan.update') }}" class="p-4 space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-700">Tema</label>
                    <select name="tema" class="input mt-1" required>
                        <option value="light" @selected(($pengaturan['tema'] ?? 'light') === 'light')>Terang</option>
                        <option value="dark" @selected(($pengaturan['tema'] ?? 'light') === 'dark')>Gelap</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Bahasa</label>
                    <select name="bahasa" class="input mt-1" required>
                        <option value="id" @selected(($pengaturan['bahasa'] ?? 'id') === 'id')>Indonesia</option>
                        <option value="en" @selected(($pengaturan['bahasa'] ?? 'id') === 'en')>English</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <input id="notifikasi_email" type="checkbox" name="notifikasi_email" value="1"
                        @checked(($pengaturan['notifikasi_email'] ?? true) === true)>
                    <label for="notifikasi_email" class="text-sm font-medium text-slate-700">Aktifkan notifikasi
                        email</label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
