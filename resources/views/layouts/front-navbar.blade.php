@php
    $navLinks = [
        ['name' => 'Beranda', 'route' => 'home'],
        ['name' => 'Profil', 'route' => 'profil.index'],
        ['name' => 'Kurikulum', 'route' => 'akademik.kurikulum'],
        ['name' => 'Informasi', 'route' => 'informasi.index'],
        ['name' => 'PPDB', 'route' => 'spmb.index']
    ];
@endphp

<header class="sticky top-0 z-50 bg-white/90 dark:bg-brand-dark/90 backdrop-blur-md border-b border-stone-100 dark:border-stone-800" x-data="{ mobileMenuOpen: false }">
    <nav class="container mx-auto px-4 h-16 flex items-center justify-between">
        <!-- Left: Navigation Links (Desktop) -->
        <div class="hidden md:flex items-center space-x-8 text-[10px] font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300">
            @foreach(array_slice($navLinks, 0, 3) as $link)
                <a class="hover:text-brand-primary transition-colors {{ request()->routeIs($link['route']) ? 'text-brand-primary' : '' }}" href="{{ route($link['route']) }}">{{ $link['name'] }}</a>
            @endforeach
        </div>

        <!-- Center: Logo -->
        <div class="absolute left-1/2 -translate-x-1/2 text-center">
            <a class="text-xl font-extrabold tracking-tighter text-brand-dark dark:text-white" href="{{ route('home') }}">
                TK<span class="text-brand-primary">.</span><span class="text-[10px] font-medium tracking-normal ml-1">HARAPAN BANGSA 1</span>
            </a>
        </div>

        <!-- Right: Desktop Links / Toggle -->
        <div class="flex items-center space-x-8">
            <div class="hidden md:flex items-center space-x-8 text-[10px] font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300">
                @foreach(array_slice($navLinks, 3) as $link)
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

        <nav class="p-6 space-y-6 flex-grow overflow-y-auto">
            @foreach($navLinks as $link)
                <a class="block text-xs font-bold uppercase tracking-widest hover:text-brand-primary transition-colors text-brand-dark dark:text-stone-300 {{ request()->routeIs($link['route']) ? 'text-brand-primary' : '' }}" href="{{ route($link['route']) }}">{{ $link['name'] }}</a>
            @endforeach
            
            <div class="pt-6 border-t border-stone-100 dark:border-stone-800">
                @guest('siswa')
                    <button onclick="showLoginModal(event)" class="w-full bg-brand-dark dark:bg-brand-primary text-white py-4 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-brand-primary transition-all">Daftar Sekarang</button>
                @else
                    <a href="{{ route('spmb.pendaftaran') }}" class="block w-full text-center bg-brand-dark dark:bg-brand-primary text-white py-4 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-brand-primary transition-all">Daftar Sekarang</a>
                @endguest
            </div>
        </nav>
    </div>
</header>
