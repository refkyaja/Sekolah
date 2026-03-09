<nav class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center shadow-lg transform -rotate-6">
                <span class="material-icons text-white">school</span>
            </div>
            <span class="text-2xl font-bold font-display tracking-tight text-primary dark:text-accent-blue">TK HARAPAN BANGSA 1</span>
        </div>
        
        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8 font-semibold text-slate-600 dark:text-slate-300">
            <a class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('profil.index') ? 'text-primary' : '' }}" href="{{ route('profil.index') }}">Profil</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('akademik.kurikulum') ? 'text-primary' : '' }}" href="{{ route('akademik.kurikulum') }}">Kurikulum</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('spmb.index') ? 'text-primary' : '' }}" href="{{ route('ppdb.index') }}">PPDB</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('berita.index') ? 'text-primary' : '' }}" href="{{ route('berita.index') }}">Informasi</a>
        </div>
        
        <div class="flex items-center gap-4">
            <button class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" onclick="document.documentElement.classList.toggle('dark')">
                <span class="material-icons text-slate-600 dark:text-slate-400">dark_mode</span>
            </button>
            <a class="hidden md:block bg-primary text-white px-6 py-2.5 rounded-full font-bold hover:opacity-90 transition-all shadow-md" href="{{ route('spmb.pendaftaran') }}">Daftar Sekarang</a>
            
            <!-- Mobile Menu Toggle -->
            <button class="md:hidden p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" @click="mobileMenuOpen = !mobileMenuOpen">
                <span class="material-icons text-slate-600 dark:text-slate-400" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         @click.away="mobileMenuOpen = false" 
         class="md:hidden bg-white dark:bg-slate-900 shadow-md border-t border-slate-100 dark:border-slate-800">
        <div class="flex flex-col p-4 font-semibold text-slate-600 dark:text-slate-300 gap-y-4">
            <a class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('profil.index') ? 'text-primary' : '' }}" href="{{ route('profil.index') }}">Profil</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('akademik.kurikulum') ? 'text-primary' : '' }}" href="{{ route('akademik.kurikulum') }}">Kurikulum</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('spmb.index') ? 'text-primary' : '' }}" href="{{ route('ppdb.index') }}">PPDB</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('berita.index') ? 'text-primary' : '' }}" href="{{ route('berita.index') }}">Informasi</a>
            <a class="bg-primary text-white px-6 py-2.5 rounded-full font-bold text-center mt-2 shadow-md" href="{{ route('spmb.pendaftaran') }}">Daftar Sekarang</a>
        </div>
    </div>
</nav>
