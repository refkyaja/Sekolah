<!DOCTYPE html>
<html lang="id" x-data="{ sidebarCollapsed: localStorage.getItem('siswaSidebarCollapsed') === 'true', mobileSidebarOpen: false }" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Siswa - {{ config('app.name', 'TK PGRI Harapan Bangsa 1') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&opsz=24" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#7f19e6",
                        "background-light": "#f7f6f8",
                        "background-dark": "#191121",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Lexend', sans-serif;
            }
        }
        [x-cloak] { display: none !important; }
        
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        aside {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-collapsed aside {
            width: 80px;
        }
        
        .sidebar-collapsed aside .sidebar-header {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
        }

        .sidebar-collapsed aside .sidebar-header > div:first-child {
            gap: 0;
        }

        .sidebar-collapsed aside .nav-item,
        .sidebar-collapsed aside .sidebar-header,
        .sidebar-collapsed aside .profile-container,
        .sidebar-collapsed aside .logout-button {
            justify-content: center;
        }

        .sidebar-collapsed aside .nav-item,
        .sidebar-collapsed aside .profile-container,
        .sidebar-collapsed aside .logout-button {
            padding-left: 0;
            padding-right: 0;
            gap: 0;
        }

        .sidebar-collapsed aside .profile-card {
            padding: 0.75rem 0;
            background: transparent;
            border-color: transparent;
        }

        .sidebar-collapsed aside .profile-container {
            margin-bottom: 0;
        }

        .sidebar-collapsed aside .logo-text,
        .sidebar-collapsed aside .nav-text,
        .sidebar-collapsed aside .logout-button span:not(.material-symbols-outlined) {
            display: none;
        }
        
        @media (max-width: 1023px) {
            aside {
                position: fixed;
                height: 100vh;
                z-index: 40;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .mobile-sidebar-open aside {
                transform: translateX(0);
            }
            .mobile-sidebar-open {
                overflow: hidden;
            }
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased min-h-screen">

    <div id="loadingOverlay" class="fixed inset-0 bg-white dark:bg-slate-900 bg-opacity-90 flex items-center justify-center z-[60] hidden" x-cloak x-show="false" @show-loading.window="document.getElementById('loadingOverlay').classList.remove('hidden')" @hide-loading.window="document.getElementById('loadingOverlay').classList.add('hidden')">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-slate-600 dark:text-slate-300 font-medium">Memuat...</p>
        </div>
    </div>

    <div class="flex min-h-screen">
        @include('layouts.partials.siswa-sidebar')

        <main class="flex-1 ml-0 p-4 lg:p-8 transition-all duration-300"
             :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'">
            <!-- Header -->
            <header class="flex items-center justify-between mb-6 lg:mb-10 gap-4">
                <div class="flex items-center gap-3 flex-1">
                    <!-- Mobile Menu Toggle -->
                    <button class="lg:hidden p-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 flex items-center transition-all hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm"
                            @click="mobileSidebarOpen = true">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    
                    {{-- Include Global Header Partial (Home Button + Clock) --}}
                    @include('layouts.partials.waktu-header')
                </div>

                {{-- Opsi tambahan jika diperlukan di masa depan bisa diletakkan di sini --}}
            </header>

            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl shadow-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400 flex-shrink-0">check_circle</span>
                <p class="text-green-800 dark:text-green-200 font-medium flex-1">{{ session('success') }}</p>
                <button type="button" class="text-green-600 hover:text-green-800 flex-shrink-0" onclick="this.closest('div').remove()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl shadow-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 flex-shrink-0">error</span>
                <p class="text-red-800 dark:text-red-200 font-medium flex-1">{{ session('error') }}</p>
                <button type="button" class="text-red-600 hover:text-red-800 flex-shrink-0" onclick="this.closest('div').remove()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <div id="mobileSidebarOverlay"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"
         x-cloak
         x-show="mobileSidebarOpen"
         @click="mobileSidebarOpen = false"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTime() {
                var now = new Date();
                var h = now.getHours().toString().padStart(2, '0');
                var m = now.getMinutes().toString().padStart(2, '0');
                var footerTime = document.getElementById('footerTime');
                if (footerTime) footerTime.textContent = h + ':' + m;
            }
            updateTime();
            setInterval(updateTime, 60000);

            window.showLoading = function() {
                window.dispatchEvent(new CustomEvent('show-loading'));
            };
            window.hideLoading = function() {
                window.dispatchEvent(new CustomEvent('hide-loading'));
            };
        });

        function confirmLogout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#7f19e6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed && document.getElementById('logoutForm')) {
                        document.getElementById('logoutForm').submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari sistem?') && document.getElementById('logoutForm')) {
                    document.getElementById('logoutForm').submit();
                }
            }
        }

        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM' && !e.target.classList.contains('no-loading')) {
                window.showLoading();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Alpine will handle this if we set it, but for a global escape:
                window.dispatchEvent(new CustomEvent('close-sidebar'));
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
