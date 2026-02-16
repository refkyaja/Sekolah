<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'TK Ceria Bangsa') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            min-height: 100vh;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .loading-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Sidebar animation */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        
        /* Badge notification */
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            border-radius: 10px;
            animation: pulse 2s infinite;
        }
        
        /* Modal backdrop */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        /* Page transition */
        .page-transition-enter {
            opacity: 0;
            transform: translateY(20px);
        }
        
        .page-transition-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms, transform 300ms;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            #sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 40;
                transform: translateX(-100%);
                width: 280px;
                max-width: 85vw;
            }
            
            #sidebar.sidebar-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            /* Prevent main content scroll when sidebar is open */
            body.sidebar-open {
                overflow: hidden;
            }
        }
        
        @media (max-width: 640px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
            
            .table-container {
                margin-left: -1rem;
                margin-right: -1rem;
            }
        }
        
        /* Touch friendly */
        @media (hover: none) and (pointer: coarse) {
            button, 
            a, 
            input[type="submit"],
            .clickable {
                min-height: 44px;
                min-width: 44px;
            }
            
            select,
            input,
            textarea {
                font-size: 16px; /* Prevents iOS zoom */
            }
        }
        
        /* Sidebar layout */
        .sidebar-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 hidden">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600 font-medium">Memuat...</p>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-transition fixed lg:relative w-[280px] lg:w-[260px] bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-xl z-40 lg:z-auto -translate-x-full lg:translate-x-0 flex flex-col h-full">
            <!-- Sidebar Header -->
            <div class="p-4 lg:p-6 border-b border-gray-700 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-school text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">{{ config('app.name', 'TK Ceria Bangsa') }}</h2>
                            <p class="text-xs text-gray-300">Admin Panel</p>
                        </div>
                    </div>
                    <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Profile Menu - New -->
            <a href="{{ route('admin.profile.index') }}" 
            class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.profile.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200 mb-2 border-b border-gray-700 pb-3">
                <div class="relative">
                    <!-- Foto Profile -->
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center">
                        @auth
                            @if(Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                                    alt="Profile" 
                                    class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.parentElement.innerHTML='{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}';">
                            @else
                                <span class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        @endauth
                    </div>
                    <div class="absolute bottom-0 right-0 w-2 h-2 bg-green-500 rounded-full border-2 border-gray-900"></div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <!-- Nama User -->
                    <span class="block font-medium truncate">
                        @auth
                            {{ Auth::user()->name }}
                        @endauth
                    </span>
                    <!-- Role User -->
                    <span class="text-xs text-gray-400">
                        @auth
                            @switch(Auth::user()->role)
                                @case('admin')
                                    Admin
                                    @break
                                @case('kepala_sekolah')
                                    Kepala Sekolah
                                    @break
                                @case('operator')
                                    Operator
                                    @break
                                @case('guru')
                                    Guru
                                    @break
                                @default
                                    {{ ucfirst(Auth::user()->role) }}
                            @endswitch
                        @endauth
                    </span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-500 ml-2"></i>
            </a>

            <!-- Navigation Menu - Scrollable Area -->
            <div class="sidebar-content overflow-y-auto">
                <nav class="p-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-chart-pie w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('admin.siswa.*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg {{ request()->routeIs('admin.siswa.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg' : 'hover:bg-gray-700 text-gray-300' }} transition-all duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-users w-5 mr-3"></i>
                                <span>Data Siswa</span>
                            </div>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="mt-1 ml-4 pl-4 border-l-2 border-gray-600 space-y-1">

                            <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                                class="flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.siswa.siswa-aktif.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-700' }} transition-all duration-200">
                                <i class="fas fa-user-check w-4 mr-3 text-green-400"></i>
                                <span>Siswa Aktif</span>
                            </a>

                            <a href="{{ route('admin.siswa.siswa-lulus.index') }}" 
                                class="flex items-center px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.siswa.siswa-lulus.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-700' }} transition-all duration-200">
                                <i class="fas fa-graduation-cap w-4 mr-3 text-yellow-400"></i>
                                <span>Siswa Lulus</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.guru.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.guru.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-chalkboard-teacher w-5 mr-3"></i>
                        <span>Data Guru</span>
                    </a>

                    <a href="{{ route('admin.tahun-ajaran.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.tahun-ajaran.*') ? 'bg-gradient-to-r from-amber-600 to-orange-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200 relative">
                        <i class="fas fa-user-plus w-5 mr-3"></i>
                        <span>Tahun Ajaran</span>
                    </a>

                    <a href="{{ route('admin.spmb.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.spmb.*') ? 'bg-gradient-to-r from-amber-600 to-orange-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200 relative">
                        <i class="fas fa-user-plus w-5 mr-3"></i>
                        <span>SPMB</span>
                    </a>

                    <a href="{{ route('admin.spmb-settings.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.spmb-setting.*') ? 'bg-gradient-to-r from-amber-600 to-orange-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200 relative">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Setting SPMB</span>
                    </a>

                    <a href="{{ route('admin.absensi.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.absensi.*') ? 'bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-clipboard-check w-5 mr-3"></i>
                        <span>Absensi</span>
                    </a>

                    <a href="{{ route('admin.berita.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.berita.*') ? 'bg-gradient-to-r from-rose-600 to-pink-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-newspaper w-5 mr-3"></i>
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('admin.galeri.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.galeri.*') ? 'bg-gradient-to-r from-sky-600 to-blue-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-images w-5 mr-3"></i>
                        <span>Galeri</span>
                    </a>

                    <a href="{{ route('admin.bukutamu.index') }}" 
                        class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.bukutamu.*') ? 'bg-gradient-to-r from-green-600 to-emerald-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200">
                        <i class="fas fa-book w-5 mr-3"></i>
                        <span>Buku Tamu</span>
                    </a>

                    <!-- Di bagian navigation menu, setelah Kelola Akun Guru -->
                    <a href="{{ route('admin.accounts.index') }}" 
                    class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.accounts.*') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'hover:bg-gray-700' }} transition-all duration-200 relative">
                        <i class="fas fa-users-cog w-5 mr-3"></i>
                        <span>Kelola Akun</span>
                        @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <span class="absolute right-3 text-xs bg-red-500 text-white px-2 py-0.5 rounded-full">Super</span>
                        @endif
                    </a>

                </nav>

                <!-- Quick Stats -->
                <div class="p-4 mt-6 border-t border-gray-700">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Statistik Cepat</h4>
                    <div class="space-y-2">
                        @php
                            $totalSiswaAktif = 0;
                            $totalSiswaLulus = 0;
                            $totalGuru = 0;
                            $totalAbsensi = 0;
                            
                            if (class_exists('\App\Models\Siswa')) {
                                $totalSiswaAktif = \App\Models\Siswa::where('status_siswa', 'aktif')->count();
                                $totalSiswaLulus = \App\Models\Siswa::where('status_siswa', 'lulus')->count();
                            }
                            if (class_exists('\App\Models\Guru')) {
                                $totalGuru = \App\Models\Guru::count();
                            }
                            if (class_exists('\App\Models\Absensi')) {
                                $totalAbsensi = \App\Models\Absensi::whereDate('tanggal', today())->count();
                            }
                        @endphp
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-300">Siswa Aktif</span>
                            <span class="font-bold text-green-400">{{ $totalSiswaAktif }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-300">Siswa Lulus</span>
                            <span class="font-bold text-yellow-400">{{ $totalSiswaLulus }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-300">Total Guru</span>
                            <span class="font-bold text-blue-400">{{ $totalGuru }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-300">Absensi Hari Ini</span>
                            <span class="font-bold text-purple-400">{{ $totalAbsensi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="p-4 border-t border-gray-700 mt-6 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()" 
                            class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden main-content">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 lg:px-6 py-3 lg:py-4">
                    <!-- Left Side: Mobile menu button + Page Title -->
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <button id="mobileMenuButton" class="lg:hidden text-gray-600 hover:text-gray-900 flex-shrink-0">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="flex-1 min-w-0">
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 truncate">
                                @yield('title', 'Dashboard')
                            </h1>
                            <div class="flex items-center text-xs sm:text-sm text-gray-600 mt-1">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition-colors duration-200 truncate">
                                    <i class="fas fa-home mr-1"></i> Dashboard
                                </a>
                                @hasSection('breadcrumb')
                                <i class="fas fa-chevron-right mx-2 text-xs flex-shrink-0"></i>
                                <span class="truncate">@yield('breadcrumb')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Time & Actions -->
                    <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                        <!-- Date & Time Display -->
                        <div class="text-right hidden sm:block">
                            <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[180px]" id="currentDate">
                                {{ now()->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="text-xs text-gray-500" id="currentTime">
                                Loading...
                            </div>
                        </div>

                        <!-- Quick Actions Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-bolt text-gray-600"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 sm:w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                <div class="p-3 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-900 text-sm">Aksi Cepat</h3>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('admin.siswa.siswa-aktif.create') }}" 
                                       class="flex items-center px-3 py-2 hover:bg-gray-100 rounded-md transition-colors duration-200 text-sm">
                                        <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                                        <span>Tambah Siswa</span>
                                    </a>
                                    <a href="{{ route('admin.guru.create') }}" 
                                       class="flex items-center px-3 py-2 hover:bg-gray-100 rounded-md transition-colors duration-200 text-sm">
                                        <i class="fas fa-user-tie text-green-600 mr-3"></i>
                                        <span>Tambah Guru</span>
                                    </a>
                                    <a href="{{ route('admin.spmb.create') }}" 
                                       class="flex items-center px-3 py-2 hover:bg-gray-100 rounded-md transition-colors duration-200 text-sm">
                                        <i class="fas fa-file-alt text-amber-600 mr-3"></i>
                                        <span>Tambah SPMB</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- View Website -->
                        <a href="{{ url('/') }}" target="_blank" 
                           class="flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg text-sm flex-shrink-0">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            <span class="hidden md:inline">Website</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-4 lg:p-6">
                <!-- Alerts -->
                @if(session('success'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg sm:rounded-xl shadow-sm">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl mr-3"></i>
                        </div>
                        <div class="flex-1 ml-3 min-w-0">
                            <p class="text-green-800 font-medium text-sm sm:text-base break-words">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="ml-2 sm:ml-4 text-green-500 hover:text-green-700 flex-shrink-0" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-lg sm:rounded-xl shadow-sm">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mr-3"></i>
                        </div>
                        <div class="flex-1 ml-3 min-w-0">
                            <p class="text-red-800 font-medium text-sm sm:text-base break-words">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="ml-2 sm:ml-4 text-red-500 hover:text-red-700 flex-shrink-0" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-lg sm:rounded-xl shadow-sm">
                    <div class="flex items-start sm:items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-lg sm:text-xl mr-3"></i>
                        </div>
                        <div class="flex-1 ml-3 min-w-0">
                            <p class="text-yellow-800 font-medium text-sm sm:text-base">Terdapat kesalahan:</p>
                            <ul class="mt-1 text-xs sm:text-sm text-yellow-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                <li class="break-words">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="ml-2 sm:ml-4 text-yellow-500 hover:text-yellow-700 flex-shrink-0" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Page Content -->
                <div class="page-transition">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-4 lg:px-6 py-3 lg:py-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-xs sm:text-sm text-gray-600 text-center md:text-left mb-2 md:mb-0">
                        &copy; {{ date('Y') }} {{ config('app.name', 'TK Ceria Bangsa') }}. All rights reserved.
                    </div>
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <span class="text-xs text-gray-500 hidden sm:inline">
                            <i class="fas fa-server mr-1"></i> v{{ config('app.version', '1.0.0') }}
                        </span>
                        <span class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-none">
                            <i class="fas fa-user-shield mr-1"></i> 
                            @auth
                            {{ Auth::user()->name }}
                            @endauth
                        </span>
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i> <span id="footerTime">Loading...</span>
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Backdrop for mobile menu -->
    <div id="mobileBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    <!-- Include Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            const mobileBackdrop = document.getElementById('mobileBackdrop');

            // Toggle mobile menu function
            function toggleMobileMenu() {
                const isOpen = sidebar.classList.contains('sidebar-open');
                
                if (isOpen) {
                    // Close sidebar
                    sidebar.classList.remove('sidebar-open');
                    mobileBackdrop.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                } else {
                    // Open sidebar
                    sidebar.classList.add('sidebar-open');
                    mobileBackdrop.classList.remove('hidden');
                    document.body.classList.add('sidebar-open');
                }
            }

            // Open menu
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleMobileMenu();
                });
            }
            
            // Close menu
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleMobileMenu();
                });
            }
            
            // Close menu when clicking backdrop
            if (mobileBackdrop) {
                mobileBackdrop.addEventListener('click', function(e) {
                    if (e.target === mobileBackdrop) {
                        toggleMobileMenu();
                    }
                });
            }

            // Close menu when clicking navigation links on mobile
            document.querySelectorAll('#sidebar nav a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        toggleMobileMenu();
                    }
                });
            });

            // ============= FUNGSI JAM REALTIME =============
            function updateTime() {
                const now = new Date();
                
                // Format waktu Indonesia (HH:MM)
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const timeString = `${hours}:${minutes}`;
                
                // Format tanggal Indonesia
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const monthName = months[now.getMonth()];
                const year = now.getFullYear();
                const dateString = `${dayName}, ${date} ${monthName} ${year}`;
                
                // Update elemen HTML
                const currentTimeElement = document.getElementById('currentTime');
                const currentDateElement = document.getElementById('currentDate');
                const footerTimeElement = document.getElementById('footerTime');
                
                if (currentTimeElement) currentTimeElement.textContent = timeString;
                if (currentDateElement) currentDateElement.textContent = dateString;
                if (footerTimeElement) footerTimeElement.textContent = timeString;
            }
            
            // Jalankan sekali saat load, lalu setiap menit
            updateTime();
            setInterval(updateTime, 60000);
            
            // ============= FUNGSI LAINNYA =============
            
            // Global loading overlay
            window.showLoading = function() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('hidden');
                }
            };

            window.hideLoading = function() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('hidden');
                }
            };

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('[class*="bg-gradient-to-r"]').forEach(alert => {
                    if (alert.classList.contains('from-green-50') || 
                        alert.classList.contains('from-red-50') || 
                        alert.classList.contains('from-yellow-50')) {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 500);
                    }
                });
            }, 5000);

            // Handle window resize
            function handleResize() {
                if (window.innerWidth >= 1024) {
                    // Desktop: Tampilkan sidebar, hilangkan backdrop
                    sidebar.classList.remove('sidebar-open');
                    sidebar.classList.remove('-translate-x-full');
                    mobileBackdrop.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                } else {
                    // Mobile: Sembunyikan sidebar (reset state)
                    sidebar.classList.remove('sidebar-open');
                    sidebar.classList.add('-translate-x-full');
                    mobileBackdrop.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                }
            }

            // Initial check
            handleResize();
            
            // Listen for resize
            window.addEventListener('resize', handleResize);
        });

        // Confirm logout
        function confirmLogout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logoutForm').submit();
                    }
                });
            } else {
                // Fallback jika SweetAlert tidak tersedia
                if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
                    document.getElementById('logoutForm').submit();
                }
            }
        }

        // Global form submission with loading
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.tagName === 'FORM' && !form.classList.contains('no-loading')) {
                window.showLoading();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Esc to close sidebar mobile
            if (e.key === 'Escape') {
                // Close sidebar on mobile
                if (window.innerWidth < 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const backdrop = document.getElementById('mobileBackdrop');
                    if (sidebar && sidebar.classList.contains('sidebar-open')) {
                        sidebar.classList.remove('sidebar-open');
                        backdrop.classList.add('hidden');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            }
        });
        
        // Prevent main content scroll when sidebar is open
        document.addEventListener('wheel', function(e) {
            if (window.innerWidth < 1024 && document.body.classList.contains('sidebar-open')) {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar.contains(e.target)) {
                    e.preventDefault();
                }
            }
        }, { passive: false });
        
        // Also prevent touch scroll on mobile when sidebar is open
        document.addEventListener('touchmove', function(e) {
            if (window.innerWidth < 1024 && document.body.classList.contains('sidebar-open')) {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar.contains(e.target)) {
                    e.preventDefault();
                }
            }
        }, { passive: false });
    </script>

    <!-- SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>