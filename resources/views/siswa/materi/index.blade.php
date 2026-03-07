@extends('layouts.student')

@section('title', 'Materi KBM')
@section('header_title', 'Materi KBM')

@section('content')
<div class="space-y-12">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
        <div>
            <span class="text-[9px] font-extrabold uppercase tracking-[.3em] text-brand-primary mb-2 block">Akademik</span>
            <h1 class="text-4xl font-extrabold text-brand-dark uppercase tracking-tighter leading-none mb-4">Materi KBM</h1>
            <div class="flex items-center gap-3">
                <span class="px-4 py-1.5 bg-brand-soft text-brand-primary rounded-full text-[8px] font-extrabold uppercase tracking-widest border border-brand-primary/10">
                    Siswa: Kelompok {{ $siswa->kelompok }}
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-stone-200/30 border border-stone-100 mb-12">
        <form action="{{ route('siswa.materi.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-stone-300">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI MATERI..." 
                       class="w-full pl-16 pr-8 py-4 bg-stone-50 border-none rounded-2xl text-[10px] uppercase font-extrabold tracking-widest focus:ring-1 focus:ring-brand-primary/20 transition-all placeholder:text-stone-300">
            </div>
            
            <div class="flex flex-wrap gap-4">
                <select name="kelompok" onchange="this.form.submit()" 
                        class="px-8 py-4 bg-stone-50 border-none rounded-2xl text-[9px] uppercase font-extrabold tracking-widest focus:ring-1 focus:ring-brand-primary/20 transition-all cursor-pointer">
                    <option value="">Semua Kelompok</option>
                    @foreach($daftarKelompok as $klp)
                        <option value="{{ $klp }}" {{ $selectedKelompok == $klp ? 'selected' : '' }}>Kelompok {{ $klp }}</option>
                    @endforeach
                </select>

                <select name="mata_pelajaran" onchange="this.form.submit()" 
                        class="px-8 py-4 bg-stone-50 border-none rounded-2xl text-[9px] uppercase font-extrabold tracking-widest focus:ring-1 focus:ring-brand-primary/20 transition-all cursor-pointer">
                    <option value="">Semua Pelajaran</option>
                    @foreach($daftarMapel as $mapel)
                        <option value="{{ $mapel }}" {{ request('mata_pelajaran') == $mapel ? 'selected' : '' }}>{{ $mapel }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($materiKbm as $materi)
            @php
                $icon = match($materi->file_type) {
                    'PDF Document' => 'picture_as_pdf',
                    'PowerPoint' => 'present_to_all',
                    'Word Document' => 'description',
                    'Video' => 'videocam',
                    'Gambar' => 'image',
                    default => 'attach_file'
                };
                $brandIconClass = match($materi->file_type) {
                    'PDF Document' => 'bg-red-50 text-red-400',
                    'PowerPoint' => 'bg-amber-50 text-amber-500',
                    'Word Document' => 'bg-blue-50 text-blue-500',
                    'Video' => 'bg-fuchsia-50 text-fuchsia-500',
                    'Gambar' => 'bg-emerald-50 text-emerald-500',
                    default => 'bg-stone-50 text-stone-400'
                };
            @endphp
            <div class="group bg-white rounded-[2.5rem] p-10 shadow-sm border border-stone-100 hover:border-brand-primary/10 hover:shadow-2xl hover:shadow-stone-200/50 transition-all hover:-translate-y-2">
                <div class="flex items-start justify-between mb-8">
                    <div class="size-16 rounded-[1.5rem] {{ $brandIconClass }} flex items-center justify-center transition-transform group-hover:scale-110 duration-500">
                        <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
                    </div>
                    <div class="text-[9px] font-extrabold text-stone-300 uppercase tracking-[0.2em]">{{ $materi->tanggal_publish->translatedFormat('d M Y') }}</div>
                </div>
                
                <h3 class="text-xl font-extrabold text-brand-dark uppercase tracking-tight mb-3 line-clamp-2 leading-tight group-hover:text-brand-primary transition-colors">{{ $materi->judul_materi }}</h3>
                <p class="text-[10px] font-bold text-stone-400 uppercase leading-relaxed mb-8 line-clamp-2">{{ $materi->deskripsi ?? 'Tidak ada deskripsi materi.' }}</p>
                
                <div class="flex items-center gap-3 mb-10">
                    <span class="px-4 py-1.5 bg-stone-50 rounded-full text-[8px] font-extrabold text-stone-400 uppercase tracking-widest">{{ $materi->mata_pelajaran }}</span>
                    <span class="text-[8px] text-stone-300 font-extrabold uppercase tracking-widest">{{ $materi->file_size_formatted }}</span>
                </div>

                <a href="{{ route('siswa.materi.download', $materi) }}" 
                   class="w-full py-5 bg-brand-dark text-white rounded-[1.5rem] text-[10px] font-extrabold uppercase tracking-[0.2em] flex items-center justify-center gap-3 shadow-xl shadow-brand-dark/10 transition-all hover:bg-brand-primary active:scale-95">
                    <span class="material-symbols-outlined text-xl">download</span>
                    <span>Unduh Materi</span>
                </a>
            </div>
        @empty
            <div class="col-span-full py-32 flex flex-col items-center justify-center text-center">
                <div class="size-32 rounded-[3rem] bg-stone-50 flex items-center justify-center mb-8 border border-stone-100">
                    <span class="material-symbols-outlined text-5xl text-stone-200">folder_off</span>
                </div>
                <h4 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight mb-2">Belum Ada Materi</h4>
                <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada materi KBM yang diunggah untuk kelasmu.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $materiKbm->links() }}
    </div>
</div>
@endsection
