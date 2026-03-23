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
    $canCreateMateri = $user->canAccessModule('materi_kbm', 'create');
    $canUpdateMateri = $user->canAccessModule('materi_kbm', 'update');
    $canDeleteMateri = $user->canAccessModule('materi_kbm', 'delete');
@endphp

@extends($layout)

@section('title', 'Materi KBM')
@section('breadcrumb', 'Akademik / Management Materi')

@section('content')

{{-- Filter & Tombol Tambah --}}
<form method="GET" action="{{ route($routePrefix . '.materi-kbm.index') }}" id="filterForm">
    <div class="flex flex-col gap-3 mb-6">
        {{-- Row 1: Search full-width --}}
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none">search</span>
            <input class="w-full pl-11 pr-4 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm shadow-sm"
                placeholder="Cari judul materi..."
                type="text"
                name="search"
                value="{{ request('search') }}"
                onchange="document.getElementById('filterForm').submit()"/>
        </div>

        {{-- Row 2: Filters + Tambah --}}
        <div class="flex flex-wrap gap-3 items-center">
            <select name="mata_pelajaran"
                class="flex-1 min-w-[140px] pl-4 pr-8 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm shadow-sm appearance-none"
                onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Pelajaran</option>
                @foreach($daftarMapel as $mapel)
                    <option value="{{ $mapel }}" {{ request('mata_pelajaran') == $mapel ? 'selected' : '' }}>{{ $mapel }}</option>
                @endforeach
            </select>

            <select name="kelas"
                class="flex-1 min-w-[130px] pl-4 pr-8 py-2.5 bg-white border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm shadow-sm appearance-none"
                onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Kelompok</option>
                @foreach($daftarKelas as $kelas)
                    <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                @endforeach
            </select>

            @if($canCreateMateri)
            <a href="{{ route($routePrefix . '.materi-kbm.create') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition-all shadow-lg shadow-primary/20 whitespace-nowrap flex-shrink-0">
                <span class="material-symbols-outlined text-xl">add</span>
                <span class="hidden sm:inline">Tambah Materi</span>
                <span class="sm:hidden">Tambah</span>
            </a>
            @endif
        </div>
    </div>
</form>

