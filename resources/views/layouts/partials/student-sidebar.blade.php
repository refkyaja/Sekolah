@php
    $siswa = auth('siswa')->user();
@endphp
<aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col transition-all duration-300">
    <div class="p-6 flex items-center justify-between">
        <div class="flex items-center gap-3 sidebar-logo-container overflow-hidden">
            <div class="size-10 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary text-2xl">school</span>
            </div>
            <div class="flex flex-col sidebar-header-text whitespace-nowrap">
                <h1 class="text-slate-900 dark:text-slate-100 text-base font-bold leading-tight">Harapan Bangsa 2</h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">Taman Kanak-Kanak</p>
            </div>
        </div>
        <button class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-500 hidden lg:flex" 
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)">
            <span class="material-symbols-outlined sidebar-toggle-icon">chevron_left</span>
        </button>
        <button class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-500 lg:hidden" 
                @click="mobileSidebarOpen = false">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-2 mt-4 overflow-y-auto">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors sidebar-nav-item {{ Route::is('siswa.dashboard') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" 
           href="{{ route('siswa.dashboard') }}" title="Beranda">
            <span class="material-symbols-outlined">home</span>
            <span class="text-sm sidebar-text whitespace-nowrap">Beranda</span>
        </a>
        
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors sidebar-nav-item {{ Route::is('siswa.jadwal.index') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" 
           href="{{ route('siswa.jadwal.index') }}" title="Jadwal Pelajaran">
            <span class="material-symbols-outlined">calendar_month</span>
            <span class="text-sm sidebar-text whitespace-nowrap">Jadwal Pelajaran</span>
        </a>

        <a href="{{ route('siswa.kalender.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors sidebar-nav-item {{ Route::is('siswa.kalender.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
           title="Tanggal Akademik">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="text-sm sidebar-text whitespace-nowrap">Tanggal Akademik</span>
        </a>

        <a href="{{ route('siswa.materi.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors sidebar-nav-item {{ Route::is('siswa.materi.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
           title="Materi KBM">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="text-sm sidebar-text whitespace-nowrap">Materi KBM</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors sidebar-nav-item {{ Route::is('siswa.ppdb.hasil-seleksi') ? 'bg-primary/10 text-primary font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" 
           href="{{ route('siswa.ppdb.hasil-seleksi') }}" title="Hasil Seleksi PPDB">
            <span class="material-symbols-outlined">person_add</span>
            <span class="text-sm sidebar-text whitespace-nowrap">Hasil Seleksi PPDB</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-100 dark:border-slate-800 px-4">
        <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl sidebar-footer-container transition-all">
            <div class="size-10 rounded-full bg-slate-200 flex-shrink-0 bg-cover bg-center" style="background-image: url('{{ $siswa->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama_lengkap) }}');"></div>
            <div class="overflow-hidden sidebar-footer-text">
                <p class="text-sm font-bold truncate">{{ $siswa->nama_lengkap }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider">Siswa</p>
            </div>
        </div>
        <form method="POST" action="{{ route('siswa.logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors sidebar-nav-item" title="Keluar">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span class="text-sm font-medium sidebar-text whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>
