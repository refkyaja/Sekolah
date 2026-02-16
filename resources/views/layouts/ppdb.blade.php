<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendaftaran PPDB - TK Ceria Bangsa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        /* Custom styling untuk form PPDB */
        .form-input:focus {
            border-color: #3b82f6;
            ring-color: #3b82f6;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
    </style>
</head>
<body class="font-sans bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-school text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">TK Ceria Bangsa</h1>
                        <p class="text-xs text-gray-600">Pendaftaran PPDB Online</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="{{ route('ppdb.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
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
                    <a href="{{ route('ppdb.index') }}" class="block px-3 py-2 bg-blue-600 text-white rounded">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-school text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">TK Ceria Bangsa</h3>
                            <p class="text-gray-400 text-sm">Mendidik dengan Cinta</p>
                        </div>
                    </div>
                    <p class="text-gray-300">
                        Lembaga pendidikan anak usia dini yang berkomitmen membentuk generasi cerdas, kreatif, dan berakhlak mulia.
                    </p>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Kontak Kami</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-400 mt-1 mr-3"></i>
                            <span class="text-gray-300">Jl. Pendidikan No. 123, Jakarta Pusat 10110</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-400 mr-3"></i>
                            <span class="text-gray-300">(021) 1234-5678</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-400 mr-3"></i>
                            <span class="text-gray-300">info@tkceriabangsa.sch.id</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-400 mr-3"></i>
                            <span class="text-gray-300">Senin - Jumat: 07:00 - 16:00</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('ppdb.index') }}" class="text-gray-300 hover:text-white flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>
                                Formulir Pendaftaran
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>
                                Persyaratan Pendaftaran
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>
                                Biaya Pendidikan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-300 hover:text-white flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2"></i>
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Social Media & Copyright -->
            <div class="border-t border-gray-700 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-400 text-sm">
                            &copy; {{ date('Y') }} TK Ceria Bangsa. Semua hak dilindungi.
                        </p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
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