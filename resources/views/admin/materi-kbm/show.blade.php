@php
    $role = auth()->user()->role;
    $user = auth()->user();
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
    $canUpdateMateri = $user->canAccessModule('materi_kbm', 'update');
    $canDeleteMateri = $user->canAccessModule('materi_kbm', 'delete');
@endphp

@extends($layout)

@section('title', 'Detail Materi KBM')
@section('breadcrumb', 'Materi KBM / Detail')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-3 mb-6">
            <div class="min-w-0">
                @php
                    $mapelColors = [
                        'Baca'        => 'bg-purple-100 text-purple-700',
                        'Tulis'       => 'bg-blue-100   text-blue-700',
                        'Menghitung'  => 'bg-emerald-100 text-emerald-700',
                    ];
                    $colorClass = $mapelColors[$materiKbm->mata_pelajaran] ?? 'bg-slate-100 text-slate-700';
                @endphp
                <span class="inline-flex px-3 py-1 {{ $colorClass }} text-[11px] font-bold rounded-full uppercase mb-3">
                    {{ $materiKbm->mata_pelajaran }}
                </span>
                <h2 class="text-lg sm:text-xl font-bold text-slate-800 leading-snug">{{ $materiKbm->judul_materi }}</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $materiKbm->kelas }}</p>
            </div>
            <div class="flex gap-1.5 flex-shrink-0">
                @if($canUpdateMateri)
                <a href="{{ route($routePrefix . '.materi-kbm.edit', $materiKbm) }}"
                    class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                    <span class="material-symbols-outlined">edit</span>
                </a>
                @endif
                @if($canDeleteMateri)
                <form method="POST" action="{{ route($routePrefix . '.materi-kbm.destroy', $materiKbm) }}"
                    onsubmit="return confirm('Yakin ingin menghapus materi ini?')" class="no-loading">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Publish</p>
                <p class="text-sm font-bold text-slate-700">{{ $materiKbm->tanggal_publish->translatedFormat('d F Y') }}</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kelompok</p>
                <p class="text-sm font-bold text-slate-700">{{ $materiKbm->kelas }}</p>
            </div>
        </div>

        {{-- Deskripsi --}}
        @if($materiKbm->deskripsi)
        <div class="mb-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi</p>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $materiKbm->deskripsi }}</p>
        </div>
        @endif

        {{-- File --}}
        @if($materiKbm->file_path)
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary text-2xl">description</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ $materiKbm->file_name }}</p>
                <p class="text-xs text-slate-500">{{ $materiKbm->file_type }} • {{ $materiKbm->file_size_formatted }}</p>
            </div>
            <a href="{{ route($routePrefix . '.materi-kbm.download', $materiKbm) }}"
                class="flex items-center justify-center gap-1.5 px-4 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-purple-700 transition-all flex-shrink-0 w-full sm:w-auto">
                <span class="material-symbols-outlined text-lg">download</span>
                Download
            </a>
        </div>
        @else
        <div class="bg-slate-50 rounded-xl p-4 text-center mb-6">
            <span class="material-symbols-outlined text-3xl text-slate-300 block mb-1">folder_off</span>
            <p class="text-sm text-slate-400">Tidak ada file terlampir</p>
        </div>
        @endif

        {{-- Meta --}}
        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400">
            <span>Dibuat: {{ $materiKbm->created_at->translatedFormat('d F Y, H:i') }}</span>
            @if($materiKbm->updated_at != $materiKbm->created_at)
            <span>Diperbarui: {{ $materiKbm->updated_at->translatedFormat('d F Y, H:i') }}</span>
            @endif
        </div>

        {{-- Back --}}
        <div class="mt-6">
            <a href="{{ route($routePrefix . '.materi-kbm.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-primary transition-colors font-medium">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Daftar Materi
            </a>
        </div>
    </div>
</div>
@endsection
