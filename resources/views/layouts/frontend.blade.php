<!DOCTYPE html>
<html lang="id" class="light" x-data>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Playful Kids School | Learning with Joy')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Nunito:wght@400;600;700;800&family=Material+Icons&display=swap" rel="stylesheet">
    <link rel="stylesheet"
href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Tailwind CSS with custom config -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
            extend: {
                colors: {
                primary: "#114B5F", // Dark teal from the "Enroll Now" button
                "background-light": "#FFFFFF",
                "background-dark": "#0F172A",
                accent: {
                    yellow: "#FBED8B",
                    pink: "#FBC3D9",
                    purple: "#D3C4F3",
                    blue: "#CCF0F5"
                }
                },
                fontFamily: {
                display: ["Fredoka", "sans-serif"],
                body: ["Nunito", "sans-serif"],
                },
                borderRadius: {
                DEFAULT: "1rem",
                'xl': '1.5rem',
                '2xl': '2rem',
                },
            },
            },
        };
    </script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Fredoka', sans-serif; }
        .wavy-bg {
            border-bottom-left-radius: 50% 10%;
            border-bottom-right-radius: 50% 10%;
        }
        .bubble-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 transition-colors duration-300">
    
    @include('layouts.front-navbar')
    
    <!-- Content -->
    <main>
        @yield('content')
    </main>
    
    @include('layouts.front-footer')

    <!-- Login Required Modal -->
    <div id="login-modal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden border-4 border-primary">
            <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <span class="material-icons">close</span>
            </button>
            <div class="text-center">
                <div class="w-20 h-20 bg-primary/10 text-primary rounded-3xl flex items-center justify-center mx-auto mb-6 transform -rotate-6">
                    <span class="material-icons text-5xl">lock</span>
                </div>
                <h3 class="text-3xl font-bold mb-2">Login Diperlukan</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">Silakan login terlebih dahulu untuk dapat melanjutkan proses pendaftaran siswa baru di Vidya Mandir.</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('siswa.login') }}" class="w-full bg-primary text-white py-4 rounded-2xl font-bold text-center hover:scale-105 transition-transform shadow-lg shadow-primary/20 text-lg">Login Sekarang</a>
                    <button onclick="closeLoginModal()" class="w-full py-3 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Batal</button>
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
</body>
</html>