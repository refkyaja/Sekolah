@extends('layouts.ppdb')

@section('title', 'Pendaftaran Berhasil - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6 flex items-center justify-center">
    <div class="max-w-2xl w-full text-center">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-brand-primary text-white rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-2xl shadow-brand-primary/20 rotate-3">
            <span class="material-symbols-outlined text-5xl">check_circle</span>
        </div>
        
        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4 block">Langkah Pertama Selesai</span>
        <h1 class="text-5xl font-extrabold tracking-tight text-brand-dark mb-8 uppercase">PENDAFTARAN<br>BERHASIL DIKIRIM!</h1>
        
        <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
            Terima kasih telah mendaftarkan putra/putri Anda di Harapan Bangsa 1. Data Anda telah kami terima dengan nomor pendaftaran:
        </p>

        <!-- Ticket Style Info -->
        <div class="bg-white rounded-[3rem] p-12 mb-16 shadow-xl border border-stone-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-soft -mr-16 -mt-16 rounded-full opacity-50"></div>
            
            <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-2 block">Nomor Pendaftaran Anda</span>
            <div class="text-3xl font-extrabold tracking-tighter text-brand-dark mb-8">{{ $spmb->no_pendaftaran ?? 'PPDB-XXXXXXX' }}</div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 py-8 border-t border-dashed border-stone-200">
                <div>
                    <span class="material-symbols-outlined text-brand-primary mb-3">contact_phone</span>
                    <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-1">Verifikasi</h4>
                    <p class="text-[9px] font-bold text-stone-400 uppercase">Dalam 3x24 Jam</p>
                </div>
                <div>
                    <span class="material-symbols-outlined text-brand-primary mb-3">calendar_month</span>
                    <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-1">Tes Masuk</h4>
                    <p class="text-[9px] font-bold text-stone-400 uppercase">Juli 2026</p>
                </div>
                <div>
                    <span class="material-symbols-outlined text-brand-primary mb-3">info</span>
                    <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-1">Informasi</h4>
                    <p class="text-[9px] font-bold text-stone-400 uppercase">Via WhatsApp</p>
                </div>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ url('/') }}" 
               class="bg-brand-dark text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-xl">
                Kembali ke Beranda
            </a>
            
            <a href="https://wa.me/6281234567890" target="_blank"
               class="border-2 border-stone-200 text-brand-dark font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-white hover:border-brand-primary">
                Hubungi Admin
            </a>
        </div>

        <p class="mt-20 text-[10px] font-bold text-stone-300 uppercase tracking-[0.25em]">Harapan Bangsa 1 — Timeless Education</p>
    </div>
</div>
@endsection