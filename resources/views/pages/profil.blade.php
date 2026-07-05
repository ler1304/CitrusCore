@extends('layouts.app')

@section('title', 'CitrusCore - Profil Pengguna')
@section('header', 'Profil Pengguna')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-ibm font-bold text-slate-900">Profil Pengguna</h1>
            <p class="text-slate-500 mt-1">Informasi akun pengguna aktif/demo di sistem CitrusCore.</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Profil</h3>
            </div>

            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="info-item">
                    <span>Nama</span>
                    <strong>{{ $userDemo?->nama ?? '-' }}</strong>
                </div>
                <div class="info-item">
                    <span>Email</span>
                    <strong>{{ $userDemo?->email ?? '-' }}</strong>
                </div>
                <div class="info-item">
                    <span>Role</span>
                    <strong>{{ ucfirst((string) $userDemo?->role) }}</strong>
                </div>
                <div class="info-item">
                    <span>No HP</span>
                    <strong>{{ $userDemo?->no_hp ?? '-' }}</strong>
                </div>
                <div class="info-item">
                    <span>Umur</span>
                    <strong>{{ $userDemo?->umur ?? '-' }}</strong>
                </div>
                <div class="info-item">
                    <span>Tingkat Pendidikan</span>
                    <strong>{{ strtoupper((string) ($userDemo?->tingkat_pendidikan ?? '-')) }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
