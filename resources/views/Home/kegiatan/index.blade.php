@extends('layouts.home-directory')

@section('title', 'Agenda Sekolah - TK PGRI Harapan Bangsa 1')
@section('back-url', route('informasi'))
@section('directory-eyebrow', 'Kegiatan')
@section('directory-title', 'Agenda Sekolah')

@section('directory-controls')
    <form method="GET" action="{{ route('kegiatan.index') }}" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_220px]">
        <label class="relative block">
            <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input type="search"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Cari kegiatan, lokasi, kategori..."
                   class="h-12 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
        </label>

        <label class="relative block">
            <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">filter_alt</span>
            <select name="sort"
                    onchange="this.form.submit()"
                    class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-white pl-12 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-primary focus:ring-4 focus:ring-primary/10">
                <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                <option value="terlama" @selected($sort === 'terlama')>Terlama</option>
                <option value="az" @selected($sort === 'az')>A - Z</option>
                <option value="za" @selected($sort === 'za')>Z - A</option>
            </select>
            <span class="material-symbols-outlined pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">expand_more</span>
        </label>
    </form>
@endsection

@section('content')
    <section class="py-8 md:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-home-animate="fade-up" class="mb-8 rounded-[2rem] bg-accent-purple p-6 shadow-sm md:p-8">
                <p class="max-w-3xl text-sm leading-relaxed text-slate-700 md:text-base">
                    Ringkasan kegiatan terbaru sekolah untuk membantu orang tua melihat aktivitas, agenda, dan momen pembelajaran yang sedang berjalan.
                </p>
            </div>

            @if($kegiatan->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" data-home-stagger>
                    @foreach($kegiatan as $item)
                        <article class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl">
                            <a href="{{ route('kegiatan.show', $item->slug) }}" class="block h-52 overflow-hidden bg-slate-100">
                                <img src="{{ $item->banner_url }}"
                                     alt="{{ $item->nama_kegiatan }}"
                                     class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            </a>
                            <div class="p-6">
                                <div class="mb-4 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-accent-blue px-3 py-1 text-xs font-bold text-primary">
                                        {{ optional($item->tanggal_mulai)->translatedFormat('d M Y') ?: 'Tanggal belum diatur' }}
                                    </span>
                                    @if($item->kategori)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            {{ $item->kategori }}
                                        </span>
                                    @endif
                                </div>
                                <h2 class="text-2xl font-bold leading-tight text-slate-900">{{ $item->nama_kegiatan }}</h2>
                                @if($item->lokasi)
                                    <p class="mt-3 text-sm font-medium text-slate-500">{{ $item->lokasi }}</p>
                                @endif
                                <p class="mt-4 text-sm leading-relaxed text-slate-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 150) ?: 'Detail kegiatan akan diperbarui oleh sekolah.' }}
                                </p>
                                <a href="{{ route('kegiatan.show', $item->slug) }}" class="mt-6 inline-flex items-center gap-2 text-primary font-bold">
                                    Buka detail
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $kegiatan->links() }}
                </div>
            @else
                <div data-home-animate="zoom-in" class="rounded-[2rem] border border-dashed border-slate-200 bg-white px-8 py-16 text-center shadow-sm">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-accent-purple text-primary">
                        <span class="material-symbols-outlined text-3xl">event_busy</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold text-slate-900">Belum ada agenda kegiatan</h2>
                    <p class="mt-3 text-slate-500">Kegiatan sekolah akan tampil di halaman ini setelah dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
