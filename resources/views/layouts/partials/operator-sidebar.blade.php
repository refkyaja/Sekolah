<aside class="operator-sidebar w-72 flex-shrink-0 bg-sidebar-bg text-white flex flex-col h-full z-40 lg:z-20 transition-all duration-300">
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
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('operatorSidebarCollapsed', sidebarCollapsed)">
            <span class="material-symbols-outlined text-white">menu</span>
        </button>
        <button class="p-1.5 hover:bg-white/10 rounded-lg transition-colors lg:hidden" 
                @click="mobileSidebarOpen = false">
            <span class="material-symbols-outlined text-white">close</span>
        </button>
    </div>

    <div class="sidebar-scroll flex-1 overflow-y-auto px-4 space-y-6 pb-6 mt-2">
        <div>
            <a class="nav-item flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('operator.dashboard') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-all hover:bg-white/30" href="{{ route('operator.dashboard') }}" title="Dashboard Overview">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="text-sm nav-text whitespace-nowrap">Dashboard Overview</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">📂 A. Master Data</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.siswa.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group" href="{{ route('operator.siswa.siswa-aktif.index') }}" title="Data Siswa">
                <span class="material-symbols-outlined text-lg">group</span>
                <span class="text-sm nav-text whitespace-nowrap">Data Siswa</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all group {{ request()->routeIs('operator.siswa.siswa-aktif.pembagian-kelas') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" 
               href="{{ route('operator.siswa.siswa-aktif.pembagian-kelas') }}" 
               title="Pembagian Kelompok">
                <span class="material-symbols-outlined text-lg">grid_view</span>
                <span class="text-sm nav-text whitespace-nowrap">Pembagian Kelompok</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.tahun-ajaran.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all group" href="{{ route('operator.tahun-ajaran.index') }}" title="Tahun Ajaran">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
                <span class="text-sm nav-text whitespace-nowrap">Tahun Ajaran</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">📚 B. Akademik</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.absensi.index') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.absensi.index') }}" title="Absensi Siswa">
                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                <span class="text-sm nav-text whitespace-nowrap">Absensi Siswa</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.absensi-guru.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.absensi-guru.index') }}" title="Absensi Guru">
                <span class="material-symbols-outlined text-lg">badge</span>
                <span class="text-sm nav-text whitespace-nowrap">Absensi Guru</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.materi-kbm.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.materi-kbm.index') }}" title="Materi KBM">
                <span class="material-symbols-outlined text-lg">auto_stories</span>
                <span class="text-sm nav-text whitespace-nowrap">Materi KBM</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.kalender-akademik.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.kalender-akademik.index') }}" title="Kalender Akademik">
                <span class="material-symbols-outlined text-lg">event_note</span>
                <span class="text-sm nav-text whitespace-nowrap">Kalender Akademik</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.jadwal-pelajaran.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.jadwal-pelajaran.index') }}" title="Jadwal Pelajaran">
                <span class="material-symbols-outlined text-lg">schedule</span>
                <span class="text-sm nav-text whitespace-nowrap">Jadwal Pelajaran</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">🏫 C. PPDB</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.ppdb.index') && !request()->has('status') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.ppdb.index') }}" title="Pendaftaran">
                <span class="material-symbols-outlined text-lg">app_registration</span>
                <span class="text-sm nav-text whitespace-nowrap">Pendaftaran</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->get('status') == 'Diterima' ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.ppdb.index', ['status' => 'Diterima']) }}" title="Pengumuman">
                <span class="material-symbols-outlined text-lg">campaign</span>
                <span class="text-sm nav-text whitespace-nowrap">Pengumuman</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.ppdb.pengaturan') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.ppdb.pengaturan') }}" title="Settings PPDB">
                <span class="material-symbols-outlined text-lg">settings</span>
                <span class="text-sm nav-text whitespace-nowrap">Settings PPDB</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.ppdb.riwayat') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.ppdb.riwayat') }}" title="Riwayat PPDB">
                <span class="material-symbols-outlined text-lg">history</span>
                <span class="text-sm nav-text whitespace-nowrap">Riwayat PPDB</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 text-white/80 hover:bg-white/10 hover:text-white rounded-xl transition-all" href="{{ route('operator.ppdb.export') }}" title="Export Data">
                <span class="material-symbols-outlined text-lg">download</span>
                <span class="text-sm nav-text whitespace-nowrap">Export Data</span>
            </a>
        </div>

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">🌐 D. Informasi Publik</h3>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.galeri.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.galeri.index') }}" title="Galeri">
                <span class="material-symbols-outlined text-lg">photo_library</span>
                <span class="text-sm nav-text whitespace-nowrap">Galeri</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.kegiatan.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.kegiatan.index') }}" title="Kegiatan Sekolah">
                <span class="material-symbols-outlined text-lg">festival</span>
                <span class="text-sm nav-text whitespace-nowrap">Kegiatan Sekolah</span>
            </a>
            <a class="nav-item flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('operator.bukutamu.*') ? 'bg-white/20 text-white font-medium shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }} rounded-xl transition-all" href="{{ route('operator.bukutamu.index') }}" title="Buku Tamu">
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
