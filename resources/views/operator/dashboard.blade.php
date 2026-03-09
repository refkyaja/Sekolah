@extends('layouts.admin')

@section('title', 'Dashboard Operator')

@section('content')
{{-- Welcome Hero --}}
<div class="relative bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-6 sm:p-8 mb-6 sm:mb-8 overflow-hidden min-h-[200px] sm:min-h-[220px] flex items-center shadow-xl shadow-blue-600/20">
    <div class="relative z-10 max-w-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Halo, {{ Auth::user()->name }}!</h1>
        <p class="text-white/80 mb-4 sm:mb-6 leading-relaxed text-sm sm:text-base">
            Selamat datang di dashboard operator. Akses semua data siswa, tahun ajaran, materi KBM, kalender akademik, jadwal pelajaran, PPDB, dan informasi publik.
        </p>
        <a href="#stats-section" 
           onclick="event.preventDefault(); document.getElementById('stats-section').scrollIntoView({ behavior: 'smooth', block: 'start' });"
           class="inline-flex items-center px-5 py-2.5 sm:px-6 sm:py-3 bg-white text-blue-600 rounded-xl font-bold text-sm hover:bg-blue-50 transition-all shadow-lg shadow-black/10">
            Jelajahi Data
        </a>
    </div>
    <div class="absolute right-0 top-0 bottom-0 w-1/3 flex items-center justify-center opacity-20 pointer-events-none">
        <span class="material-symbols-outlined text-[120px] sm:text-[160px] text-white">dashboard</span>
    </div>
</div>

