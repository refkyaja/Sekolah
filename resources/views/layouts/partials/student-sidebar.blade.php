@php
    $siswa = auth('siswa')->user();
@endphp
<aside class="w-72 bg-white dark:bg-brand-dark border-r border-stone-100 dark:border-stone-800 flex flex-col transition-all duration-300">
    <div class="p-8 flex items-center justify-between">
        <div class="flex items-center gap-3 sidebar-logo-container overflow-hidden">
            <div class="size-10 bg-brand-primary rounded-xl flex items-center justify-center flex-shrink-0 text-white shadow-lg shadow-brand-primary/20">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <div class="flex flex-col sidebar-header-text whitespace-nowrap">
                <h1 class="text-brand-dark dark:text-white text-xs font-extrabold uppercase tracking-widest leading-none">HB 2 Admin</h1>
                <p class="text-stone-400 dark:text-stone-500 text-[9px] font-bold uppercase tracking-tighter mt-1">Student Portal</p>
            </div>
        </div>
        <button class="p-1.5 hover:bg-stone-50 dark:hover:bg-stone-800 rounded-lg text-stone-300 hidden lg:flex" 
                @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)">
            <span class="material-symbols-outlined sidebar-toggle-icon">chevron_left</span>
        </button>
        <button class="p-1.5 hover:bg-stone-50 dark:hover:bg-stone-800 rounded-lg text-stone-300 lg:hidden" 
                @click="mobileSidebarOpen = false">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 mt-4 overflow-y-auto">
        <a class="flex items-center gap-3 px-6 py-3.5 rounded-xl transition-all sidebar-nav-item {{ Route::is('siswa.dashboard') ? 'bg-brand-soft text-brand-primary font-bold border border-brand-primary/10 shadow-sm shadow-brand-primary/5' : 'text-stone-400 dark:text-stone-500 hover:bg-stone-50 dark:hover:bg-stone-800 font-bold' }}" 
           href="{{ route('siswa.dashboard') }}" title="Beranda">
            <span class="material-symbols-outlined text-xl">home</span>
            <span class="text-[10px] uppercase tracking-[0.2em] sidebar-text whitespace-nowrap">Dashboard</span>
        </a>
        
        <a class="flex items-center gap-3 px-6 py-3.5 rounded-xl transition-all sidebar-nav-item {{ Route::is('siswa.pendaftaran.*') ? 'bg-brand-soft text-brand-primary font-bold border border-brand-primary/10 shadow-sm shadow-brand-primary/5' : 'text-stone-400 dark:text-stone-500 hover:bg-stone-50 dark:hover:bg-stone-800 font-bold' }}" 
           href="{{ route('siswa.pendaftaran.step1') }}" title="Pendaftaran PPDB">
            <span class="material-symbols-outlined text-xl">app_registration</span>
            <span class="text-[10px] uppercase tracking-[0.2em] sidebar-text whitespace-nowrap">Pendaftaran</span>
        </a>
    </nav>

    <div class="p-6 border-t border-stone-100 dark:border-stone-800">
        <div class="flex items-center gap-4 p-4 bg-brand-soft/50 dark:bg-stone-800/50 rounded-2xl sidebar-footer-container transition-all">
            <div class="size-10 rounded-xl bg-stone-200 flex-shrink-0 bg-cover bg-center shadow-sm" style="background-image: url('{{ $siswa->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama_lengkap) }}');"></div>
            <div class="overflow-hidden sidebar-footer-text">
                <p class="text-[10px] font-extrabold text-brand-dark dark:text-white truncate uppercase tracking-tight">{{ $siswa->nama_lengkap }}</p>
                <p class="text-[8px] text-stone-400 uppercase font-bold tracking-[0.2em] mt-0.5">Siswa HB 2</p>
            </div>
        </div>
        <form method="POST" action="{{ route('siswa.logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-6 py-2.5 text-stone-400 hover:text-brand-primary transition-colors sidebar-nav-item" title="Keluar">
                <span class="material-symbols-outlined text-base">logout</span>
                <span class="text-[10px] uppercase tracking-[0.2em] font-bold sidebar-text whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>
