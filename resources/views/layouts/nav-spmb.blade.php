<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPMB - TK Ceria Bangsa')</title>
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans text-gray-800 bg-gray-50">
    
    <!-- NAVBAR SPMB KHUSUS -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Kembali ke Home -->
                <div>
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span class="font-medium">Kembali ke Home</span>
                    </a>
                </div>
                
                <!-- Logo Tengah -->
                <div class="flex items-center">
                    <a href="{{ route('spmb.index') }}" class="flex items-center">
                        <i class="fas fa-university text-blue-600 text-2xl mr-3"></i>
                        <div class="text-center">
                            <span class="text-lg font-bold text-blue-600 block">SPMB 2026/2027</span>
                            <span class="text-xs text-gray-600">TK Ceria Bangsa</span>
                        </div>
                    </a>
                </div>
                
                <!-- Tombol Daftar -->
                <div>
                    @php
                        $setting = App\Models\SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
                        $now = now();
                        $isPendaftaranOpen = $setting && $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);
                    @endphp
                    
                    @if($isPendaftaranOpen)
                        <a href="{{ route('spmb.pendaftaran') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-edit mr-2"></i>
                            <span class="font-medium">Daftar</span>
                        </a>
                    @else
                        <button class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                            <i class="fas fa-lock mr-2"></i>
                            <span class="font-medium">Tutup</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm">© 2026 TK Ceria Bangsa. Sistem Penerimaan Peserta Didik Baru.</p>
            <p class="text-xs text-gray-400 mt-2">Jl. Pendidikan No. 123, Bandung, Jawa Barat</p>
        </div>
    </footer>
    
    <!-- WhatsApp Button -->
    <a href="https://wa.me/6285885455853" target="_blank"
       class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-xl z-50">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>