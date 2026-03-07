@extends('layouts.frontend')

@section('title', 'Informasi Sekolah - Harapan Bangsa 1')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-brand-primary/5 py-16 lg:py-24">
    <div class="container mx-auto px-4 lg:px-10">
        <div class="flex flex-col items-center text-center max-w-3xl mx-auto">
            <span class="mb-4 inline-block rounded-full bg-brand-primary/10 px-4 py-1 text-[10px] font-bold uppercase tracking-wider text-brand-primary">Kabar Sekolah</span>
            <h1 class="mb-6 text-5xl font-extrabold tracking-tight text-brand-dark lg:text-7xl uppercase">
                Informasi<br>Sekolah
            </h1>
            <p class="text-sm font-medium leading-relaxed text-stone-500 max-w-lg">
                Temukan berbagai kegiatan seru, pengumuman penting, dan dokumentasi keceriaan belajar mengajar di lingkungan Harapan Bangsa 1.
            </p>
        </div>
    </div>
    <!-- Abstract shapes -->
    <div class="absolute -left-20 top-0 h-64 w-64 rounded-full bg-brand-primary/10 blur-3xl opacity-50"></div>
    <div class="absolute -right-20 bottom-0 h-64 w-64 rounded-full bg-brand-primary/5 blur-3xl opacity-50"></div>
</section>

<!-- Kegiatan Sekolah -->
<section class="py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-4 lg:px-10">
        <div class="mb-16 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end border-b border-stone-100 pb-8">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-400 mb-2 block">Agenda Terkini</span>
                <h2 class="text-4xl font-extrabold tracking-tight text-brand-dark uppercase">Kegiatan Terbaru</h2>
            </div>
            <a href="{{ route('akademik.kegiatan') }}" class="flex items-center gap-2 text-[10px] font-extrabold text-brand-primary uppercase tracking-widest hover:underline transition-all group">
                Lihat Semua Kegiatan 
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
            @forelse($kegiatan as $item)
            <div class="group">
                <div class="relative aspect-[4/5] w-full overflow-hidden rounded-[2rem] bg-stone-100 mb-8 shadow-sm">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" 
                         src="{{ $item->banner_url }}" 
                         alt="{{ $item->nama_kegiatan }}">
                    <div class="absolute left-6 top-6">
                        <span class="rounded-full bg-white/90 backdrop-blur-md px-4 py-2 text-[9px] font-bold text-brand-dark uppercase tracking-widest shadow-sm">
                            {{ $item->tanggal_mulai->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <h3 class="mb-4 text-2xl font-extrabold text-brand-dark uppercase tracking-tighter group-hover:text-brand-primary transition-colors">
                    {{ $item->nama_kegiatan }}
                </h3>
                <p class="mb-6 text-[11px] font-bold leading-relaxed text-stone-400 uppercase tracking-tight">
                    {{ Str::limit(strip_tags($item->deskripsi), 100) }}
                </p>
                <a href="#" class="text-[10px] font-extrabold text-brand-primary uppercase tracking-[0.2em] group-hover:underline">Baca Selengkapnya</a>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <span class="material-symbols-outlined text-stone-200 text-6xl mb-4">event_busy</span>
                <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada kegiatan terbaru</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Galeri Foto -->
<section class="bg-brand-soft py-24 lg:py-32">
    <div class="container mx-auto px-4 lg:px-10">
        <div class="text-center max-w-2xl mx-auto mb-20">
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4 block">Visual Stories</span>
            <h2 class="mb-6 text-5xl font-extrabold tracking-tight text-brand-dark uppercase">Galeri Foto</h2>
            <p class="text-[11px] font-bold text-stone-400 uppercase tracking-widest leading-relaxed">Momen-momen berharga saat sikecil bereksplorasi dan tumbuh kembang bersama teman-teman.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($galeri as $index => $item)
                @php
                    $isLarge = ($index === 1 || $index === 5);
                    $colSpan = ($index === 5) ? 'md:col-span-2' : '';
                    $rowSpan = ($index === 1) ? 'md:row-span-2' : '';
                @endphp
                <div class="aspect-square overflow-hidden rounded-[2.5rem] bg-white shadow-xl shadow-stone-200/50 {{ $colSpan }} {{ $rowSpan }} group relative">
                    <img class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000" 
                         src="{{ $item->thumbnail_url }}" 
                         alt="{{ $item->judul }}">
                    <div class="absolute inset-0 bg-brand-dark/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center backdrop-blur-[2px]">
                        <div class="text-center p-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="text-[8px] font-bold text-white uppercase tracking-[0.3em] mb-2 block opacity-80">{{ $item->kategori }}</span>
                            <h4 class="text-sm font-extrabold text-white uppercase tracking-tighter leading-tight">{{ $item->judul }}</h4>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <span class="material-symbols-outlined text-stone-200 text-6xl mb-4">photo_library</span>
                    <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada foto galeri</p>
                </div>
            @endforelse
        </div>

        <div class="mt-20 text-center">
            <a href="{{ route('galeri.index') }}" class="bg-brand-dark text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-2xl shadow-brand-dark/20">
                Lihat Galeri Lengkap
            </a>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="py-24 lg:py-32 bg-white">
    <div class="container mx-auto px-4 lg:px-10">
        <div class="mx-auto max-w-5xl overflow-hidden rounded-[3.5rem] bg-brand-dark shadow-2xl relative group">
            <div class="relative aspect-video flex items-center justify-center overflow-hidden">
                <img class="absolute inset-0 h-full w-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-1000" 
                     src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80" 
                     alt="School Life Preview">
                <div class="relative z-10 flex flex-col items-center text-center px-6">
                    <button class="mb-8 flex h-24 w-24 items-center justify-center rounded-full bg-brand-primary text-white shadow-2xl shadow-brand-primary/40 hover:scale-110 active:scale-95 transition-all duration-500">
                        <span class="material-symbols-outlined text-5xl leading-none">play_arrow</span>
                    </button>
                    <span class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4 block">Eksklusif</span>
                    <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-white uppercase">Satu Hari di Sekolah</h2>
                    <p class="text-white/60 text-[11px] font-bold uppercase tracking-widest max-w-sm">Lihat keseharian anak-anak belajar dan bermain dengan ceria di Harapan Bangsa 1</p>
                </div>
            </div>
            <!-- Decorative corner -->
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-brand-primary/10 rounded-tr-[4rem] group-hover:scale-125 transition-transform duration-700"></div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
    }
</style>
@endpush
