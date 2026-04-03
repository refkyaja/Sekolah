@extends('layouts.admin')

@push('styles')
<style type="text/tailwindcss">
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route('admin.dashboard') }}">Akademik</a></li>
        <li><span class="mx-2">/</span></li>
        <li><a class="hover:text-primary" href="{{ route('admin.absensi.index') }}">Absensi Siswa</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600 dark:text-slate-400">Input Absensi</li>
    </ol>
</nav>

<!-- Configuration Card (Select Date & Kelompok) -->
<div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm mb-8">
    <form method="GET" action="{{ route('admin.absensi.fill') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <div class="space-y-2">
            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Pilih Tanggal</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">calendar_today</span>
                <input type="date" name="tanggal" value="{{ $tanggal }}" 
                       class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm transition-all cursor-pointer" [color-scheme:light] dark:[color-scheme:dark]
                       onchange="this.form.submit()">
            </div>
        </div>
        
        <div class="space-y-2">
            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Pilih Kelompok</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">group</span>
                <select name="kelompok" 
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm appearance-none transition-all cursor-pointer"
                        onchange="this.form.submit()">
                    <option value="">- Pilih Kelompok -</option>
                    <option value="A" {{ $kelompok == 'A' ? 'selected' : '' }}>Kelompok A</option>
                    <option value="B" {{ $kelompok == 'B' ? 'selected' : '' }}>Kelompok B</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                Tampilkan Siswa
            </button>
        </div>
    </form>
</div>

@if($kelompok && $siswa->isNotEmpty())
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Input Absensi - Kel. {{ $kelompok }}</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Silakan isi kehadiran siswa untuk hari ini.</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary dark:text-indigo-400">calendar_today</span>
            <input class="pl-12 pr-4 py-3 bg-white dark:bg-slate-800 border-none dark:text-slate-100 rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm font-bold text-primary dark:text-indigo-400 shadow-sm transition-all outline-none cursor-pointer text-center" style="width: 170px;" type="text" value="{{ \Carbon\Carbon::parse($tanggal)->format('Y-m-d') }}" readonly disabled />
        </div>
        @if(isset($guru) && $guru)
            <div class="hidden md:flex flex-col text-right">
                <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Guru Kelompok</span>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $guru->nama }}</span>
            </div>
        @endif
    </div>
</div>

