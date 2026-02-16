<nav x-data="{ open: false, openDropdown: '' }" class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-school text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <span class="text-xl font-bold text-blue-600">TK Harapan</span>
                        <span class="block text-xs text-gray-600 -mt-1">Bangsa</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex flex-1 justify-center items-center space-x-3 pl-12">
                <!-- 1. Home -->
                <a href="{{ route('home') }}" 
                   class="flex flex-col items-center justify-center px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                    <i class="fas fa-home mr-1"></i> Home
                </a>

                <!-- 2. Berita -->
                <a href="{{ route('berita.index') }}" 
                   class="flex flex-col items-center justify-center px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200">
                    <i class="fas fa-newspaper mr-1"></i> Berita
                </a>

                <!-- 3. Galeri -->
                <a href="{{ route('galeri.index') }}" 
                   class="flex flex-col items-center justify-center px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200">
                    <i class="fas fa-images mr-1"></i> Galeri
                </a>

                <!-- 4. Profil Sekolah Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-school mr-2"></i> Profil Sekolah
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border py-2 z-50">
                        <a href="{{ route('profil.sejarah') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-history mr-3"></i> Sejarah Singkat
                        </a>
                        <a href="{{ route('profil.sambutan') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-user-tie mr-3"></i> Sambutan Kepala Sekolah
                        </a>
                        <a href="{{ route('profil.visimisi') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-bullseye mr-3"></i> Visi & Misi
                        </a>
                        <a href="{{ route('profil.program') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-calendar-alt mr-3"></i> Program Sekolah
                        </a>
                        <a href="{{ route('profil.lokasi') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-map-marker-alt mr-3"></i> Lokasi Sekolah
                        </a>
                    </div>
                </div>

                <!-- 5. Akademik Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i> Akademik
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border py-2 z-50">
                        <a href="{{ route('akademik.kegiatan') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-running mr-3"></i> Kegiatan Sekolah
                        </a>
                        <a href="{{ route('akademik.prestasi') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-trophy mr-3"></i> Prestasi Siswa
                        </a>
                        <a href="{{ route('akademik.ekstrakurikuler') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-music mr-3"></i> Ekstrakurikuler
                        </a>
                        <a href="{{ route('akademik.bahan-ajar') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-book mr-3"></i> Bahan Ajar
                        </a>
                    </div>
                </div>

                <!-- 6. Sarana & Prasarana Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-building mr-2"></i> Sarana & Prasarana
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border py-2 z-50">
                        <a href="{{ route('sarana.infrastruktur') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-school mr-3"></i> Sarana Infrastruktur
                        </a>
                        <a href="{{ route('sarana.pembelajaran') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-chalkboard-teacher mr-3"></i> Sarana Pembelajaran
                        </a>
                    </div>
                </div>

                <!-- 7. Layanan Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-handshake mr-2"></i> Layanan
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    
                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-xl border py-2 z-50">
                        <a href="{{ route('layanan.buku-tamu') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-book-open mr-3"></i> Buku Tamu
                        </a>
                        <a href="{{ route('layanan.kontak') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fas fa-phone-alt mr-3"></i> Kontak Sekolah
                        </a>
                    </div>
                </div>

                <!-- 8. PPDB Button (Special Highlight) -->
                <a href="{{ route('spmb.index') }}" 
                   class="ml-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold px-5 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> SPMB
                    <span class="ml-1 text-xs bg-white text-orange-500 px-1.5 py-0.5 rounded-full">⭐</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-700 hover:text-blue-600 p-2">
                    <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-1">
            <!-- 1. Home -->
            <a href="{{ route('home') }}" @click="open = false"
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-home w-5 mr-3"></i> Home
            </a>

            <!-- 2. Berita -->
            <a href="{{ route('berita.index') }}" @click="open = false"
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-newspaper w-5 mr-3"></i> Berita
            </a>

            <!-- 3. Galeri -->
            <a href="{{ route('galeri.index') }}" @click="open = false"
               class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg">
                <i class="fas fa-images w-5 mr-3"></i> Galeri
            </a>

            <!-- 4. Profil Sekolah Accordion -->
            <div class="border rounded-lg overflow-hidden">
                <button @click="openDropdown = openDropdown === 'profil' ? '' : 'profil'"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-blue-50">
                    <div class="flex items-center">
                        <i class="fas fa-school w-5 mr-3"></i> Profil Sekolah
                    </div>
                    <i :class="openDropdown === 'profil' ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
                </button>
                
                <div x-show="openDropdown === 'profil'" class="bg-gray-50">
                    <a href="{{ route('profil.sejarah') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Sejarah Singkat
                    </a>
                    <a href="{{ route('profil.sambutan') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Sambutan Kepala Sekolah
                    </a>
                    <a href="{{ route('profil.visimisi') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Visi & Misi
                    </a>
                    <a href="{{ route('profil.program') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Program Sekolah
                    </a>
                    <a href="{{ route('profil.lokasi') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Lokasi Sekolah
                    </a>
                </div>
            </div>

            <!-- 5. Akademik Accordion -->
            <div class="border rounded-lg overflow-hidden">
                <button @click="openDropdown = openDropdown === 'akademik' ? '' : 'akademik'"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-blue-50">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap w-5 mr-3"></i> Akademik
                    </div>
                    <i :class="openDropdown === 'akademik' ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
                </button>
                
                <div x-show="openDropdown === 'akademik'" class="bg-gray-50">
                    <a href="{{ route('akademik.kegiatan') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Kegiatan Sekolah
                    </a>
                    <a href="{{ route('akademik.prestasi') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Prestasi Siswa
                    </a>
                    <a href="{{ route('akademik.ekstrakurikuler') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Ekstrakurikuler
                    </a>
                    <a href="{{ route('akademik.bahan-ajar') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Bahan Ajar
                    </a>
                </div>
            </div>

            <!-- 6. Sarana & Prasarana Accordion -->
            <div class="border rounded-lg overflow-hidden">
                <button @click="openDropdown = openDropdown === 'sarana' ? '' : 'sarana'"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-blue-50">
                    <div class="flex items-center">
                        <i class="fas fa-building w-5 mr-3"></i> Sarana & Prasarana
                    </div>
                    <i :class="openDropdown === 'sarana' ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
                </button>
                
                <div x-show="openDropdown === 'sarana'" class="bg-gray-50">
                    <a href="{{ route('sarana.infrastruktur') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Sarana Infrastruktur
                    </a>
                    <a href="{{ route('sarana.pembelajaran') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Sarana Pembelajaran
                    </a>
                </div>
            </div>

            <!-- 7. Layanan Accordion -->
            <div class="border rounded-lg overflow-hidden">
                <button @click="openDropdown = openDropdown === 'layanan' ? '' : 'layanan'"
                        class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-blue-50">
                    <div class="flex items-center">
                        <i class="fas fa-handshake w-5 mr-3"></i> Layanan
                    </div>
                    <i :class="openDropdown === 'layanan' ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-sm"></i>
                </button>
                
                <div x-show="openDropdown === 'layanan'" class="bg-gray-50">
                    <a href="{{ route('layanan.buku-tamu') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Buku Tamu
                    </a>
                    <a href="{{ route('layanan.kontak') }}" @click="open = false"
                       class="block pl-12 pr-4 py-3 text-sm text-gray-600 hover:bg-blue-100 hover:text-blue-700">
                        Kontak Sekolah
                    </a>
                </div>
            </div>

            <!-- 8. spmb Button Mobile -->
            <div class="pt-4">
                <a href="{{ route('spmb.index') }}" @click="open = false"
                   class="block w-full text-center bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i> PENDAFTARAN (SPMB)
                    <span class="ml-2 text-xs bg-white text-orange-500 px-1.5 py-0.5 rounded-full">⭐</span>
                </a>
            </div>
        </div>
    </div>
</nav>