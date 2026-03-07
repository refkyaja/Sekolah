@extends('layouts.ppdb')

@section('title', 'Pendaftaran Ditutup - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6 flex items-center justify-center">
    <div class="max-w-2xl w-full text-center">
        <!-- Icon -->
        <div class="w-24 h-24 bg-white text-stone-300 rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-sm">
            <span class="material-symbols-outlined text-5xl">event_busy</span>
        </div>
        
        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-400 mb-4 block">Informasi PPDB</span>
        <h1 class="text-5xl font-extrabold tracking-tight text-brand-dark mb-8 uppercase">PENDAFTARAN<br>BELUM DIBUKA.</h1>
        
        <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
            Periode pendaftaran PPDB untuk tahun ajaran ini belum dimulai atau sudah berakhir. Silakan periksa jadwal resmi di bawah ini.
        </p>

        <!-- Schedule Info -->
        @if(isset($setting) && $setting && ($setting->pendaftaran_mulai || $setting->pendaftaran_selesai))
        <div class="bg-white rounded-[3rem] p-12 mb-16 shadow-xl border border-stone-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 text-left">
                @if($setting->pendaftaran_mulai)
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-2 block">Pendaftaran Buka</span>
                    <div class="text-xl font-extrabold text-brand-dark">{{ $setting->pendaftaran_mulai->translatedFormat('d F Y') }}</div>
                    <div class="text-[10px] font-bold text-brand-primary uppercase mt-1">Pukul 08:00 WIB</div>
                </div>
                @endif

                @if($setting->pendaftaran_selesai)
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-2 block">Pendaftaran Tutup</span>
                    <div class="text-xl font-extrabold text-brand-dark">{{ $setting->pendaftaran_selesai->translatedFormat('d F Y') }}</div>
                    <div class="text-[10px] font-bold text-rose-400 uppercase mt-1">Sistem Ditutup Otomatis</div>
                </div>
                @endif
            </div>
            
            {{-- Status Banner --}}
            @if(isset($now) && $setting->pendaftaran_mulai && $now < $setting->pendaftaran_mulai)
            <div class="mt-12 p-6 bg-brand-soft rounded-2xl flex items-center gap-4 text-left">
                <span class="material-symbols-outlined text-brand-primary">schedule</span>
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark">Akan segera dibuka</p>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight mt-0.5">Persiapkan dokumen Anda sekarang.</p>
                </div>
            </div>
            @endif
        </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('spmb.index') }}" 
               class="bg-brand-dark text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-xl">
                Halaman Utama
            </a>
            
            <a href="https://wa.me/6281234567890" target="_blank"
               class="border-2 border-stone-200 text-brand-dark font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-white hover:border-brand-primary">
                Tanya WhatsApp
            </a>
        </div>

        <p class="mt-20 text-[10px] font-bold text-stone-300 uppercase tracking-[0.25em]">Harapan Bangsa 1 — Timeless Education</p>
    </div>
</div>
@endsection
