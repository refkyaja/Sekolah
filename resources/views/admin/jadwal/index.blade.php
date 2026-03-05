@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')
@section('breadcrumb', 'Akademik / Jadwal Pelajaran')

@section('content')
<div class="space-y-6">
    <!-- Page Title Section -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Jadwal Pelajaran</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manajemen jadwal kegiatan belajar mengajar per kelompok.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 border border-primary text-primary font-bold rounded-lg hover:bg-primary/5 transition-colors">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak Jadwal
            </button>
            <a href="{{ route('admin.jadwal-pelajaran.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/25">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0 border-b border-slate-200 dark:border-slate-700">
        <div class="flex gap-8 min-w-max">
            <a href="{{ request()->fullUrlWithQuery(['kelompok' => 'A']) }}" 
               class="pb-4 px-2 border-b-2 {{ $selectedKelompok == 'A' ? 'border-primary text-primary' : 'border-transparent text-slate-500' }} font-bold text-sm transition-all">
                Kelompok A
            </a>
            <a href="{{ request()->fullUrlWithQuery(['kelompok' => 'B']) }}" 
               class="pb-4 px-2 border-b-2 {{ $selectedKelompok == 'B' ? 'border-primary text-primary' : 'border-transparent text-slate-500' }} font-bold text-sm transition-all">
                Kelompok B
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form action="{{ route('admin.jadwal-pelajaran.index') }}" method="GET" class="flex flex-wrap gap-4">
        <input type="hidden" name="kelompok" value="{{ $selectedKelompok }}">
        
        <div class="flex flex-col gap-1.5 min-w-[200px]">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Tahun Ajaran</label>
            <select name="tahun_ajaran_id" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:border-primary focus:ring-primary">
                @foreach($daftarTahunAjaran as $ta)
                    <option value="{{ $ta->id }}" {{ $selectedTahunAjaranId == $ta->id ? 'selected' : '' }}>
                        {{ $ta->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-1.5 min-w-[200px]">
            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Semester</label>
            <select name="semester" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:border-primary focus:ring-primary">
                <option value="Ganjil" {{ $selectedSemester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ $selectedSemester == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>
    </form>

    <!-- Schedule Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 overflow-x-auto pb-4 snap-x snap-mandatory">
        @foreach($hariList as $hari)
            <div class="flex flex-col gap-4 min-w-[280px] sm:min-w-[200px] snap-start">
                <div class="bg-primary/10 p-3 rounded-lg border border-primary/20">
                    <p class="text-center font-bold text-primary text-sm uppercase">{{ $hari }}</p>
                </div>
                
                <div class="flex flex-col gap-3">
                    @forelse($jadwal->get($hari, []) as $item)
                        @php
                            $catColors = [
                                'akademik' => 'bg-primary/10 text-primary',
                                'art' => 'bg-pink-100 text-pink-600',
                                'physical' => 'bg-emerald-100 text-emerald-600',
                                'break' => 'bg-amber-100 text-amber-600',
                                'special' => 'bg-purple-100 text-purple-600',
                            ];
                        @endphp
                        <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/40 transition-colors group relative">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold {{ $catColors[$item->kategori] ?? 'bg-slate-100 text-slate-600' }} px-2 py-0.5 rounded-full">
                                    {{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}
                                </span>
                                
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-slate-300 group-hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 w-32 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-lg shadow-xl z-10 py-1">
                                        <a href="{{ route('admin.jadwal-pelajaran.edit', $item) }}" class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800">
                                            <span class="material-symbols-outlined text-sm">edit</span> Edit
                                        </a>
                                        <form action="{{ route('admin.jadwal-pelajaran.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                                                <span class="material-symbols-outlined text-sm">delete</span> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 text-sm">{{ $item->mata_pelajaran }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $item->guru ?? 'Guru belum ditentukan' }}</p>
                            @if($item->lokasi)
                                <p class="text-[10px] text-slate-400 mt-2 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $item->lokasi }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <div class="p-4 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-lg text-center">
                            <p class="text-[10px] text-slate-400">Tidak ada jadwal</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
