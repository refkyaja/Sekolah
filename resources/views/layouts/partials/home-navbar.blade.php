{{-- =============================================
     Navbar: layouts/partials/home-navbar.blade.php
     Digunakan oleh: layouts/home.blade.php
     ============================================= --}}
<nav id="homepage-navbar" class="fixed top-0 z-50 w-full">
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

                @guest('siswa')
                    <button onclick="showLoginModal(event)"
                            class="bg-primary hover:opacity-90 text-white px-6 lg:px-8 py-3 rounded-full text-sm font-bold transition-all shadow-lg shadow-primary/20">
                        Daftar Sekarang
                    </button>
                @else
                    <a href="{{ route('ppdb.index') }}"
                       class="bg-primary hover:opacity-90 text-white px-6 lg:px-8 py-3 rounded-full text-sm font-bold transition-all shadow-lg shadow-primary/20">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>

            {{-- Mobile Toggle --}}
            <div class="md:hidden" data-home-animate="fade-left" style="--animate-delay: 100ms;">
                <button class="p-2 text-primary focus:outline-none" id="menu-toggle">
                    <span class="material-symbols-outlined text-3xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="md:hidden bg-white border-b border-slate-100" id="mobile-menu">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="{{ route('home') }}"
               class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('home') ? 'text-primary bg-slate-50' : 'text-slate-600 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('profil') }}"
               class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('profil') ? 'text-primary bg-slate-50' : 'text-slate-600 hover:bg-slate-50' }}">
                Profil
            </a>
            <a href="{{ route('kurikulum') }}"
               class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('kurikulum') ? 'text-primary bg-slate-50' : 'text-slate-600 hover:bg-slate-50' }}">
                Kurikulum
            </a>
            <a href="{{ route('ppdb.index') }}"
               class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('ppdb.*') ? 'text-primary bg-slate-50' : 'text-slate-600 hover:bg-slate-50' }}">
                PPDB
            </a>
            <a href="{{ route('informasi') }}"
               class="block px-4 py-3 text-base font-semibold rounded-xl {{ request()->routeIs('informasi') || request()->routeIs('berita.*') || request()->routeIs('galeri.*') ? 'text-primary bg-slate-50' : 'text-slate-600 hover:bg-slate-50' }}">
                Informasi
            </a>
            <div class="pt-4 px-4">
                @guest('siswa')
                    <button onclick="showLoginModal(event)"
                            class="w-full bg-primary text-white py-4 rounded-full text-base font-bold shadow-lg">
                        Daftar Sekarang
                    </button>
                @else
                    <a href="{{ route('ppdb.index') }}"
                       class="block w-full bg-primary text-white py-4 rounded-full text-base font-bold shadow-lg text-center">
                        Daftar Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- Login Modal (untuk tamu) --}}
@guest('siswa')
<div id="login-modal"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     style="display:none">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden border-4 border-primary">
        <button onclick="closeLoginModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
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
    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon   = document.getElementById('menu-icon');
    const navbar = document.getElementById('homepage-navbar');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => {
            const isActive = mobileMenu.classList.toggle('active');
            menuIcon.textContent = isActive ? 'close' : 'menu';
        });
    }

    // Auto-hide navbar on scroll
    let lastScrollTop = 0;
    let scrollThreshold = 100;
    let isNavbarHidden = false;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        // Hide navbar when scrolling down
        if (currentScroll > lastScrollTop && currentScroll > scrollThreshold) {
            if (!isNavbarHidden) {
                navbar.style.transform = 'translateY(-100%)';
                isNavbarHidden = true;
                
                // Close mobile menu when navbar hides
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    menuIcon.textContent = 'menu';
                }
            }
        }
        // Show navbar when scrolling up
        else if (currentScroll < lastScrollTop) {
            if (isNavbarHidden) {
                navbar.style.transform = 'translateY(0)';
                isNavbarHidden = false;
            }
        }
        
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });

    function showLoginModal(e) {
        if (e) e.preventDefault();
        const modal = document.getElementById('login-modal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }
    }

    function closeLoginModal() {
        const modal = document.getElementById('login-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }
    }

    // Tutup modal jika klik di luar
    document.getElementById('login-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeLoginModal();
    });
</script>
@endpush
