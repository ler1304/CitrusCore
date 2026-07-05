@props(['status'])

@php
    $status = (string) $status;

    $classes = match ($status) {
        'Aktif',
        'Dibayar',
        'Diterima',
        'Terkirim',
        'Divalidasi Pedagang'
            => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'Menunggu Persetujuan',
        'Menunggu Validasi',
        'Draft',
        'Belum Diproses',
        'Di Gudang Sementara'
            => 'bg-amber-100 text-amber-800 border-amber-200',
        'Ditolak', 'Perlu Revisi' => 'bg-rose-100 text-rose-800 border-rose-200',
        'Dikirim', 'Dalam Pengiriman', 'Kontrak Terbit' => 'bg-sky-100 text-sky-800 border-sky-200',
        default => 'bg-slate-100 text-slate-700 border-slate-200',
    };
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-full border px-2.5 py-1 text-xs font-semibold {$classes}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full bg-current/70"></span>
    {{ $status }}
</span>
