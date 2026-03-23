<aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col fixed h-full z-50 transition-all duration-300 shadow-sm"
     :class="[mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', sidebarCollapsed ? 'lg:w-20' : 'lg:w-72']">
<div class="sidebar-header p-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white">
            <span class="material-symbols-outlined">school</span>
        </div>
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

<nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto sidebar-scroll">
    <!-- Dashboard -->
    <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.dashboard') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
       href="{{ route('siswa.dashboard') }}" title="Dashboard">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="nav-text">Dashboard</span>
    </a>

    <!-- Formulir -->
    <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.formulir') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
       href="{{ route('siswa.formulir') }}" title="Formulir">
        <span class="material-symbols-outlined">description</span>
        <span class="nav-text">Formulir</span>
    </a>

    <!-- Dokumen -->
    <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.dokumen') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
       href="{{ route('siswa.dokumen') }}" title="Dokumen">
        <span class="material-symbols-outlined">folder_open</span>
        <span class="nav-text">Dokumen</span>
    </a>

    <!-- Pengumuman -->
    <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('siswa.pengumuman') ? 'bg-primary/10 text-primary font-medium' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors' }}" 
       href="{{ route('siswa.pengumuman') }}" title="Pengumuman">
        <span class="material-symbols-outlined">notifications</span>
        <span class="nav-text">Pengumuman</span>
    </a>
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
                <p class="text-[10px] text-slate-500 uppercase tracking-wider group-hover/profile:text-primary/70 transition-colors">
                    Calon Peserta Didik
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
