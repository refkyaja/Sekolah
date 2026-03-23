<aside class="flex flex-col h-screen bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 overflow-hidden shrink-0">
    <!-- Header/Logo -->
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between sidebar-logo-container">
        <div class="flex items-center gap-3 sidebar-header-text">
            <div class="bg-primary p-2 rounded-lg text-white">
                <span class="material-symbols-outlined">school</span>
            </div>
            <div>
                <h1 class="font-bold text-slate-900 dark:text-slate-100">TK Harapan</h1>
                <p class="text-xs text-slate-500">Guru Portal</p>
            </div>
        </div>
        <button @click="sidebarCollapsed = !sidebarCollapsed; localStorage.setItem('sidebarCollapsed', sidebarCollapsed)" 
                class="hidden lg:flex p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 sidebar-toggle-icon">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button @click="mobileSidebarOpen = false" class="lg:hidden p-2 text-slate-500">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <p class="px-4 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-wider sidebar-text">Menu Utama</p>
        
        <a href="{{ route('guru.dashboard') }}" 
           class="sidebar-nav-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('guru.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-100' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium sidebar-text">Dashboard</span>
        </a>

        <p class="px-4 mt-6 mb-2 text-[10px] font-semibold text-slate-400 uppercase tracking-wider sidebar-text">Akun</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-medium sidebar-text">Keluar</span>
            </button>
        </form>
    </nav>

    <!-- User Profile Footer -->
    <div class="p-4 border-t border-slate-200 dark:border-slate-800 sidebar-footer-container">
        <div class="flex items-center gap-3 px-2 sidebar-footer-text">
            <img src="{{ auth()->user()->avatar_url }}" alt="Profile" class="w-10 h-10 rounded-lg object-cover">
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="sidebar-collapsed-profile hidden sidebar-collapsed:flex justify-center p-1">
             <img src="{{ auth()->user()->avatar_url }}" alt="Profile" class="w-10 h-10 rounded-lg object-cover">
        </div>
    </div>
</aside>
