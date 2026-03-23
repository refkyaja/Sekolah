{{-- =============================================
     Navbar: layouts/partials/home-navbar.blade.php
     Digunakan oleh: layouts/home.blade.php
     ============================================= --}}
<nav id="homepage-navbar" class="fixed top-0 z-50 w-full transition-transform duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="home-navbar-shell flex justify-between h-20 md:h-24 items-center bg-white/90 backdrop-blur-md border-b border-slate-100 px-4 md:px-6">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3" data-home-animate="fade-right" style="--animate-delay: 40ms;">
                <div class="size-10 bg-primary rounded-xl flex items-center justify-center text-white shrink-0">
                    <span class="material-symbols-outlined text-2xl">school</span>
                </div>
                <div>
                    <h1 class="text-lg md:text-xl font-extrabold leading-none text-primary">TK PGRI</h1>
                    <p class="text-[9px] md:text-[10px] font-bold tracking-widest text-slate-400 uppercase">Harapan Bangsa 1</p>
                </div>
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8 lg:gap-10" data-home-animate="fade-left" style="--animate-delay: 100ms;">
                <a href="{{ route('home') }}"
                   class="text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}">
                    Beranda
                </a>
                <a href="{{ route('profil') }}"
                   class="text-sm font-semibold transition-colors {{ request()->routeIs('profil') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}">
                    Profil
                </a>
                <a href="{{ route('kurikulum') }}"
                   class="text-sm font-semibold transition-colors {{ request()->routeIs('kurikulum') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}">
                    Kurikulum
                </a>
                <a href="{{ route('ppdb.index') }}"
                   class="text-sm font-semibold transition-colors {{ request()->routeIs('ppdb.*') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}">
                    PPDB
                </a>
                <a href="{{ route('informasi') }}"
                   class="text-sm font-semibold transition-colors {{ request()->routeIs('informasi') || request()->routeIs('berita.*') || request()->routeIs('galeri.*') ? 'text-primary' : 'text-slate-600 hover:text-primary' }}">
                    Informasi
                </a>

                @auth('siswa')
                    {{-- User Profile Dropdown --}}
                    <div class="relative" id="profile-dropdown-container">
                        <button id="profile-dropdown-toggle" class="flex items-center gap-3 p-1 pr-4 bg-slate-50 hover:bg-slate-100 rounded-full transition-all border border-slate-100 shadow-sm active:scale-95">
                            <img src="{{ auth('siswa')->user()->foto_url }}" class="size-10 rounded-full object-cover border-2 border-primary shadow-sm" alt="Profile">
                            <div class="text-left hidden lg:block">
                                <p class="text-[11px] font-black text-slate-900 leading-none whitespace-nowrap">{{ auth('siswa')->user()->nama_lengkap }}</p>
                                <p class="text-[9px] text-slate-500 font-bold mt-1 uppercase tracking-widest">Siswa Portal</p>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 text-lg transition-transform duration-300" id="profile-chevron">expand_more</span>
                        </button>
                        
                        <div id="profile-dropdown" class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 py-3 opacity-0 pointer-events-none -translate-y-2 transition-all duration-300 z-50 overflow-hidden ring-1 ring-black/5">
                            <div class="px-5 py-3 border-b border-slate-100 mb-2 lg:hidden">
                                <p class="text-xs font-black text-slate-900 leading-tight truncate">{{ auth('siswa')->user()->nama_lengkap }}</p>
                                <p class="text-[10px] text-primary font-bold mt-0.5">Siswa Aktif</p>
                            </div>
                            <a href="{{ route('siswa.profile') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary/5 transition-all">
                                <div class="size-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-xl">person</span>
                                </div>
                                <span>Info Profil</span>
                            </a>
                            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary/5 transition-all">
                                <div class="size-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-xl">dashboard</span>
                                </div>
                                <span>Lihat Dashboard</span>
                            </a>
                            <div class="mx-3 my-2 border-t border-slate-100"></div>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm font-bold text-red-600 hover:bg-red-50 transition-all">
                                    <div class="size-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xl">logout</span>
                                    </div>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button onclick="showLoginModal(event)"
                            class="bg-primary hover:opacity-90 text-white px-6 lg:px-8 py-3 rounded-full text-sm font-bold transition-all shadow-lg shadow-primary/20 hover:scale-105 active:scale-95">
                        Daftar Sekarang
                    </button>
                @endauth
            </div>

            {{-- Mobile Toggle --}}
            <div class="md:hidden" data-home-animate="fade-left" style="--animate-delay: 100ms;">
                <button class="p-2 text-primary focus:outline-none" id="menu-toggle">
                    <span class="material-symbols-outlined text-3xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Floating Mobile Menu --}}
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden md:hidden" style="background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
    <div class="absolute top-24 left-0 right-0 px-4" id="mobile-menu-container">
        <div class="bg-white/95 backdrop-blur-md rounded-[2rem] shadow-2xl overflow-hidden border border-slate-100 transform transition-all duration-300 scale-95 opacity-0" id="mobile-menu-content">
            <div class="p-6 space-y-2">
                <a href="{{ route('home') }}"
                   class="block px-4 py-3 text-base font-bold rounded-xl transition-colors {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'text-slate-600 hover:bg-slate-50' }}">
                    Beranda
                </a>
                <a href="{{ route('profil') }}"
                   class="block px-4 py-3 text-base font-bold rounded-xl transition-colors {{ request()->routeIs('profil') ? 'text-primary bg-primary/10' : 'text-slate-600 hover:bg-slate-50' }}">
                    Profil
                </a>
                <a href="{{ route('kurikulum') }}"
                   class="block px-4 py-3 text-base font-bold rounded-xl transition-colors {{ request()->routeIs('kurikulum') ? 'text-primary bg-primary/10' : 'text-slate-600 hover:bg-slate-50' }}">
                    Kurikulum
                </a>
                <a href="{{ route('ppdb.index') }}"
                   class="block px-4 py-3 text-base font-bold rounded-xl transition-colors {{ request()->routeIs('ppdb.*') ? 'text-primary bg-primary/10' : 'text-slate-600 hover:bg-slate-50' }}">
                    PPDB
                </a>
                <a href="{{ route('informasi') }}"
                   class="block px-4 py-3 text-base font-bold rounded-xl transition-colors {{ request()->routeIs('informasi') || request()->routeIs('berita.*') || request()->routeIs('galeri.*') ? 'text-primary bg-primary/10' : 'text-slate-600 hover:bg-slate-50' }}">
                    Informasi
                </a>
                
                <div class="pt-4 border-t border-slate-100 mt-2">
                    @auth('siswa')
                        <div class="space-y-3">
                            <div class="flex items-center gap-4 p-4 bg-primary/5 rounded-2xl border border-primary/10">
                                <img src="{{ auth('siswa')->user()->foto_url }}" class="size-12 rounded-xl object-cover border-2 border-white shadow-sm" alt="Profile">
                                <div class="flex-1 overflow-hidden">
                                    <p class="font-black text-slate-900 truncate text-sm">{{ auth('siswa')->user()->nama_lengkap }}</p>
                                    <p class="text-[10px] text-primary font-bold uppercase tracking-widest mt-0.5">Siswa Portal</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('siswa.profile') }}" class="flex flex-col items-center gap-2 p-4 bg-slate-50 rounded-2xl border border-slate-100 font-bold text-[11px] text-slate-600 active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-primary text-2xl">person</span> 
                                    <span>Profil</span>
                                </a>
                                <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center gap-2 p-4 bg-slate-50 rounded-2xl border border-slate-100 font-bold text-[11px] text-slate-600 active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-primary text-2xl">dashboard</span> 
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <form action="{{ route('siswa.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-red-50 text-red-600 font-bold text-sm active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-lg">logout</span> Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <button onclick="showLoginModal(event)"
                                class="w-full bg-primary text-white py-4 rounded-xl text-base font-bold shadow-[0_10px_20px_rgba(0,0,0,0.1)] transition-all active:scale-95">
                            Daftar Sekarang
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Login Modal (untuk tamu) --}}
@guest('siswa')
<div id="login-modal"
     class="fixed inset-0 z-[110] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     style="display:none">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden border-4 border-primary">
        <button onclick="closeLoginModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 active:scale-90 transition-all">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="text-center">
            <div class="w-20 h-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center mx-auto mb-6 -rotate-6">
                <span class="material-symbols-outlined text-5xl">lock</span>
            </div>
            <h3 class="text-2xl font-bold mb-2">Login Diperlukan</h3>
            <p class="text-slate-500 mb-8 leading-relaxed">Silakan login terlebih dahulu untuk dapat mendaftar PPDB secara online.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('siswa.login') }}"
                   class="w-full bg-primary text-white py-4 rounded-2xl font-bold text-center hover:scale-105 transition-transform shadow-lg shadow-primary/20 text-lg">
                    Login Sekarang
                </a>
                <a href="{{ route('siswa.register') }}"
                   class="w-full bg-primary/10 text-primary py-3 rounded-2xl font-bold text-center hover:bg-primary/20 transition-colors">
                    Buat Akun Baru
                </a>
                <button onclick="closeLoginModal()"
                        class="w-full py-3 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endguest

