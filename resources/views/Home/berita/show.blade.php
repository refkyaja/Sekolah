@extends('layouts.home')

@section('title', $berita->judul . ' - Berita Sekolah')

@section('content')
<section class="hero-gradient pt-32 pb-12 md:pt-40 md:pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-primary font-bold mb-6">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke berita
        </a>
        <p class="text-xs font-bold text-primary tracking-[0.3em] uppercase mb-4">Beranda / Informasi / Berita</p>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">{{ $berita->judul }}</h1>
        <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-slate-500">
            <span>{{ optional($berita->tanggal_publish)->translatedFormat('d F Y') }}</span>
            @if($berita->penulis)
                <span>&bull;</span>
                <span>{{ $berita->penulis }}</span>
            @endif
        </div>
    </div>
</section>

<section class="pb-16 md:pb-24 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($berita->gambar)
            <div class="overflow-hidden rounded-[2rem] shadow-xl mb-10">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-[260px] md:h-[480px] object-cover">
            </div>
        @endif

        <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px]">
            <article class="prose prose-slate max-w-none prose-headings:font-extrabold prose-a:text-primary prose-img:rounded-2xl">
                {!! $berita->isi_berita !!}
            </article>

            <aside class="space-y-8">
                @if($beritaTerbaru->count() > 0)
                    <div class="rounded-[2rem] bg-slate-50 p-6 border border-slate-100">
                        <h2 class="text-xl font-extrabold text-slate-900 mb-5">Berita Terbaru</h2>
                        <div class="space-y-4">
                            @foreach($beritaTerbaru as $item)
                                <a href="{{ route('berita.show', $item->slug) }}" class="block group">
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-1">{{ optional($item->tanggal_publish)->translatedFormat('d M Y') }}</p>
                                    <h3 class="font-bold text-slate-800 group-hover:text-primary transition-colors">{{ $item->judul }}</h3>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($beritaRekomendasi->count() > 0)
                    <div class="rounded-[2rem] bg-accent-blue p-6 border border-sky-100">
                        <h2 class="text-xl font-extrabold text-slate-900 mb-5">Rekomendasi</h2>
                        <div class="space-y-4">
                            @foreach($beritaRekomendasi as $item)
                                <a href="{{ route('berita.show', $item->slug) }}" class="block group">
                                    <h3 class="font-bold text-slate-800 group-hover:text-primary transition-colors">{{ $item->judul }}</h3>
                                    <p class="mt-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 80) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>

        @if($previous_berita || $next_berita)
            <div class="mt-14 grid gap-4 md:grid-cols-2">
                @if($previous_berita)
                    <a href="{{ route('berita.show', $previous_berita->slug) }}" class="rounded-[2rem] border border-slate-100 bg-slate-50 p-6 hover:shadow-lg transition-all">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Artikel Sebelumnya</p>
                        <h3 class="font-bold text-slate-900">{{ $previous_berita->judul }}</h3>
                    </a>
                @endif
                @if($next_berita)
                    <a href="{{ route('berita.show', $next_berita->slug) }}" class="rounded-[2rem] border border-slate-100 bg-slate-50 p-6 hover:shadow-lg transition-all">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-2">Artikel Berikutnya</p>
                        <h3 class="font-bold text-slate-900">{{ $next_berita->judul }}</h3>
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
