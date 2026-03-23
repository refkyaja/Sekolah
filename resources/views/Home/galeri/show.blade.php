@extends('layouts.home')

@section('title', $galeri->judul . ' - Galeri Sekolah')

@section('content')
<section class="hero-gradient pt-32 pb-12 md:pt-40 md:pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 text-primary font-bold mb-6">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke galeri
        </a>
        <p class="text-xs font-bold text-primary tracking-[0.3em] uppercase mb-4">Beranda / Informasi / Galeri</p>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">{{ $galeri->judul }}</h1>
        <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-slate-500">
            @if($galeri->tanggal)
                <span>{{ $galeri->tanggal->translatedFormat('d F Y') }}</span>
            @endif
            @if($galeri->kategori)
                <span>&bull;</span>
                <span>{{ $galeri->kategori }}</span>
            @endif
            @if($galeri->lokasi)
                <span>&bull;</span>
                <span>{{ $galeri->lokasi }}</span>
            @endif
        </div>
        @if($galeri->deskripsi)
            <p class="mt-6 max-w-3xl text-lg text-slate-600 leading-relaxed">{{ $galeri->deskripsi }}</p>
        @endif
    </div>
</section>

<section class="pb-16 md:pb-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($galeri->gambar->isNotEmpty())
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($galeri->gambar as $gambar)
                    <figure class="overflow-hidden rounded-[2rem] bg-slate-100 shadow-sm">
                        <img src="{{ $gambar->url }}" alt="{{ $gambar->caption ?: $galeri->judul }}" class="w-full h-72 object-cover hover:scale-105 transition-transform duration-500">
                        @if($gambar->caption)
                            <figcaption class="px-5 py-4 text-sm text-slate-600 bg-white border-t border-slate-100">{{ $gambar->caption }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        @else
            <div class="rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 px-8 py-16 text-center">
                <h2 class="text-2xl font-bold text-slate-900">Album ini belum memiliki foto</h2>
                <p class="mt-3 text-slate-500">Konten galeri akan tampil di sini setelah gambar diunggah.</p>
            </div>
        @endif

        @if($related->count() > 0)
            <div class="mt-16">
                <div class="flex items-center justify-between gap-6 mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-900">Album Lainnya</h2>
                    <a href="{{ route('galeri.index') }}" class="hidden md:inline-flex items-center gap-2 text-primary font-bold">
                        Lihat semua album
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach($related as $item)
                        <article class="rounded-[2rem] overflow-hidden border border-slate-100 bg-slate-50 shadow-sm">
                            <a href="{{ route('galeri.show', $item->slug) }}" class="block h-52 overflow-hidden">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </a>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-2">{{ optional($item->tanggal)->translatedFormat('d M Y') }}</p>
                                <h3 class="font-bold text-slate-900 leading-tight">{{ $item->judul }}</h3>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