@push('scripts')
<script>
    // Elements
    const menuToggle = document.getElementById('menu-toggle');
    const menuOverlay = document.getElementById('mobile-menu-overlay');
    const menuContent = document.getElementById('mobile-menu-content');
    const menuIcon = document.getElementById('menu-icon');
    const navbar = document.getElementById('homepage-navbar');
    const profileToggle = document.getElementById('profile-dropdown-toggle');
    const profileDropdown = document.getElementById('profile-dropdown');
    const profileChevron = document.getElementById('profile-chevron');
    
    let isMenuOpen = false;
    let isProfileOpen = false;
    let scrollTimeout;

    // --- Profile Dropdown Functions ---
    function toggleProfileDropdown() {
        if (!profileDropdown) return;
        
        isProfileOpen = !isProfileOpen;
        
        if (isProfileOpen) {
            profileDropdown.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-2');
            profileDropdown.classList.add('opacity-100', 'translate-y-0');
            if (profileChevron) profileChevron.style.transform = 'rotate(180deg)';
        } else {
            profileDropdown.classList.add('opacity-0', 'pointer-events-none', '-translate-y-2');
            profileDropdown.classList.remove('opacity-100', 'translate-y-0');
            if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
        }
    }

    if (profileToggle) {
        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleProfileDropdown();
        });
    }

    // --- Mobile Menu Functions ---
    function openMobileMenu() {
        if (!menuOverlay || !menuContent) return;
        menuOverlay.classList.remove('hidden');
        setTimeout(() => {
            menuContent.classList.remove('scale-95', 'opacity-0');
            menuContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        isMenuOpen = true;
        if (menuIcon) menuIcon.textContent = 'close';
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        if (!menuOverlay || !menuContent) return;
        menuContent.classList.remove('scale-100', 'opacity-100');
        menuContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            menuOverlay.classList.add('hidden');
            isMenuOpen = false;
            if (menuIcon) menuIcon.textContent = 'menu';
            document.body.style.overflow = '';
        }, 300);
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isMenuOpen) closeMobileMenu();
            else openMobileMenu();
        });
    }

    // --- Global Click Listener (Close dropdowns) ---
    document.addEventListener('click', (e) => {
        // Close profile dropdown
        if (isProfileOpen && !e.target.closest('#profile-dropdown-container')) {
            toggleProfileDropdown();
        }
        
        // Close mobile menu if clicking overlay
        if (isMenuOpen && e.target === menuOverlay) {
            closeMobileMenu();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (isProfileOpen) toggleProfileDropdown();
            if (isMenuOpen) closeMobileMenu();
        }
    });

    // --- Scroll Logic ---
    let lastScrollTop = 0;
    let scrollThreshold = 50;
    let isNavbarHidden = false;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTimeout) clearTimeout(scrollTimeout);
        
        if (currentScroll > lastScrollTop && currentScroll > scrollThreshold) {
            if (!isNavbarHidden) {
                if (navbar) navbar.style.transform = 'translateY(-100%)';
                isNavbarHidden = true;
                if (isMenuOpen) closeMobileMenu();
                if (isProfileOpen) toggleProfileDropdown();
            }
        }
        else if (currentScroll < lastScrollTop) {
            if (isNavbarHidden) {
                if (navbar) navbar.style.transform = 'translateY(0)';
                isNavbarHidden = false;
            }
        }
        
        if (currentScroll === 0 && isNavbarHidden) {
            if (navbar) navbar.style.transform = 'translateY(0)';
            isNavbarHidden = false;
        }
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });

    // --- Login Modal Functions ---
    function showLoginModal(e) {
        if (e) e.preventDefault();
        const modal = document.getElementById('login-modal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }
        if (isMenuOpen) closeMobileMenu();
    }

    function closeLoginModal() {
        const modal = document.getElementById('login-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }
    }

    document.getElementById('login-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeLoginModal();
    });
</script>
@endpush