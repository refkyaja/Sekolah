@extends('layouts.home-directory')

@section('title', 'Galeri Sekolah - TK PGRI Harapan Bangsa 1')
@section('directory-eyebrow', 'Galeri')
@section('directory-title', 'Halaman Galeri')

@section('directory-controls')
    <form method="GET" action="{{ route('galeri.index') }}" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_220px]">
        <label class="relative block">
            <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input type="search"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Cari album, kategori, lokasi..."
                   class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
        </label>

        <label class="relative block">
            <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">filter_alt</span>
            <select name="sort"
                    onchange="this.form.submit()"
                    class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-white pl-12 pr-12 text-sm font-medium text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10 cursor-pointer">
                <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                <option value="terlama" @selected($sort === 'terlama')>Terlama</option>
                <option value="az" @selected($sort === 'az')>A - Z</option>
                <option value="za" @selected($sort === 'za')>Z - A</option>
            </select>
            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center text-slate-400 bg-white">
                <span class="material-symbols-outlined text-xl">expand_more</span>
            </div>
        </label>
    </form>
@endsection

@section('content')
<section class="py-8 md:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-home-animate="fade-up" class="mb-8 rounded-[2rem] bg-accent-yellow p-6 shadow-sm md:p-8">
            <p class="max-w-3xl text-sm leading-relaxed text-slate-700 md:text-base">
                Dokumentasi kegiatan belajar, momen kelompok, dan aktivitas sekolah yang sudah dipublikasikan dalam format visual yang mudah dijelajahi.
            </p>
        </div>

        @if($galeri->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" data-home-stagger>
                @foreach($galeri as $album)
                    <article class="rounded-[2rem] overflow-hidden border border-slate-100 bg-white shadow-sm hover:shadow-xl transition-all">
                        <a href="{{ route('galeri.show', $album->slug) }}" class="block h-72 overflow-hidden bg-slate-100">
                            <img src="{{ $album->thumbnail_url }}" alt="{{ $album->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="p-6">
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
                                    {{ optional($album->tanggal)->translatedFormat('d M Y') }}
                                </p>
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-accent-blue text-primary">
                                    {{ $album->jumlah_gambar }} Foto
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 leading-tight mb-3">{{ $album->judul }}</h2>
                            <p class="text-slate-600 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($album->deskripsi), 120) ?: 'Album kegiatan sekolah yang telah dipublikasikan.' }}</p>
                            <a href="{{ route('galeri.show', $album->slug) }}" class="mt-6 inline-flex items-center gap-2 text-primary font-bold">
                                Buka album
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $galeri->links() }}
            </div>
        @else
            <div data-home-animate="zoom-in" class="rounded-[2rem] border border-dashed border-slate-200 bg-white px-8 py-16 text-center shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900">Belum ada album yang dipublikasikan</h2>
                <p class="mt-3 text-slate-500">Galeri sekolah akan tampil di halaman ini setelah admin menambahkan album baru.</p>
            </div>
        @endif
    </div>
</section>
@endsection
