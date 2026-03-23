<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'PPDB - Vidya Mandir')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#f49d25',
                            soft: '#fff7ed',
                            cream: '#fafaf9',
                            dark: '#1c1917',
                        },
                        "primary": "#f49d25",
                        "secondary": "#3b82f6",
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .wavy-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(244, 157, 37, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .blob {
            position: absolute;
            z-index: -1;
            filter: blur(40px);
            opacity: 0.15;
        }
    </style>
    <script>
        // Check for dark mode preference
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @stack('meta')
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 wavy-bg">
<div class="relative flex min-h-screen flex-col overflow-x-hidden">
<!-- Header / Navigation -->
<header class="sticky top-0 z-50 bg-white/80 dark:bg-brand-dark/80 backdrop-blur-md border-b border-stone-100 px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-brand-primary p-2 rounded-xl text-white">
                <span class="material-symbols-outlined block">school</span>
            </div>
            <a href="{{ url('/') }}">
                <h2 class="text-sm font-extrabold tracking-widest text-brand-dark dark:text-white uppercase">Harapan Bangsa 1</h2>
            </a>
        </div>
        <nav class="hidden md:flex items-center gap-8">
            <a class="text-[10px] font-bold uppercase tracking-widest hover:text-brand-primary transition-colors" href="{{ url('/') }}">Beranda</a>
            <a class="text-[10px] font-bold uppercase tracking-widest text-brand-primary" href="{{ route('ppdb.index') }}">PPDB Online</a>
        </nav>
        <div class="flex items-center gap-4">
            @php
                $tahunAjaranAktif = App\Models\TahunAjaran::where('is_aktif', true)->first();
                $setting = $tahunAjaranAktif ? App\Models\SpmbSetting::where('tahun_ajaran_id', $tahunAjaranAktif->id)->first() : null;
                $now = now();
                $isPendaftaranOpen = $setting && $setting->pendaftaran_mulai && $setting->pendaftaran_selesai && $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);
            @endphp
            @if($isPendaftaranOpen)
                @guest('siswa')
                <button onclick="showLoginModal(event)" class="bg-brand-dark dark:bg-brand-primary text-white px-8 py-2.5 rounded-full font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg">
                    Daftar
                </button>
                @else
                <a href="{{ route('ppdb.index') }}" class="bg-brand-dark dark:bg-brand-primary text-white px-8 py-2.5 rounded-full font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg">
                    Daftar
                </a>
                @endguest
            @else
            <button class="bg-stone-300 text-white px-8 py-2.5 rounded-full font-bold text-[10px] uppercase tracking-widest cursor-not-allowed">
                Tutup
            </button>
            @endif
            <button id="theme-toggle" type="button" class="text-stone-500 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-700 rounded-lg p-2 transition-colors">
                <span id="theme-toggle-dark-icon" class="hidden material-symbols-outlined">dark_mode</span>
                <span id="theme-toggle-light-icon" class="hidden material-symbols-outlined">light_mode</span>
            </button>
        </div>
    </div>
</header>

<main class="flex-1">
    @yield('content')
</main>

<!-- Login Required Modal -->
<div id="login-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4" style="display: none;">
    <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-brand-primary"></div>
        <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-600 dark:hover:text-stone-200">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="text-center">
            <div class="w-16 h-16 bg-brand-primary/10 text-brand-primary rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl">lock</span>
            </div>
            <h3 class="text-2xl font-extrabold uppercase tracking-tight mb-2">Login Diperlukan</h3>
            <p class="text-stone-500 dark:text-stone-400 mb-8 text-sm leading-relaxed">Silakan login terlebih dahulu untuk dapat melanjutkan proses pendaftaran siswa baru.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('siswa.login') }}" class="w-full bg-brand-dark text-white py-3 rounded-xl font-bold uppercase tracking-widest text-[10px] text-center hover:bg-brand-primary transition-colors shadow-lg">Login Sekarang</a>
                <button onclick="closeLoginModal()" class="w-full py-3 rounded-xl font-bold text-stone-500 text-[10px] uppercase tracking-widest hover:bg-stone-50 dark:hover:bg-stone-800 transition-colors">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-brand-cream dark:bg-brand-dark border-t border-stone-100 dark:border-stone-800 pt-20 pb-10 px-6 mt-12">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-brand-primary p-2 rounded-xl text-white">
                        <span class="material-symbols-outlined block">school</span>
                    </div>
                    <h2 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark dark:text-white">Harapan Bangsa 1</h2>
                </div>
                <p class="text-stone-500 dark:text-stone-400 max-w-sm text-xs leading-relaxed mb-6 font-medium">
                    Membentuk landasan yang kokoh untuk masa depan cerah anak Anda melalui pendidikan yang penuh kasih dan inovatif.
                </p>
                <div class="flex gap-4">
                    <a class="w-10 h-10 rounded-full bg-white dark:bg-stone-800 flex items-center justify-center text-stone-400 hover:bg-brand-primary hover:text-white transition-all shadow-sm" href="#">
                        <span class="material-symbols-outlined text-sm">share</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-white dark:bg-stone-800 flex items-center justify-center text-stone-400 hover:bg-brand-primary hover:text-white transition-all shadow-sm" href="#">
                        <span class="material-symbols-outlined text-sm">camera_alt</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-white dark:bg-stone-800 flex items-center justify-center text-stone-400 hover:bg-brand-primary hover:text-white transition-all shadow-sm" href="#">
                        <span class="material-symbols-outlined text-sm">mail</span>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-brand-dark dark:text-white mb-6">Link Cepat</h4>
                <ul class="space-y-4 text-stone-400 text-[10px] font-bold uppercase tracking-widest">
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Visi & Misi</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Program Studi</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Fasilitas</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Ekstrakurikuler</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-brand-dark dark:text-white mb-6">Kontak</h4>
                <ul class="space-y-6 text-stone-400 text-[10px] font-bold uppercase tracking-widest">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-brand-primary text-lg">location_on</span>
                        <span class="leading-relaxed">Jl. Pendidikan No. 123, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-brand-primary text-lg">call</span>
                        <span>(021) 555-0123</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-brand-primary text-lg">mail</span>
                        <span>info@harapanbangsa.sch.id</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-stone-100 dark:border-stone-800 pt-8 text-center text-[10px] font-bold uppercase tracking-widest text-stone-300">
            <p>© 2026 Harapan Bangsa 1. All rights reserved.</p>
        </div>
    </div>
</footer>
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

    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {
        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

        // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
</script>
</body>
</html>
