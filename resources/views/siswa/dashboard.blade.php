@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<!-- Welcome Hero -->
<div class="relative overflow-hidden bg-brand-soft rounded-[2.5rem] p-12 flex flex-col md:flex-row items-center gap-12 border border-brand-primary/5 shadow-sm">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-primary/10 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-brand-primary/5 rounded-full blur-2xl opacity-50"></div>
    
    <div class="relative z-10 flex-1">
        <span class="text-[10px] font-extrabold uppercase tracking-[.3em] text-brand-primary mb-4 block">Selamat Datang</span>
        <h2 class="text-4xl lg:text-5xl font-extrabold text-brand-dark uppercase tracking-tighter leading-none mb-4">
            Halo, <br> {{ explode(' ', $siswa->nama_lengkap)[0] }}!
        </h2>
        <p class="text-stone-400 text-xs font-bold uppercase tracking-widest leading-relaxed max-w-md">
            Senang melihatmu kembali hari ini di TK Harapan Bangsa 1. Mari kita belajar hal baru bersama-sama!
        </p>
        
        @if(session('success'))
            <div class="mt-8 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-brand-primary/10 flex items-center gap-3 animate-fade-in shadow-sm">
                <div class="size-8 bg-brand-primary/10 rounded-full flex items-center justify-center text-brand-primary">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mt-8 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-red-500/10 flex items-center gap-3 animate-fade-in shadow-sm">
                <div class="size-8 bg-red-500/10 rounded-full flex items-center justify-center text-red-500">
                    <span class="material-symbols-outlined text-sm">error</span>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <div class="relative z-10 group">
        <div class="absolute -inset-4 bg-brand-primary/10 rounded-[3rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative w-56 h-56 bg-stone-100 rounded-[2.5rem] shadow-2xl border-8 border-white overflow-hidden transform group-hover:scale-105 transition-transform duration-700">
            <img src="{{ $siswa->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama_lengkap) . '&size=400' }}" 
                 class="w-full h-full object-cover" 
                 alt="{{ $siswa->nama_lengkap }}">
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-12 mt-12">
    <!-- Main Content (Announcements) -->
    <div class="space-y-12">
        <!-- Announcements -->
        <div class="space-y-8">
            <div class="flex items-center justify-between border-b border-stone-100 pb-6">
                <div>
                    <span class="text-[9px] font-extrabold uppercase tracking-[.2em] text-stone-300 block mb-1">Penting</span>
                    <h3 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight">Pengumuman</h3>
                </div>
                <a class="text-[10px] font-extrabold text-brand-primary uppercase tracking-widest hover:underline" href="#">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($pengumuman as $item)
                    <div class="group bg-white rounded-[2rem] p-8 border border-stone-100 hover:border-brand-primary/10 hover:shadow-xl hover:shadow-stone-200/50 transition-all cursor-pointer flex gap-8">
                        <div class="size-16 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">campaign</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[9px] font-extrabold uppercase tracking-widest text-brand-primary bg-brand-soft px-3 py-1 rounded-full">Berita</span>
                                <span class="text-[9px] font-bold text-stone-300 uppercase tracking-widest">{{ $item->tanggal_publish->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-xl font-extrabold text-brand-dark uppercase tracking-tight mb-2 group-hover:text-brand-primary transition-colors">{{ $item->judul }}</h4>
                            <p class="text-[11px] font-bold text-stone-400 uppercase leading-relaxed line-clamp-2">{{ strip_tags($item->isi_berita) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-stone-50 rounded-[2rem] p-12 text-center border-2 border-dashed border-stone-100">
                        <span class="material-symbols-outlined text-4xl text-stone-200 mb-4 block">inbox</span>
                        <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada pengumuman terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
