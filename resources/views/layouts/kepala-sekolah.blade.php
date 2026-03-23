<!DOCTYPE html>
<html lang="id" x-data="{ sidebarCollapsed: localStorage.getItem('kepalaSekolahSidebarCollapsed') === 'true' }" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kepala Sekolah Panel - {{ config('app.name', 'TK PGRI Harapan Bangsa 1') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&opsz=24" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#6B46C1",
                        "sidebar-bg": "#6B46C1",
                        "background-light": "#F5F3FF",
                        "background-dark": "#0F172A",
                        "lavender": "#E9D5FF",
                        "surface": "#FFFFFF",
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1.25rem",
                        "2xl": "1.5rem",
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
        
        .sidebar-collapsed aside .logo-text,
        .sidebar-collapsed aside .nav-text,
        .sidebar-collapsed aside .nav-section-title,
        .sidebar-collapsed aside .system-status {
            display: none;
        }
        
        .sidebar-collapsed aside .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar-collapsed aside .nav-section-divider {
            display: block;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 1rem 0.5rem;
        }
        
        .nav-section-divider {
            display: none;
        }
        
        @media (max-width: 1023px) {
            aside {
                position: fixed;
                height: 100vh;
                z-index: 40;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 18rem !important;
            }
            body.mobile-sidebar-open aside {
                transform: translateX(0);
            }
            body.mobile-sidebar-open {
                overflow: hidden;
            }
            .sidebar-collapsed aside .logo-text,
            .sidebar-collapsed aside .nav-text,
            .sidebar-collapsed aside .nav-section-title,
            .sidebar-collapsed aside .system-status {
                display: block;
            }
            .sidebar-collapsed aside .nav-item {
                justify-content: flex-start;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .sidebar-collapsed aside .nav-section-divider {
                display: none;
            }
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">

    <div id="loadingOverlay" class="fixed inset-0 bg-white dark:bg-slate-900 bg-opacity-90 flex items-center justify-center z-[60] hidden">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-slate-600 dark:text-slate-300 font-medium">Memuat...</p>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
        @include('layouts.partials.kepala-sekolah-sidebar')

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('layouts.partials.kepala-sekolah-header')

            <main class="flex-1 overflow-y-auto px-8 pb-8">
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

                @if($errors->any())
                <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl shadow-sm flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">warning</span>
                    <div class="flex-1">
                        <p class="text-amber-800 dark:text-amber-200 font-medium">Terdapat kesalahan:</p>
                        <ul class="mt-1 text-sm text-amber-700 dark:text-amber-300 list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="text-amber-600 hover:text-amber-800 flex-shrink-0" onclick="this.closest('div').remove()">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                @endif

                @hasSection('title')
                <div class="mb-6">
                    <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-slate-800 dark:text-slate-100 leading-tight">@yield('title')</h1>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-2 text-sm text-slate-500 dark:text-slate-400">
                        <a href="{{ route('kepala-sekolah.dashboard') }}" class="hover:text-primary transition-colors shrink-0">Dashboard</a>
                        <span class="material-symbols-outlined text-[14px] shrink-0">chevron_right</span>
                        <span class="font-medium text-slate-600 dark:text-slate-300">@yield('breadcrumb')</span>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <div id="mobileSidebarOverlay"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden"
         onclick="this.classList.add('hidden'); document.body.classList.remove('mobile-sidebar-open')"></div>

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
                var el = document.getElementById('loadingOverlay');
                if (el) el.classList.remove('hidden');
            };
            window.hideLoading = function() {
                var el = document.getElementById('loadingOverlay');
                if (el) el.classList.add('hidden');
            };
        });

        function confirmLogout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
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
                document.dispatchEvent(new CustomEvent('close-all-menus'));
                document.body.classList.remove('mobile-sidebar-open');
                var overlay = document.getElementById('mobileSidebarOverlay');
                if (overlay) overlay.classList.add('hidden');
            }
        });

        // Mobile sidebar toggle
        document.getElementById('mobileMenuButton')?.addEventListener('click', function() {
            document.body.classList.toggle('mobile-sidebar-open');
            const overlay = document.getElementById('mobileSidebarOverlay');
            if (overlay) {
                overlay.classList.toggle('hidden', !document.body.classList.contains('mobile-sidebar-open'));
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
