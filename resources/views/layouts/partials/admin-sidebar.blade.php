@php
    $role = auth()->user()->role;

    $prefixMap = [
        'admin' => 'admin',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        'operator' => 'operator',
    ];

    $rolePrefix = $prefixMap[$role] ?? 'guest';

    $isAdmin = $role === 'admin';
    $isKepsek = $role == 'kepala_sekolah';
    $isGuru = $role == 'guru';
    $isOperator = $role == 'operator';

    $navBaseClass = 'nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all';
    $navDefaultClass = 'text-white/80 dark:text-slate-400 hover:bg-white/10 dark:hover:bg-slate-800 hover:text-white dark:hover:text-slate-100';
    $navActiveClass = 'bg-white/20 dark:bg-slate-800 text-white dark:text-slate-100 font-medium shadow-sm';
@endphp

<aside class="admin-sidebar w-72 flex-shrink-0 bg-sidebar-bg dark:bg-slate-950 text-white dark:text-slate-100 flex flex-col h-full z-40 lg:z-20 transition-all duration-300 border-r border-transparent dark:border-slate-800">
    <div class="p-6 flex items-center justify-between">
        <div class="flex min-w-0 flex-1 items-center gap-3 overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-14 flex-shrink-0 object-contain">
            <div class="logo-text min-w-0 flex-1 leading-tight text-white dark:text-slate-100">
                <p class="text-sm font-black uppercase tracking-[0.18em]">TK PGRI</p>
                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-white/80 dark:text-slate-300">Harapan Bangsa 1</p>
            </div>
        </div>
        <button class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg transition-colors hidden lg:flex"
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('adminSidebarCollapsed', sidebarCollapsed)">
            <span class="material-symbols-outlined text-white dark:text-slate-100">menu</span>
        </button>
        <button class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg transition-colors lg:hidden"
                @click="mobileSidebarOpen = false">
            <span class="material-symbols-outlined text-white dark:text-slate-100">close</span>
        </button>
    </div>

    <div class="sidebar-scroll flex-1 overflow-y-auto px-4 space-y-6 pb-6 mt-2">
        <div>
            <a class="{{ $navBaseClass }} rounded-2xl {{ request()->routeIs($rolePrefix.'.dashboard') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.dashboard') }}"
               title="Dashboard Overview">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="text-sm nav-text whitespace-nowrap">Dashboard Overview</span>
            </a>
        </div>

        @if($role != 'guru')
        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">A. Master Data</h3>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.siswa.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.siswa.siswa-aktif.index') }}"
               title="Data Siswa">
                <span class="material-symbols-outlined text-lg">group</span>
                <span class="text-sm nav-text whitespace-nowrap">Data Siswa</span>
            </a>

            @if($isAdmin || $isKepsek)
            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.guru.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.guru.index') }}"
               title="Data Guru">
                <span class="material-symbols-outlined text-lg">person_pin_circle</span>
                <span class="text-sm nav-text whitespace-nowrap">Data Guru</span>
            </a>
            @endif

            @if($isAdmin || $isKepsek || $isOperator)
            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.tahun-ajaran.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.tahun-ajaran.index') }}"
               title="Tahun Ajaran">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
                <span class="text-sm nav-text whitespace-nowrap">Tahun Ajaran</span>
            </a>
            @endif
        </div>
        @endif

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">B. Akademik</h3>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.absensi.index') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.absensi.index') }}"
               title="Absensi Siswa">
                <span class="material-symbols-outlined text-lg">how_to_reg</span>
                <span class="text-sm nav-text whitespace-nowrap">Absensi Siswa</span>
            </a>

            @if($isAdmin || $isKepsek || $isOperator)
            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.absensi-guru.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.absensi-guru.index') }}"
               title="Absensi Guru">
                <span class="material-symbols-outlined text-lg">badge</span>
                <span class="text-sm nav-text whitespace-nowrap">Absensi Guru</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.materi-kbm.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.materi-kbm.index') }}"
               title="Materi KBM">
                <span class="material-symbols-outlined text-lg">auto_stories</span>
                <span class="text-sm nav-text whitespace-nowrap">Materi KBM</span>
            </a>
            @endif

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.kalender-akademik.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.kalender-akademik.index') }}"
               title="Kalender Akademik">
                <span class="material-symbols-outlined text-lg">event_note</span>
                <span class="text-sm nav-text whitespace-nowrap">Kalender Akademik</span>
            </a>

            @if($isAdmin || $isKepsek || $isOperator)
            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.jadwal-pelajaran.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.jadwal-pelajaran.index') }}"
               title="Jadwal Pelajaran">
                <span class="material-symbols-outlined text-lg">schedule</span>
                <span class="text-sm nav-text whitespace-nowrap">Jadwal Pelajaran</span>
            </a>
            @endif
        </div>

        @if($isAdmin || $isKepsek || $isOperator)
        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">C. PPDB</h3>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.ppdb.index') && !request()->has('status') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.ppdb.index') }}"
               title="Pendaftaran">
                <span class="material-symbols-outlined text-lg">app_registration</span>
                <span class="text-sm nav-text whitespace-nowrap">Pendaftaran</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.ppdb.pengumuman') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.ppdb.pengumuman') }}"
               title="Pengumuman">
                <span class="material-symbols-outlined text-lg">campaign</span>
                <span class="text-sm nav-text whitespace-nowrap">Pengumuman</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.ppdb.pengaturan') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.ppdb.pengaturan') }}"
               title="Settings PPDB">
                <span class="material-symbols-outlined text-lg">settings</span>
                <span class="text-sm nav-text whitespace-nowrap">Settings PPDB</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.ppdb.riwayat') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.ppdb.riwayat') }}"
               title="Riwayat PPDB">
                <span class="material-symbols-outlined text-lg">history</span>
                <span class="text-sm nav-text whitespace-nowrap">Riwayat PPDB</span>
            </a>

            <a class="{{ $navBaseClass }} {{ $navDefaultClass }}"
               href="{{ route($rolePrefix.'.ppdb.export') }}"
               title="Export Data">
                <span class="material-symbols-outlined text-lg">download</span>
                <span class="text-sm nav-text whitespace-nowrap">Export Data</span>
            </a>
        </div>
        @endif

        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">D. Informasi Publik</h3>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.galeri.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.galeri.index') }}"
               title="Galeri">
                <span class="material-symbols-outlined text-lg">photo_library</span>
                <span class="text-sm nav-text whitespace-nowrap">Galeri</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.kegiatan.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.kegiatan.index') }}"
               title="Kegiatan Sekolah">
                <span class="material-symbols-outlined text-lg">festival</span>
                <span class="text-sm nav-text whitespace-nowrap">Kegiatan Sekolah</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.bukutamu.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.bukutamu.index') }}"
               title="Buku Tamu">
                <span class="material-symbols-outlined text-lg">book</span>
                <span class="text-sm nav-text whitespace-nowrap">Buku Tamu</span>
            </a>
        </div>

        @if($isAdmin)
        <div class="space-y-1">
            <div class="nav-section-divider"></div>
            <h3 class="nav-section-title px-4 text-[10px] font-black text-white/60 dark:text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2 whitespace-nowrap">E. Manajemen Sistem</h3>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.accounts.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.accounts.index') }}"
               title="Kelola User">
                <span class="material-symbols-outlined text-lg">manage_accounts</span>
                <span class="text-sm nav-text whitespace-nowrap">Kelola User</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.siswa-accounts.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.siswa-accounts.index') }}"
               title="Akun Calon Siswa">
                <span class="material-symbols-outlined text-lg">person_search</span>
                <span class="text-sm nav-text whitespace-nowrap">Akun Calon Siswa</span>
            </a>

            <a class="{{ $navBaseClass }} {{ $navDefaultClass }}"
               href="#"
               onclick="return false;"
               title="Role & Permission">
                <span class="material-symbols-outlined text-lg">verified_user</span>
                <span class="text-sm nav-text whitespace-nowrap">Role & Permission</span>
            </a>

            <a class="{{ $navBaseClass }} {{ request()->routeIs($rolePrefix.'.activity-log.*') ? $navActiveClass : $navDefaultClass }}"
               href="{{ route($rolePrefix.'.activity-log.index') }}"
               title="Log Aktivitas">
                <span class="material-symbols-outlined text-lg">list_alt</span>
                <span class="text-sm nav-text whitespace-nowrap">Log Aktivitas</span>
            </a>
        </div>
        @endif

    </div>

    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="p-4 border-t border-white/10 dark:border-slate-800">
        @csrf
        <button type="button"
                onclick="confirmLogout()"
                class="nav-item w-full flex items-center justify-center gap-2 px-4 py-2 text-white/80 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800 rounded-xl transition-all text-sm"
                title="Keluar">
            <span class="material-symbols-outlined text-lg">logout</span>
            <span class="nav-text whitespace-nowrap">Keluar</span>
        </button>
    </form>
</aside>
