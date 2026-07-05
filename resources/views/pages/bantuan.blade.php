@extends('layouts.app')

@section('title', 'CitrusCore - Bantuan')
@section('header', 'Bantuan')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Pusat Bantuan</h1>
            <p class="text-slate-500 mt-1">Panduan cepat penggunaan fitur utama CitrusCore.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <article class="card">
                <div class="card-header">
                    <h3 class="card-title">Cara Input Batch Baru</h3>
                </div>
                <div class="p-4 text-sm text-slate-600 leading-relaxed">
                    Buka menu <strong>Batch Baru</strong>, pilih petani dan pedagang, isi volume dan harga, lalu simpan.
                </div>
            </article>

            <article class="card">
                <div class="card-header">
                    <h3 class="card-title">Cara Publikasi Harga</h3>
                </div>
                <div class="p-4 text-sm text-slate-600 leading-relaxed">
                    Masuk ke <strong>Portal Pedagang</strong>, gunakan form publikasi harga untuk membuat transaksi baru.
                </div>
            </article>

            <article class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter & Ekspor Admin</h3>
                </div>
                <div class="p-4 text-sm text-slate-600 leading-relaxed">
                    Di Dashboard Admin, gunakan filter status/tanggal, lalu klik <strong>Ekspor</strong> untuk unduh CSV.
                </div>
            </article>

            <article class="card">
                <div class="card-header">
                    <h3 class="card-title">Kontak Dukungan</h3>
                </div>
                <div class="p-4 text-sm text-slate-600 leading-relaxed">
                    Email: <a href="mailto:support@citruscore.test"
                        class="text-citrus-primary hover:underline">support@citruscore.test</a><br>
                    WA: <span class="font-semibold">+62 812-0000-1234</span>
                </div>
            </article>
        </div>
    </div>
@endsection
