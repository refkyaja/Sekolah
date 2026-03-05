<!DOCTYPE html>
<html lang="id" x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'TK Harapan Bangsa 2') }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#4c99e6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        
        aside {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-collapsed aside {
            width: 80px;
        }
        
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-header-text,
        .sidebar-collapsed .sidebar-footer-text {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        
        .sidebar-collapsed .sidebar-logo-container {
            justify-content: center;
        }
        
        .sidebar-collapsed .sidebar-footer-container {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar-toggle-icon {
            transition: transform 0.3s ease;
        }
        
        .sidebar-collapsed .sidebar-toggle-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 1023px) {
            aside {
                position: fixed;
                height: 100vh;
                z-index: 40;
                transform: translateX(-100%);
            }
            .mobile-sidebar-open aside {
                transform: translateX(0);
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100" 
      x-data="{ mobileSidebarOpen: false }"
      :class="{ 'mobile-sidebar-open': mobileSidebarOpen }">
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.partials.teacher-sidebar')

        <!-- Mobile Backdrop -->
        <div x-show="mobileSidebarOpen" 
             @click="mobileSidebarOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header class="sticky top-0 z-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-500">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">@yield('header_title', 'Dashboard Guru')</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="relative hidden md:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                        <input class="pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-lg focus:ring-2 focus:ring-primary w-64 text-sm" placeholder="Cari informasi..." type="text"/>
                    </div>
                    <button class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto w-full">
                <div class="p-8 max-w-7xl mx-auto w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
