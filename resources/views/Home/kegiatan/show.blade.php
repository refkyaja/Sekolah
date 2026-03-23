@extends('layouts.home-directory')

@section('title', $kegiatan->nama_kegiatan . ' - Agenda Sekolah')
@section('back-url', route('kegiatan.index'))
@section('directory-eyebrow', 'Kegiatan')
@section('directory-title', 'Detail Agenda')

@section('content')
    <section class="py-8 md:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-home-animate="zoom-in" class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
                <div class="h-[260px] md:h-[420px] overflow-hidden bg-slate-100">
                    <img src="{{ $kegiatan->banner_url }}"
                         alt="{{ $kegiatan->nama_kegiatan }}"
                         class="h-full w-full object-cover">
                </div>

                <div class="p-6 md:p-10">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-accent-blue px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-primary">
                            {{ optional($kegiatan->tanggal_mulai)->translatedFormat('d F Y') ?: 'Tanggal belum diatur' }}
                        </span>
                        @if($kegiatan->kategori)
                            <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-600">
                                {{ $kegiatan->kategori }}
                            </span>
                        @endif
                        @if($kegiatan->lokasi)
                            <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-600">
                                {{ $kegiatan->lokasi }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-6 text-3xl font-extrabold leading-tight text-slate-900 md:text-5xl">{{ $kegiatan->nama_kegiatan }}</h1>

                    @if($kegiatan->waktu_mulai || $kegiatan->waktu_selesai || $kegiatan->tanggal_selesai)
                        <div class="mt-6 grid gap-4 md:grid-cols-3">
                            @if($kegiatan->tanggal_selesai)
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Selesai</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-700">{{ $kegiatan->tanggal_selesai->translatedFormat('d F Y') }}</p>
                                </div>
                            @endif
                            @if($kegiatan->waktu_mulai)
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Mulai</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-700">{{ $kegiatan->waktu_mulai->format('H:i') }}</p>
                                </div>
                            @endif
                            @if($kegiatan->waktu_selesai)
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Selesai Jam</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-700">{{ $kegiatan->waktu_selesai->format('H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="prose prose-slate mt-8 max-w-none leading-relaxed">
                        {!! nl2br(e($kegiatan->deskripsi ?: 'Detail kegiatan akan diperbarui oleh sekolah.')) !!}
                    </div>
                </div>
            </div>

            @if($related->isNotEmpty())
                <div class="mt-12">
                    <div class="mb-6 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.3em] text-primary">Lainnya</p>
                            <h2 class="mt-2 text-2xl font-extrabold text-slate-900">Agenda Terkait</h2>
                        </div>
                        <a href="{{ route('kegiatan.index') }}" class="hidden md:inline-flex items-center gap-2 text-primary font-bold">
                            Kembali ke daftar
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                        @foreach($related as $item)
                            <article class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
                                <a href="{{ route('kegiatan.show', $item->slug) }}" class="block h-48 overflow-hidden bg-slate-100">
                                    <img src="{{ $item->banner_url }}" alt="{{ $item->nama_kegiatan }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                                </a>
                                <div class="p-5">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ optional($item->tanggal_mulai)->translatedFormat('d M Y') }}</p>
                                    <h3 class="mt-2 font-bold leading-tight text-slate-900">{{ $item->nama_kegiatan }}</h3>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
