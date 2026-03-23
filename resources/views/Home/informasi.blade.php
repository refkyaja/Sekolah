@extends('layouts.home')

@section('title', 'Informasi - TK PGRI Harapan Bangsa 1')

@section('content')
<section class="px-4 md:px-10 py-6">
    <div data-home-animate="zoom-in" class="relative h-[300px] md:h-[400px] w-full overflow-hidden rounded-xl md:rounded-3xl shadow-lg mt-8 md:mt-16">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=1600&auto=format&fit=crop');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-8 md:p-12">
            <nav data-home-animate="fade-up" class="flex gap-2 text-white/80 text-sm mb-4">
                <span><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></span>
                <span>/</span>
                <span class="text-white font-medium">Informasi</span>
            </nav>
            <h1 data-home-animate="fade-up" class="text-white text-4xl md:text-5xl font-bold tracking-tight">Pusat Informasi Sekolah</h1>
            <p data-home-animate="fade-up" class="mt-4 text-white/85 text-base md:text-lg leading-relaxed max-w-2xl">
                Temukan dokumentasi galeri dan ringkasan kegiatan sekolah dalam satu halaman yang mudah dijelajahi.
            </p>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-2" data-home-stagger>
            <a href="{{ route('galeri.index') }}" class="group rounded-[2rem] bg-accent-yellow p-8 md:p-10 shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold tracking-[0.3em] uppercase text-slate-700 mb-3">Galeri</p>
                        <h2 class="text-3xl font-extrabold text-slate-900">Halaman Galeri</h2>
                        <p class="mt-4 text-slate-700 leading-relaxed">Dokumentasi momen belajar, kegiatan tematik, dan suasana sekolah dalam format visual.</p>
                    </div>
                    <span class="material-symbols-outlined text-4xl text-slate-700 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>

            <a href="{{ route('kegiatan.index') }}" class="group rounded-[2rem] bg-accent-purple p-8 md:p-10 shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold tracking-[0.3em] uppercase text-primary mb-3">Kegiatan</p>
                        <h2 class="text-3xl font-extrabold text-slate-900">Agenda Sekolah</h2>
                        <p class="mt-4 text-slate-700 leading-relaxed">Ringkasan kegiatan terbaru sekolah untuk membantu orang tua melihat aktivitas dan agenda yang sedang berjalan.</p>
                    </div>
                    <span class="material-symbols-outlined text-4xl text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-6 mb-10" data-home-animate="fade-right">
            <div>
                <p class="text-xs font-bold text-primary tracking-[0.3em] uppercase mb-3">Dokumentasi</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Galeri Kegiatan</h2>
            </div>
            <a href="{{ route('galeri.index') }}" class="hidden md:inline-flex items-center gap-2 text-primary font-bold">
                Lihat semua
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" data-home-stagger>
            @forelse($galeri as $album)
                <article class="rounded-[2rem] overflow-hidden bg-slate-50 border border-slate-100 shadow-sm hover:shadow-xl transition-all">
                    <a href="{{ route('galeri.show', $album->slug) }}" class="block h-64 overflow-hidden bg-slate-100">
                        <img src="{{ $album->thumbnail_url }}" alt="{{ $album->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-3">
                            {{ optional($album->tanggal)->translatedFormat('d M Y') }}{{ $album->kategori ? ' / ' . $album->kategori : '' }}
                        </p>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $album->judul }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($album->deskripsi), 120) ?: 'Lihat dokumentasi kegiatan sekolah pada album ini.' }}</p>
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 xl:col-span-3 rounded-[2rem] bg-slate-50 border border-dashed border-slate-200 p-10 text-center">
                    <h3 class="text-xl font-bold text-slate-800">Galeri belum tersedia</h3>
                    <p class="mt-2 text-slate-500">Album kegiatan sekolah akan tampil di sini setelah dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-slate-50" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10" data-home-animate="fade-right">
            <p class="text-xs font-bold text-primary tracking-[0.3em] uppercase mb-3">Agenda</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Kegiatan Sekolah</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" data-home-stagger>
            @forelse($kegiatan as $item)
                <article class="rounded-[2rem] bg-white p-6 shadow-sm border border-slate-100">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-3">
                        {{ optional($item->tanggal_mulai)->translatedFormat('d M Y') }}
                    </p>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $item->nama_kegiatan }}</h3>
                    <p class="text-slate-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 140) ?: 'Detail kegiatan akan diperbarui oleh sekolah.' }}</p>
                    <a href="{{ route('kegiatan.show', $item->slug) }}" class="mt-5 inline-flex items-center gap-2 text-primary font-bold">
                        Buka detail
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </article>
            @empty
                <div class="md:col-span-2 xl:col-span-3 rounded-[2rem] bg-white border border-dashed border-slate-200 p-10 text-center">
                    <h3 class="text-xl font-bold text-slate-800">Belum ada agenda kegiatan</h3>
                    <p class="mt-2 text-slate-500">Informasi kegiatan sekolah akan ditampilkan di sini saat tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
