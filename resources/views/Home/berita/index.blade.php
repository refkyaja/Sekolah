@extends('layouts.home')

@section('title', 'Berita Sekolah - TK PGRI Harapan Bangsa 1')

@section('content')
<section class="hero-gradient pt-32 pb-16 md:pt-40 md:pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <p class="text-xs font-bold text-primary tracking-[0.3em] uppercase mb-4">Beranda / Informasi / Berita</p>
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight">Berita Sekolah</h1>
            <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                Semua kabar terbaru, pengumuman sekolah, dan update kegiatan resmi dari TK PGRI Harapan Bangsa 1.
            </p>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($beritas->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($beritas as $berita)
                    <article class="rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all bg-white flex flex-col">
                        <a href="{{ route('berita.show', $berita->slug) }}" class="block h-60 bg-slate-100 overflow-hidden">
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-5xl">newsmode</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-3">
                                {{ optional($berita->tanggal_publish)->translatedFormat('d M Y') }}
                            </p>
                            <h2 class="text-2xl font-bold text-slate-900 leading-tight mb-4">{{ $berita->judul }}</h2>
                            <p class="text-slate-600 leading-relaxed flex-1">{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 170) }}</p>
                            <a href="{{ route('berita.show', $berita->slug) }}" class="mt-6 inline-flex items-center gap-2 text-primary font-bold">
                                Baca selengkapnya
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $beritas->links() }}
            </div>
        @else
            <div class="rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 px-8 py-16 text-center">
                <h2 class="text-2xl font-bold text-slate-900">Belum ada berita yang dipublikasikan</h2>
                <p class="mt-3 text-slate-500">Saat sekolah mempublikasikan berita baru, daftar berita akan muncul di halaman ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
