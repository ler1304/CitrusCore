@props(['judul', 'nilai', 'ikon' => 'analytics', 'subtitle' => null, 'warna' => 'primary'])

@php
    $tone = match ($warna) {
        'secondary' => 'text-citrus-secondary bg-orange-100',
        'accent' => 'text-citrus-accent bg-sky-100',
        'danger' => 'text-rose-700 bg-rose-100',
        default => 'text-citrus-primary bg-emerald-100',
    };
@endphp

<div class="glass-card rounded-xl p-5 hover:-translate-y-0.5 transition-transform">
    <div class="flex items-start justify-between mb-3">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">{{ $judul }}</p>
        <span class="material-symbols-outlined p-2 rounded-lg {{ $tone }}">{{ $ikon }}</span>
    </div>
    <p class="text-3xl font-ibm font-bold text-slate-900">{{ $nilai }}</p>
    @if ($subtitle)
        <p class="mt-2 text-sm text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
