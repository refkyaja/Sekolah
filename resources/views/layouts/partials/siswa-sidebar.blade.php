<aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col fixed h-full z-50 transition-all duration-300 shadow-sm"
     :class="[mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', sidebarCollapsed ? 'lg:w-20' : 'lg:w-72']">
<div class="sidebar-header p-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 flex-shrink-0 object-contain">
        <div class="logo-text">
            <h1 class="text-sm font-bold leading-tight uppercase">TK PGRI</h1>
            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Harapan Bangsa 1</p>
        </div>
    </div>
    {{-- Desktop Toggle --}}
    <button class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors hidden lg:flex" 
            @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('siswaSidebarCollapsed', sidebarCollapsed)">
        <span class="material-symbols-outlined">menu</span>
    </button>
    {{-- Mobile Close --}}
    <button class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors lg:hidden" 
            @click="mobileSidebarOpen = false">
        <span class="material-symbols-outlined">close</span>
    </button>
</div>

@php
    $siswa = auth('siswa')->user();
    $spmb = null;
    if ($siswa->spmb_id) {
        $spmb = \App\Models\Spmb::find($siswa->spmb_id);
    }
    if (!$spmb && $siswa->nik) {
        $spmb = \App\Models\Spmb::where('nik_anak', $siswa->nik)->orderBy('created_at', 'desc')->first();
    }
    $isLulus = $siswa->status_siswa === 'lulus' || ($spmb && $spmb->status_pendaftaran === 'Lulus');
    // Siswa aktif (sudah diterima/terdaftar sebagai siswa) juga mendapat menu akademik
    $isAktifOrLulus = $isLulus || $siswa->status_siswa === 'aktif';
@endphp

<nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto sidebar-scroll">
    <!-- Dashboard -->
    <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.dashboard') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
       href="{{ route('siswa.dashboard') }}" title="Dashboard">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="nav-text">Dashboard</span>
    </a>

    @if($isAktifOrLulus)
        <!-- Academic Menus for Active Students / Alumni -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.kehadiran') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.kehadiran') }}" title="Kehadiran">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="nav-text">Kehadiran</span>
        </a>

        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.materi') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.materi') }}" title="Materi KBM">
            <span class="material-symbols-outlined">library_books</span>
            <span class="nav-text">Materi KBM</span>
        </a>

        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.jadwal') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.jadwal') }}" title="Jadwal Pelajaran">
            <span class="material-symbols-outlined">schedule</span>
            <span class="nav-text">Jadwal Pelajaran</span>
        </a>

        <!-- PPDB Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('siswa.formulir', 'siswa.dokumen', 'siswa.pengumuman') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" 
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ request()->routeIs('siswa.formulir', 'siswa.dokumen', 'siswa.pengumuman') ? 'bg-slate-50 dark:bg-slate-800/50' : '' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">assignment_ind</span>
                    <span class="nav-text">PPDB</span>
                </div>
                <span class="material-symbols-outlined text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="open" x-collapse x-cloak class="pl-12 space-y-1">
                <a href="{{ route('siswa.formulir') }}" class="block py-2 text-sm {{ request()->routeIs('siswa.formulir') ? 'text-primary font-medium' : 'text-slate-500 hover:text-primary transition-colors' }}">
                    Formulir @if($isLulus)<span class="text-[9px] text-slate-400 font-bold bg-slate-100 px-1 py-0.5 rounded ml-1">ARSIP</span>@endif
                </a>
                <a href="{{ route('siswa.dokumen') }}" class="block py-2 text-sm {{ request()->routeIs('siswa.dokumen') ? 'text-primary font-medium' : 'text-slate-500 hover:text-primary transition-colors' }}">
                    Dokumen @if($isLulus)<span class="text-[9px] text-slate-400 font-bold bg-slate-100 px-1 py-0.5 rounded ml-1">ARSIP</span>@endif
                </a>
                <a href="{{ route('siswa.pengumuman') }}" class="block py-2 text-sm {{ request()->routeIs('siswa.pengumuman') ? 'text-primary font-medium' : 'text-slate-500 hover:text-primary transition-colors' }}">
                    Pengumuman @if($isLulus)<span class="text-[9px] text-slate-400 font-bold bg-slate-100 px-1 py-0.5 rounded ml-1">ARSIP</span>@else<span class="text-[9px] text-primary font-bold bg-primary/10 px-1 py-0.5 rounded ml-1">INFO</span>@endif
                </a>
            </div>
        </div>
    @else
        <!-- Standard PPDB Menus -->
        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.formulir') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.formulir') }}" title="Formulir">
            <span class="material-symbols-outlined">description</span>
            <span class="nav-text">Formulir</span>
        </a>

        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.dokumen') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.dokumen') }}" title="Dokumen">
            <span class="material-symbols-outlined">folder_open</span>
            <span class="nav-text">Dokumen</span>
        </a>

        <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.pengumuman') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
           href="{{ route('siswa.pengumuman') }}" title="Pengumuman">
            <span class="material-symbols-outlined">notifications</span>
            <span class="nav-text">Pengumuman</span>
        </a>
    @endif
</nav>

@auth('siswa')
<div class="p-4 mt-auto">
    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-800 profile-card transition-all duration-300 overflow-hidden">
        <a href="{{ route('siswa.profile') }}" class="flex items-center gap-3 mb-3 group/profile profile-container transition-all" title="Profil Saya">
            @php
                $siswa = auth('siswa')->user();
                $fotoUrl = $siswa->foto_url;
            @endphp
            <img alt="Student Profile" class="w-10 h-10 rounded-full border-2 border-primary/20 flex-shrink-0 group-hover/profile:border-primary transition-colors" src="{{ $fotoUrl }}"/>
            <div class="overflow-hidden nav-text">
                <p class="text-sm font-semibold truncate group-hover/profile:text-primary transition-colors">{{ $siswa->nama_lengkap ?? 'Siswa' }}</p>
                <p class="text-[10px] uppercase tracking-wider group-hover/profile:text-primary/70 transition-colors {{ $siswa->status_siswa === 'lulus' ? 'text-sky-500 font-bold' : ($siswa->status_siswa === 'aktif' ? 'text-emerald-500 font-bold' : 'text-slate-500') }}">
                    {{ $siswa->status_siswa === 'lulus' ? 'ALUMNI / LULUS' : ($siswa->status_siswa === 'aktif' ? 'SISWA AKTIF' : 'Calon Peserta Didik') }}
                </p>
            </div>
        </a>
        <form id="logoutForm" method="POST" action="{{ route('siswa.logout') }}" class="w-full">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center justify-center gap-2 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-primary transition-colors logout-button" title="Sign Out">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span class="nav-text">Sign Out</span>
            </button>
        </form>
    </div>
</div>
@endauth
</aside>
