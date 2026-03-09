@extends('layouts.nav-spmb')

@section('title', 'PPDB - Pendaftaran Ditutup')

@section('content')
<div class="max-w-[640px] mx-auto min-h-[60vh] flex flex-col items-center justify-center px-4 py-16 text-center">

    {{-- Icon --}}
    <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mb-8 shadow-lg shadow-primary/10">
        <span class="material-symbols-outlined text-primary" style="font-size: 48px;">event_busy</span>
    </div>

    {{-- Title --}}
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 mb-3">
        Pendaftaran Belum Dibuka
    </h1>
    <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed max-w-md mb-8">
        Periode pendaftaran PPDB untuk tahun ajaran ini belum dimulai atau sudah berakhir. Periksa jadwal di bawah ini.
    </p>

    {{-- Schedule Card --}}
    @if(isset($setting) && $setting && ($setting->pendaftaran_mulai || $setting->pendaftaran_selesai))
    <div class="w-full bg-white dark:bg-dark-card rounded-2xl border border-white/5 shadow-sm p-6 mb-8 space-y-4">

        @if($setting->pendaftaran_mulai)
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-primary">event</span>
                <span class="text-sm font-semibold">Tanggal Buka</span>
            </div>
            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                {{ $setting->pendaftaran_mulai->translatedFormat('d F Y') }}
            </span>
        </div>
        @endif

        @if($setting->pendaftaran_selesai)
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-3 text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-primary">event_available</span>
                <span class="text-sm font-semibold">Tanggal Tutup</span>
            </div>
            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">
                {{ $setting->pendaftaran_selesai->translatedFormat('d F Y') }}
            </span>
        </div>
        @endif
    </div>
    @endif

    {{-- Status Indicator --}}
    @if(isset($now) && isset($setting) && $setting && $setting->pendaftaran_mulai && $now < $setting->pendaftaran_mulai)
    <div class="w-full mb-8 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-blue-500">schedule</span>
        <div class="text-left">
            <p class="text-sm font-bold text-blue-700 dark:text-blue-400">Pendaftaran belum dimulai</p>
            <p class="text-xs text-blue-600 dark:text-blue-500">Akan dibuka pada {{ $setting->pendaftaran_mulai->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
    </div>
    @elseif(isset($now) && isset($setting) && $setting && $setting->pendaftaran_selesai && $now > $setting->pendaftaran_selesai)
    <div class="w-full mb-8 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-red-500">block</span>
        <div class="text-left">
            <p class="text-sm font-bold text-red-700 dark:text-red-400">Pendaftaran sudah ditutup</p>
            <p class="text-xs text-red-600 dark:text-red-500">Hubungi pihak sekolah untuk informasi lebih lanjut.</p>
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 w-full">
        <a href="{{ route('spmb.index') }}"
            class="flex-1 flex items-center justify-center gap-2 h-12 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-all shadow-md shadow-primary/20">
            <span class="material-symbols-outlined">home</span>
            Halaman PPDB
        </a>
        <a href="{{ route('spmb.pengumuman') }}"
            class="flex-1 flex items-center justify-center gap-2 h-12 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <span class="material-symbols-outlined">campaign</span>
            Pengumuman
        </a>
    </div>

    {{-- Help Text --}}
    <p class="mt-8 text-xs text-slate-400 dark:text-slate-600">
        Butuh bantuan? Hubungi kami di &nbsp;
        <a href="https://wa.me/6281234567890" class="text-primary hover:underline font-semibold">WhatsApp</a>
    </p>
</div>
@endsection