{{-- ===== DESKTOP TABLE ===== --}}
<div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-14">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Judul Materi</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kelompok</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Publish</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($materiKbm as $i => $materi)
                @php
                    $mapelColors = [
                        'Baca'        => 'bg-purple-100 text-purple-700',
                        'Tulis'       => 'bg-blue-100   text-blue-700',
                        'Menghitung'  => 'bg-emerald-100 text-emerald-700',
                    ];
                    $colorClass = $mapelColors[$materi->mata_pelajaran] ?? 'bg-slate-100 text-slate-700';
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                        {{ str_pad($materiKbm->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-3 py-1 {{ $colorClass }} text-[11px] font-bold rounded-full uppercase">
                            {{ $materi->mata_pelajaran }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-800">{{ $materi->judul_materi }}</p>
                        @if($materi->file_name)
                            <p class="text-[10px] text-slate-400">{{ $materi->file_type }} • {{ $materi->file_size_formatted }}</p>
                        @else
                            <p class="text-[10px] text-slate-400">Tidak ada file</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $materi->kelas }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $materi->tanggal_publish->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route($routePrefix . '.materi-kbm.show', $materi) }}"
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            @if($canUpdateMateri)
                            <a href="{{ route($routePrefix . '.materi-kbm.edit', $materi) }}"
                                class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            @endif
                            @if($canDeleteMateri)
                            <form method="POST" action="{{ route($routePrefix . '.materi-kbm.destroy', $materi) }}"
                                onsubmit="return confirm('Yakin ingin menghapus materi ini?')" class="inline no-loading">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                            @endif
                            @if($materi->file_path)
                            <a href="{{ route($routePrefix . '.materi-kbm.download', $materi) }}"
                                class="p-2 text-primary hover:bg-purple-50 rounded-lg transition-colors" title="Download">
                                <span class="material-symbols-outlined text-lg">download</span>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-5xl text-slate-300">auto_stories</span>
                            <p class="text-slate-400 font-medium">Belum ada materi KBM</p>
                            @if($canCreateMateri)
                            <a href="{{ route($routePrefix . '.materi-kbm.create') }}"
                                class="mt-2 px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-purple-700 transition-all">
                                Tambah Materi Pertama
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('admin.materi-kbm._pagination')
</div>

{{-- ===== MOBILE CARDS ===== --}}
<div class="md:hidden space-y-3">
    @forelse($materiKbm as $materi)
    @php
        $mapelColors = [
            'Baca'        => 'bg-purple-100 text-purple-700',
            'Tulis'       => 'bg-blue-100   text-blue-700',
            'Menghitung'  => 'bg-emerald-100 text-emerald-700',
        ];
        $colorClass = $mapelColors[$materi->mata_pelajaran] ?? 'bg-slate-100 text-slate-700';
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="flex-1 min-w-0">
                <span class="inline-flex px-2.5 py-0.5 {{ $colorClass }} text-[10px] font-bold rounded-full uppercase mb-1.5">
                    {{ $materi->mata_pelajaran }}
                </span>
                <h3 class="text-sm font-bold text-slate-800 leading-snug">{{ $materi->judul_materi }}</h3>
            </div>
            {{-- Action dropdown for mobile --}}
            <div class="flex gap-1 flex-shrink-0">
                @if($canUpdateMateri)
                <a href="{{ route($routePrefix . '.materi-kbm.edit', $materi) }}"
                    class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                    <span class="material-symbols-outlined text-base">edit</span>
                </a>
                @endif
                @if($canDeleteMateri)
                <form method="POST" action="{{ route($routePrefix . '.materi-kbm.destroy', $materi) }}"
                    onsubmit="return confirm('Yakin ingin menghapus materi ini?')" class="inline no-loading">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 gap-x-4 gap-y-1.5 text-xs text-slate-500 mb-3">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-slate-300">group</span>
                {{ $materi->kelas }}
            </div>
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-slate-300">calendar_today</span>
                {{ $materi->tanggal_publish->format('d M Y') }}
            </div>
            @if($materi->file_name)
            <div class="flex items-center gap-1.5 col-span-2">
                <span class="material-symbols-outlined text-sm text-slate-300">description</span>
                <span class="truncate">{{ $materi->file_type }} • {{ $materi->file_size_formatted }}</span>
            </div>
            @endif
        </div>

        <div class="flex gap-2 pt-3 border-t border-slate-50">
            <a href="{{ route($routePrefix . '.materi-kbm.show', $materi) }}"
                class="flex-1 flex items-center justify-center gap-1.5 py-2 text-blue-600 hover:bg-blue-50 rounded-xl text-xs font-bold transition-colors">
                <span class="material-symbols-outlined text-base">visibility</span> Detail
            </a>
            @if($materi->file_path)
            <a href="{{ route($routePrefix . '.materi-kbm.download', $materi) }}"
                class="flex-1 flex items-center justify-center gap-1.5 py-2 text-primary hover:bg-purple-50 rounded-xl text-xs font-bold transition-colors">
                <span class="material-symbols-outlined text-base">download</span> Download
            </a>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100">
        <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">auto_stories</span>
        <p class="text-slate-400 font-medium">Belum ada materi KBM</p>
        @if($canCreateMateri)
        <a href="{{ route($routePrefix . '.materi-kbm.create') }}"
            class="mt-4 inline-block px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-purple-700 transition-all">
            Tambah Materi Pertama
        </a>
        @endif
    </div>
    @endforelse

    @if($materiKbm->hasPages())
        <div class="pt-2">
            @include('admin.materi-kbm._pagination')
        </div>
    @endif
</div>

@endsection
