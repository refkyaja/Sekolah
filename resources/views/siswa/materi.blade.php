@extends('layouts.siswa')

@section('title', 'Materi KBM')

@section('content')
<div class="p-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Materi KBM @if($siswa->status_siswa === 'lulus') <span class="text-[10px] uppercase tracking-widest font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded ml-2 align-middle border border-slate-200 dark:border-slate-700">(ARSIP)</span> @endif</h1>
            <p class="text-slate-500 dark:text-slate-400">Daftar materi pembelajaran yang dibagikan oleh guru.</p>
        </div>
        
        <div class="flex items-center gap-2">
            <form action="{{ route('siswa.materi') }}" method="GET" class="flex items-center p-1 bg-slate-100 dark:bg-slate-800 rounded-xl w-fit">
                <button type="submit" name="kelompok" value="A" 
                        class="px-4 py-2 rounded-lg transition-all text-sm flex items-center gap-2 {{ $kelompok === 'A' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-medium' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    Kelompok A
                </button>
                <button type="submit" name="kelompok" value="B" 
                        class="px-4 py-2 rounded-lg transition-all text-sm flex items-center gap-2 {{ $kelompok === 'B' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-medium' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    Kelompok B
                </button>
            </form>
        </div>
    </div>

    <!-- Materi List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($materi as $item)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 flex flex-col h-full shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                            @php
                                $icon = match(strtolower($item->file_type)) {
                                    'pdf' => 'picture_as_pdf',
                                    'doc', 'docx' => 'description',
                                    'xls', 'xlsx' => 'table_chart',
                                    'jpg', 'jpeg', 'png' => 'image',
                                    default => 'draft'
                                };
                            @endphp
                            <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
                        </div>
                        <div>
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-bold text-slate-500 uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                {{ $item->mata_pelajaran }}
                            </span>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $item->tanggal_publish->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <h3 class="font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 min-h-[3rem]">{{ $item->judul_materi }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 line-clamp-3">
                    {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>

                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-medium uppercase truncate pr-4">
                        <i class="fas fa-user-circle mr-1"></i> {{ optional($item->guru)->nama ?? 'Guru' }}
                    </span>
                    
                    @if($item->file_path)
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="flex items-center gap-2 bg-slate-900 dark:bg-primary text-white text-xs font-bold py-2.5 px-4 rounded-xl hover:bg-primary transition-all download-btn">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center">
                <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl text-slate-300">library_books</span>
                </div>
                <h3 class="font-bold text-slate-800 dark:text-white">Materi Belum Tersedia</h3>
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-2">Belum ada materi pembelajaran yang dibagikan untuk kelompok ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $materi->appends(['kelompok' => $kelompok])->links() }}
    </div>
</div>
@endsection
