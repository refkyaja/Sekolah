@extends('layouts.student')

@section('title', 'Materi KBM')
@section('header_title', 'Materi KBM')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Search & Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800">
        <form action="{{ route('siswa.materi.index') }}" method="GET" class="flex-1 flex flex-wrap gap-2">
            <div class="relative flex-1 min-w-[200px]">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi atau mata pelajaran..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
            </div>
            
            <div class="flex gap-2 w-full sm:w-auto">
                <select name="kelompok" onchange="this.form.submit()" 
                        class="flex-1 sm:flex-none px-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium">
                    <option value="">Semua Kelompok</option>
                    @foreach($daftarKelompok as $klp)
                        <option value="{{ $klp }}" {{ $selectedKelompok == $klp ? 'selected' : '' }}>Kelompok {{ $klp }}</option>
                    @endforeach
                </select>

                <select name="mata_pelajaran" onchange="this.form.submit()" 
                        class="flex-1 sm:flex-none px-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all font-medium">
                    <option value="">Semua Pelajaran</option>
                    @foreach($daftarMapel as $mapel)
                        <option value="{{ $mapel }}" {{ request('mata_pelajaran') == $mapel ? 'selected' : '' }}>{{ $mapel }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <div class="flex items-center gap-2 px-3 py-1 bg-primary/10 text-primary rounded-lg text-xs font-bold uppercase tracking-wider h-fit">
            <span class="material-symbols-outlined text-[16px]">person</span>
            <span>Profil: {{ $siswa->kelompok }}</span>
        </div>
    </div>

    <!-- Materials Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                $iconColor = match($materi->file_type) {
                    'PDF Document' => 'text-red-500',
                    'PowerPoint' => 'text-orange-500',
                    'Word Document' => 'text-blue-500',
                    'Video' => 'text-purple-500',
                    'Gambar' => 'text-emerald-500',
                    default => 'text-slate-500'
                };
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-xl hover:-translate-y-1 transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center {{ $iconColor }}">
                        <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">{{ $icon }}</span>
                    </div>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $materi->tanggal_publish->translatedFormat('d M Y') }}</div>
                </div>
                
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 leading-snug group-hover:text-primary transition-colors">{{ $materi->judul_materi }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 line-clamp-2">{{ $materi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                
                <div class="flex items-center gap-2 mb-6">
                    <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase">{{ $materi->mata_pelajaran }}</span>
                    <span class="text-[10px] text-slate-400 font-medium">{{ $materi->file_size_formatted }}</span>
                </div>

                <a href="{{ route('siswa.materi.download', $materi) }}" 
                   class="w-full py-3 bg-slate-900 dark:bg-slate-800 group-hover:bg-primary text-white rounded-2xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-slate-200 dark:shadow-none transition-all">
                    <span class="material-symbols-outlined text-lg">download</span>
                    <span>Unduh Materi</span>
                </a>
            </div>
        @empty
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-400 text-center">
                <div class="size-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl">folder_off</span>
                </div>
                <h4 class="text-lg font-bold">Belum Ada Materi</h4>
                <p class="text-sm">Belum ada materi KBM yang diunggah untuk kelasmu.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $materiKbm->links() }}
    </div>
</div>
@endsection