<div class="grid grid-cols-12 gap-6 sm:gap-8">
    {{-- Left Column: Main Stats and Data --}}
    <div class="col-span-12 lg:col-span-8 space-y-6 sm:space-y-8">
        {{-- Main Statistics Cards --}}
        <div id="stats-section" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 scroll-mt-24">
            {{-- Data Siswa --}}
            <a href="{{ route('operator.siswa.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Data Siswa</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_siswa'] ?? 0 }}</p>
                <p class="text-[10px] text-green-500 font-bold mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">trending_up</span>
                    Aktif: {{ $stats['siswa_aktif'] ?? 0 }}
                </p>
            </a>

            {{-- Tahun Ajaran --}}
            <a href="{{ route('operator.tahun-ajaran.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">calendar_month</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tahun Ajaran</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $tahun_ajaran_list->count() ?? 0 }}</p>
                <p class="text-[10px] text-blue-500 font-bold mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">check_circle</span>
                    Aktif: {{ $tahun_ajaran_aktif ? $tahun_ajaran_aktif->tahun : 'Tidak Ada' }}
                </p>
            </a>

            {{-- Materi KBM --}}
            <a href="{{ route('operator.materi-kbm.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Materi KBM</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_materi'] ?? 0 }}</p>
                <p class="text-[10px] text-slate-400 font-bold mt-2">Total materi</p>
            </a>

            {{-- Kalender Akademik --}}
            <a href="{{ route('operator.kalender-akademik.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">event</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Kalender Akademik</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_kalender'] ?? 0 }}</p>
                <p class="text-[10px] text-slate-400 font-bold mt-2">Kegiatan</p>
            </a>
        </div>

        {{-- Second Row of Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Jadwal Pelajaran --}}
            <a href="{{ route('operator.jadwal-pelajaran.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Jadwal Pelajaran</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_jadwal'] ?? 0 }}</p>
                <p class="text-[10px] text-slate-400 font-bold mt-2">Total jadwal</p>
            </a>

            {{-- Semua PPDB --}}
            <a href="{{ route('operator.spmb.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Semua PPDB</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['ppdb_total'] ?? 0 }}</p>
                <p class="text-[10px] text-yellow-500 font-bold mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">pending</span>
                    {{ $stats['pendaftaran_baru'] ?? 0 }} menunggu
                </p>
            </a>

            {{-- Informasi Publik --}}
            <a href="{{ route('operator.berita.index') }}" class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm hover:shadow-md transition-all border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">campaign</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Informasi Publik</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_berita'] ?? 0 }}</p>
                <p class="text-[10px] text-slate-400 font-bold mt-2">Berita</p>
            </a>

            {{-- Data Guru --}}
            <div class="bg-white dark:bg-slate-800 p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-900/30 text-pink-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">co_present</span>
                </div>
                <h3 class="text-slate-400 dark:text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Data Guru</h3>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_guru'] ?? 0 }}</p>
                <p class="text-[10px] text-slate-400 font-bold mt-2">Total guru</p>
            </div>
        </div>

        {{-- Recent Data Tables --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Siswa --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Siswa Terbaru</h3>
                    <a href="{{ route('operator.siswa.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($siswa_terbaru ?? [] as $siswa)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 text-sm">person</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">{{ $siswa->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500">{{ $siswa->kelompok }} • {{ $siswa->nis ?? 'NIS' }}</p>
                        </div>
                        <span class="text-xs text-slate-400">{{ $siswa->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada data siswa</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent PPDB --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Pendaftaran PPDB Terbaru</h3>
                    <a href="{{ route('operator.spmb.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($recent_pendaftaran ?? [] as $item)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full {{ $item->status_pendaftaran === 'Lulus' ? 'bg-green-100 dark:bg-green-900/30' : ($item->status_pendaftaran === 'Menunggu Verifikasi' ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-red-100 dark:bg-red-900/30') }} flex items-center justify-center">
                            @if($item->status_pendaftaran === 'Lulus')
                            <span class="material-symbols-outlined text-green-600 text-sm">check_circle</span>
                            @elseif($item->status_pendaftaran === 'Menunggu Verifikasi')
                            <span class="material-symbols-outlined text-yellow-600 text-sm">pending</span>
                            @else
                            <span class="material-symbols-outlined text-red-600 text-sm">cancel</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">{{ $item->nama_lengkap_anak ?? 'Calon Siswa' }}</p>
                            <p class="text-xs text-slate-500">{{ $item->no_pendaftaran }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 {{ $item->status_pendaftaran === 'Lulus' ? 'bg-green-100 text-green-700' : ($item->status_pendaftaran === 'Menunggu Verifikasi' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }} rounded-full font-medium">
                            {{ $item->status_pendaftaran }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada pendaftaran</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Additional Info Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Materi Terbaru --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Materi Terbaru</h3>
                    <a href="{{ route('operator.materi-kbm.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($materi_terbaru ?? [] as $materi)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-sm">description</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">{{ $materi->judul }}</p>
                            <p class="text-xs text-slate-500">{{ $materi->mapel->nama ?? 'Mata Pelajaran' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada materi</p>
                    @endforelse
                </div>
            </div>

            {{-- Kalender Terbaru --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Kegiatan Terdekat</h3>
                    <a href="{{ route('operator.kalender-akademik.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($kalender_terbaru ?? [] as $kalender)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-orange-600 text-sm">event</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">{{ $kalender->kegiatan }}</p>
                            <p class="text-xs text-slate-500">{{ $kalender->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada kegiatan</p>
                    @endforelse
                </div>
            </div>

            {{-- Berita Terbaru --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Berita Terbaru</h3>
                    <a href="{{ route('operator.berita.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse($berita_terbaru ?? [] as $berita)
                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-teal-600 text-sm">article</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">{{ $berita->judul }}</p>
                            <p class="text-xs text-slate-500">{{ $berita->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada berita</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Quick Info --}}
    <div class="col-span-12 lg:col-span-4 space-y-6 sm:space-y-8">
        {{-- Profile Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5 sm:p-6 border border-slate-100 dark:border-slate-700 flex flex-col items-center text-center">
            <div class="relative mb-4">
                @if(Auth::user()->foto ?? null)
                <img alt="Profile" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-blue-100 dark:ring-blue-900/30" src="{{ asset('storage/' . Auth::user()->foto) }}"/>
                @else
                <div class="w-20 h-20 rounded-2xl bg-blue-600 flex items-center justify-center text-2xl font-bold text-white ring-4 ring-blue-100 dark:ring-blue-900/30">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
            </div>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</h3>
            <p class="text-xs text-slate-400 mb-5 sm:mb-6">Operator Sekolah</p>
            <div class="w-full flex justify-between px-4 mb-5 sm:mb-6">
                <div class="text-center">
                    <p class="text-lg font-bold text-blue-600">{{ $stats['total_siswa'] ?? 0 }}</p>
                    <p class="text-[10px] text-slate-400 uppercase font-black">Siswa</p>
                </div>
                <div class="h-8 w-px bg-slate-100 dark:bg-slate-700"></div>
                <div class="text-center">
                    <p class="text-lg font-bold text-blue-600">{{ $stats['total_guru'] ?? 0 }}</p>
                    <p class="text-[10px] text-slate-400 uppercase font-black">Guru</p>
                </div>
                <div class="h-8 w-px bg-slate-100 dark:bg-slate-700"></div>
                <div class="text-center">
                    <p class="text-lg font-bold text-blue-600">{{ $stats['ppdb_total'] ?? 0 }}</p>
                    <p class="text-[10px] text-slate-400 uppercase font-black">PPDB</p>
                </div>
            </div>
            <div class="w-full space-y-2">
                <a href="{{ route('operator.spmb.index') }}" class="w-full py-2 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition-all text-center block">
                    Kelola PPDB
                </a>
                <a href="{{ route('operator.siswa.index') }}" class="w-full py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-sm rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all text-center block">
                    Lihat Data Siswa
                </a>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-5 sm:p-6 border border-slate-100 dark:border-slate-700">
            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 mb-4">Statistik Cepat</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 text-sm">groups</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Siswa Aktif</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['siswa_aktif'] ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-sm">menu_book</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Materi KBM</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['total_materi'] ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-orange-600 text-sm">event</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Kalender</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['total_kalender'] ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-indigo-600 text-sm">schedule</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Jadwal</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['total_jadwal'] ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-red-600 text-sm">school</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">PPDB Total</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['ppdb_total'] ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-teal-600 text-sm">campaign</span>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400">Berita</span>
                    </div>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $stats['total_berita'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Offset for fixed header saat scroll ke anchor */
    .scroll-mt-24 {
        scroll-margin-top: 6rem;
    }
</style>
@endpush