<form method="POST" action="{{ route('admin.absensi.store-batch') }}" class="space-y-8" id="form-absensi">
    @csrf
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <input type="hidden" name="kelompok" value="{{ $kelompok }}">
    @if(isset($guru) && $guru)
        <input type="hidden" name="guru_id" value="{{ $guru->id }}">
    @endif

    <!-- HIDDEN INPUTS TO PREVENT DUPLICATION -->
    @foreach($siswa as $s_hidden)
        @php 
            $hiddenExistingStatus = optional($existing->get($s_hidden->id))->status ?? 'hadir'; 
            $hiddenKeterangan = optional($existing->get($s_hidden->id))->keterangan ?? '';
        @endphp
        <input type="hidden" name="statuses[{{ $s_hidden->id }}]" id="hidden_status_{{ $s_hidden->id }}" value="{{ $hiddenExistingStatus }}">
        <input type="hidden" name="keterangan[{{ $s_hidden->id }}]" id="hidden_keterangan_{{ $s_hidden->id }}" value="{{ $hiddenKeterangan }}">
    @endforeach

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-20">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider w-32">NIS</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center">Status Kehadiran</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                    @php
                        // Color variations for avatars
                        $colors = [
                            ['bg' => 'bg-lavender', 'text' => 'text-primary dark:text-indigo-400'],
                            ['bg' => 'bg-purple-100', 'text' => 'text-primary dark:text-indigo-400'],
                            ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-400'],
                            ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400'],
                            ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400'],
                            ['bg' => 'bg-rose-100 dark:bg-rose-900/30', 'text' => 'text-rose-700 dark:text-rose-400'],
                        ];
                    @endphp
                    @foreach($siswa as $index => $s)
                    @php 
                        $existingStatus = optional($existing->get($s->id))->status ?? 'hadir'; 
                        $keterangan = optional($existing->get($s->id))->keterangan ?? '';
                        $colorClass = $colors[$index % count($colors)];
                        
                        // Get initials
                        $nameParts = explode(' ', $s->nama_lengkap ?? $s->nama);
                        $initials = '';
                        foreach(array_slice($nameParts, 0, 2) as $part) {
                            if(!empty($part)) $initials .= strtoupper(substr($part, 0, 1));
                        }
                        if(empty($initials)) $initials = '?';
                    @endphp
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="px-6 py-5 text-sm font-medium text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-600 dark:text-slate-400">{{ $s->nis ?? '-' }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $colorClass['bg'] }} {{ $colorClass['text'] }} flex items-center justify-center font-bold text-xs">{{ $initials }}</div>
                                <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $s->nama_lengkap ?? $s->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center">
                                <select id="desktop_status_{{ $s->id }}" onchange="document.getElementById('hidden_status_{{ $s->id }}').value = this.value; document.getElementById('mobile_status_{{ $s->id }}').value = this.value;" class="w-36 px-3 py-2 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm font-semibold cursor-pointer transition-all appearance-none text-center">
                                    <option value="hadir" {{ $existingStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="sakit" {{ $existingStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="izin" {{ $existingStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="alpa" {{ ($existingStatus == 'alpa' || str_contains($existingStatus, 'tidak_hadir')) ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <input id="desktop_keterangan_{{ $s->id }}" oninput="document.getElementById('hidden_keterangan_{{ $s->id }}').value = this.value; document.getElementById('mobile_keterangan_{{ $s->id }}').value = this.value;" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-primary/20 text-xs transition-all" placeholder="Catatan..." type="text" value="{{ $keterangan }}"/>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden flex flex-col gap-4 mb-24">
        @foreach($siswa as $index => $s)
        @php 
            $existingStatus = optional($existing->get($s->id))->status ?? 'hadir'; 
            $keterangan = optional($existing->get($s->id))->keterangan ?? '';
            $colorClass = $colors[$index % count($colors)];
            
            // Get initials
            $nameParts = explode(' ', $s->nama_lengkap ?? $s->nama);
            $initials = '';
            foreach(array_slice($nameParts, 0, 2) as $part) {
                if(!empty($part)) $initials .= strtoupper(substr($part, 0, 1));
            }
            if(empty($initials)) $initials = '?';
        @endphp
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col gap-4 relative overflow-hidden">
            <div class="flex items-center gap-3 border-b border-slate-50 dark:border-slate-700/50 pb-3">
                <div class="w-10 h-10 rounded-full {{ $colorClass['bg'] }} {{ $colorClass['text'] }} flex items-center justify-center font-bold text-sm shrink-0">{{ $initials }}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">{{ $s->nama_lengkap ?? $s->nama }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 font-medium">{{ $s->nis ?? 'No NIS' }}</p>
                </div>
            </div>
            
            <div class="flex flex-col gap-3">
                <div class="w-full">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">Status</label>
                    <select id="mobile_status_{{ $s->id }}" onchange="document.getElementById('hidden_status_{{ $s->id }}').value = this.value; document.getElementById('desktop_status_{{ $s->id }}').value = this.value;" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm font-bold cursor-pointer transition-all appearance-none text-slate-700 dark:text-slate-300">
                        <option value="hadir" {{ $existingStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="sakit" {{ $existingStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="izin" {{ $existingStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="alpa" {{ ($existingStatus == 'alpa' || str_contains($existingStatus, 'tidak_hadir')) ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>
                <div class="w-full">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">Catatan</label>
                    <input id="mobile_keterangan_{{ $s->id }}" oninput="document.getElementById('hidden_keterangan_{{ $s->id }}').value = this.value; document.getElementById('desktop_keterangan_{{ $s->id }}').value = this.value;" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all" placeholder="Keterangan opsional..." type="text" value="{{ $keterangan }}"/>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Fixed Bottom Bar -->
    <div class="fixed bottom-0 right-0 left-0 lg:left-72 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-t border-slate-100 dark:border-slate-700 p-4 z-[40] shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] transition-all duration-300">
        <div class="max-w-7xl mx-auto flex items-center justify-end gap-3 px-2 md:px-4">
            <a href="{{ route('admin.absensi.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-2xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-all flex items-center justify-center flex-1 sm:flex-none">
                Batal
            </a>
            <button type="button" onclick="document.getElementById('form-absensi').submit();" class="px-8 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center justify-center gap-2 flex-[2] sm:flex-none">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan
            </button>
        </div>
    </div>
</form>

@elseif($kelompok)
<div class="bg-white dark:bg-slate-800 rounded-3xl p-12 border border-slate-100 dark:border-slate-700 text-center shadow-sm">
    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6">
        <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600">person_search</span>
    </div>
    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Tidak Ada Siswa</h3>
    <p class="text-slate-400 dark:text-slate-500 text-sm max-w-sm mx-auto mb-8">Belum ada siswa yang terdaftar di Kelompok {{ $kelompok }} untuk saat ini.</p>
    <a href="{{ route('admin.siswa.siswa-aktif.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
        <span class="material-symbols-outlined text-lg">person_add</span>
        Tambah Siswa
    </a>
</div>
@else
<div class="bg-primary/5 dark:bg-primary/10 border border-primary/10 rounded-3xl p-12 text-center">
    <div class="w-20 h-20 bg-primary/20 text-primary dark:text-indigo-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl shadow-primary/10">
        <span class="material-symbols-outlined text-4xl">touch_app</span>
    </div>
    <h3 class="text-xl font-bold text-primary dark:text-indigo-400 mb-2">Pilih Kelompok</h3>
    <p class="text-slate-500 dark:text-slate-400 text-sm max-w-xs mx-auto">Silakan pilih kelompok belajar di atas untuk memulai pencatatan absensi.</p>
</div>
@endif

@endsection