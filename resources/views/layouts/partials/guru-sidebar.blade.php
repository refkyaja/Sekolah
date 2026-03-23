<aside class="guru-sidebar w-72 flex-shrink-0 bg-sidebar-bg text-white flex flex-col h-full z-40 lg:z-20 transition-all duration-300">
    <div class="p-6 flex items-center justify-between">
        <div class="flex min-w-0 flex-1 items-center gap-3 overflow-hidden">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-white/20 backdrop-blur-md">
                <span class="material-symbols-outlined text-white text-2xl">school</span>
            </div>
            <div class="logo-text min-w-0 flex-1 leading-tight text-white">
                <p class="text-sm font-black uppercase tracking-[0.18em]">TK PGRI</p>
                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-white/80">Harapan Bangsa 1</p>
            </div>
        </div>
        <button class="p-1.5 hover:bg-white/10 rounded-lg transition-colors hidden lg:flex" 
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('guruSidebarCollapsed', sidebarCollapsed)">
            <span class="material-symbols-outlined text-white">menu</span>
        </button>
        <button class="p-1.5 hover:bg-white/10 rounded-lg transition-colors lg:hidden" 
                @click="mobileSidebarOpen = false">
            <span class="material-symbols-outlined text-white">close</span>
        </button>
    </div>

    <div class="sidebar-scroll flex-1 overflow-y-auto px-4 space-y-6 pb-6 mt-2">
        <div>
            <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('guru.dashboard') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all hover:bg-white/30" href="{{ route('guru.dashboard') }}" title="Dashboard Overview">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="text-sm nav-text whitespace-nowrap">Dashboard Overview</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">📂 Data Siswa</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.siswa.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group" href="{{ route('guru.siswa.siswa-aktif.index') }}" title="Data Siswa">
                <span class="material-symbols-outlined text-lg">group</span>
                <span class="text-sm nav-text whitespace-nowrap">Data Siswa</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">📚 Akademik</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.absensi.index') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('guru.absensi.index') }}" title="Absensi Siswa">
                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                <span class="text-sm nav-text whitespace-nowrap">Absensi Siswa</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.kalender-akademik.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('guru.kalender-akademik.index') }}" title="Kalender Akademik">
                <span class="material-symbols-outlined text-lg">event_note</span>
                <span class="text-sm nav-text whitespace-nowrap">Kalender Akademik</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">🌐 Informasi Publik</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.galeri.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('guru.galeri.index') }}" title="Galeri">
                <span class="material-symbols-outlined text-lg">photo_library</span>
                <span class="text-sm nav-text whitespace-nowrap">Galeri</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.kegiatan.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('guru.kegiatan.index') }}" title="Kegiatan Sekolah">
                <span class="material-symbols-outlined text-lg">festival</span>
                <span class="text-sm nav-text whitespace-nowrap">Kegiatan Sekolah</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('guru.bukutamu.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('guru.bukutamu.index') }}" title="Buku Tamu">
                <span class="material-symbols-outlined text-lg">book</span>
                <span class="text-sm nav-text whitespace-nowrap">Buku Tamu</span>
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="p-4 border-t border-white/10">
        @csrf
        <button type="button" onclick="confirmLogout()" class="nav-item w-full flex items-center justify-center gap-2 px-4 py-2 text-white/80 hover:bg-white/10 rounded-xl transition-all text-sm" title="Keluar">
            <span class="material-symbols-outlined text-lg">logout</span>
            <span class="nav-text whitespace-nowrap">Keluar</span>
        </button>
    </form>
</aside>
