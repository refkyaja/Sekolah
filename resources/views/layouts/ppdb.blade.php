<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendaftaran PPDB - TK Ceria Bangsa')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#f49d25',
                            soft: '#fff7ed',
                            cream: '#fafaf9',
                            dark: '#1c1917',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        body { font-family: 'Plus Jakarta Sans', 'sans-serif'; }
        .hover-zoom img { transition: transform 0.5s ease; }
        .hover-zoom:hover img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-brand-cream text-brand-dark transition-colors duration-300">

    <!-- Navigation Bar (Minimalist) -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-stone-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-primary rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-school text-lg"></i>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-sm font-extrabold uppercase tracking-widest leading-none">Harapan Bangsa 1</h1>
                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tighter mt-1">Quality Education</p>
                </div>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-10">
                <a href="{{ url('/') }}" class="text-[10px] font-bold uppercase tracking-widest hover:text-brand-primary transition-colors">Beranda</a>
                <a href="{{ route('ppdb.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-brand-primary">PPDB Online</a>
                @guest('siswa')
                <button onclick="showLoginModal(event)" class="bg-brand-dark text-white px-8 py-3 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-brand-primary transition-all shadow-lg shadow-stone-200">Daftar</button>
                @else
                <a href="{{ route('ppdb.index') }}" class="bg-brand-dark text-white px-8 py-3 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-brand-primary transition-all shadow-lg shadow-stone-200">Daftar</a>
                @endguest
            </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-700" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    @guest('siswa')
                    <button onclick="showLoginModal(event)" class="block w-full text-left px-3 py-2 bg-blue-600 text-white rounded">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </button>
                    @else
                    <a href="{{ route('ppdb.index') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer (Minimalist) -->
    <footer class="bg-brand-cream py-20 text-stone-600">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-20 px-4">
                <div class="col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-brand-primary rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark">Harapan Bangsa 1</h3>
                    </div>
                    <p class="text-xs font-medium leading-relaxed max-w-sm">Membentuk landasan yang kokoh untuk masa depan cerah anak Anda melalui pendidikan yang penuh kasih dan inovatif.</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest text-brand-dark mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-[10px] font-bold uppercase tracking-wider">
                        <li><a href="{{ url('/') }}" class="hover:text-brand-primary">Beranda</a></li>
                        <li><a href="{{ route('ppdb.index') }}" class="hover:text-brand-primary">PPDB Online</a></li>
                        <li><a href="#" class="hover:text-brand-primary">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest text-brand-dark mb-6">Hubungi Kami</h4>
                    <p class="text-[10px] font-bold uppercase tracking-widest leading-loose">
                        Jl. Pendidikan No. 123<br>
                        Jakarta Pusat 10110<br>
                        (021) 1234-5678
                    </p>
                </div>
            </div>
            <div class="border-t border-stone-200 pt-10 text-center">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-stone-400">© {{ date('Y') }} Harapan Bangsa 1. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Required Modal -->
    <div id="login-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>
            <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lock text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Login Diperlukan</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">Silakan login terlebih dahulu untuk dapat melanjutkan proses pendaftaran siswa baru.</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('siswa.login') }}" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-center hover:bg-blue-700 transition-colors shadow-lg">Login Sekarang</a>
                    <button onclick="closeLoginModal()" class="w-full py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-colors">Batal</button>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        function showLoginModal(e) {
            if (e) e.preventDefault();
            console.log('Opening login modal...');
            const modal = document.getElementById('login-modal');
            if (modal) {
                modal.style.setProperty('display', 'flex', 'important');
                modal.classList.remove('hidden');
            } else {
                console.error('Login modal element not found!');
            }
        }

        function closeLoginModal() {
            const modal = document.getElementById('login-modal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }
        }
    </script>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileButton = document.getElementById('mobile-menu-button');
            
            if (!mobileMenu.contains(event.target) && !mobileButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
