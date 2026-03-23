<nav class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center shadow-lg transform -rotate-6">
                <span class="material-icons text-white">school</span>
            </div>
            <span class="text-2xl font-bold font-display tracking-tight text-primary dark:text-accent-blue">TK HARAPAN BANGSA 2</span>
        </div>
        
        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-8 font-semibold text-slate-600 dark:text-slate-300">
            <a class="hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary' : '' }}" href="{{ route('home') }}">Beranda</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('profil') ? 'text-primary' : '' }}" href="{{ route('profil') }}">Profil</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('kurikulum') ? 'text-primary' : '' }}" href="{{ route('kurikulum') }}">Kurikulum</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('ppdb.index') ? 'text-primary' : '' }}" href="{{ route('ppdb.index') }}">PPDB</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('informasi') || request()->routeIs('berita.*') || request()->routeIs('galeri.*') ? 'text-primary' : '' }}" href="{{ route('informasi') }}">Informasi</a>
        </div>

        <!-- Right: Desktop Links / Toggle -->
        <div class="flex items-center space-x-8">
            <div class="hidden md:flex items-center space-x-8 text-[10px] font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300">
                @php
                $navLinks = [
                    ['name' => 'Galeri', 'route' => 'galeri.index'],
                    ['name' => 'Informasi', 'route' => 'informasi'],
                ];
                @endphp
                @foreach($navLinks as $link)
                    <a class="hover:text-brand-primary transition-colors {{ request()->routeIs($link['route']) ? 'text-brand-primary' : '' }}" href="{{ route($link['route']) }}">{{ $link['name'] }}</a>
                @endforeach
            </div>
            
            <button class="p-2 rounded-full hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors" onclick="document.documentElement.classList.toggle('dark')">
                <span class="material-icons text-sm text-brand-dark dark:text-stone-300">dark_mode</span>
            </button>
            
            <!-- Mobile Menu Toggle -->
            <label class="md:hidden cursor-pointer p-2 hover:bg-stone-100 dark:hover:bg-stone-800 rounded-full transition-colors" @click="mobileMenuOpen = true">
                <svg class="w-5 h-5 text-brand-dark dark:text-stone-300" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </label>
        </div>
    </nav>

    <!-- Mobile Slide-over Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60]"
         @click="mobileMenuOpen = false"></div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 bottom-0 w-3/4 max-w-sm bg-white dark:bg-brand-dark z-[70] shadow-2xl flex flex-col">
        
        <div class="p-6 border-b border-stone-100 dark:border-stone-800 flex items-center justify-between">
            <span class="text-xl font-extrabold tracking-tighter text-brand-dark dark:text-white">
                TK<span class="text-brand-primary">.</span><span class="text-xs font-medium tracking-normal ml-1">HARAPAN BANGSA 1</span>
            </span>
            <button class="p-2 hover:bg-stone-100 dark:hover:bg-stone-800 rounded-full" @click="mobileMenuOpen = false">
                <svg class="w-6 h-6 text-brand-dark dark:text-white" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
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
            <a class="hover:text-primary transition-colors {{ request()->routeIs('profil') ? 'text-primary' : '' }}" href="{{ route('profil') }}">Profil</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('kurikulum') ? 'text-primary' : '' }}" href="{{ route('kurikulum') }}">Kurikulum</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('ppdb.index') ? 'text-primary' : '' }}" href="{{ route('ppdb.index') }}">PPDB</a>
            <a class="hover:text-primary transition-colors {{ request()->routeIs('informasi') || request()->routeIs('berita.*') || request()->routeIs('galeri.*') ? 'text-primary' : '' }}" href="{{ route('informasi') }}">Informasi</a>
            @guest('siswa')
            <button onclick="showLoginModal(event)" class="bg-primary text-white px-6 py-2.5 rounded-full font-bold text-center mt-2 shadow-md">Daftar Sekarang</button>
            @else
            <a class="bg-primary text-white px-6 py-2.5 rounded-full font-bold text-center mt-2 shadow-md" href="{{ route('ppdb.index') }}">Daftar Sekarang</a>
            @endguest
        </div>
    </div>
</header>
