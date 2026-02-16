@extends('layouts.frontend')

@section('title', 'TK Harapan Bangsa 1 - Pendidikan Anak Usia Dini')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-500 via-purple-500 to-pink-400 text-white py-24 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-black/20 z-0"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-40 h-40 bg-yellow-300/20 rounded-full"></div>
        <div class="absolute top-1/2 right-1/3 w-32 h-32 bg-pink-300/20 rounded-full"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 text-center z-10">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full mb-8">
            <i class="fas fa-graduation-cap text-3xl"></i>
        </div>
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            TK Harapan Bangsa 1
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto font-light">
            Menciptakan Generasi <span class="font-bold text-yellow-300">Cerdas, Kreatif,</span> dan Berakhlak Mulia
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="#pendaftaran" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                Daftar Sekarang
            </a>
            <a href="#sambutan" class="border-2 border-white hover:bg-white/20 px-8 py-3 rounded-full font-semibold transition-all duration-300 backdrop-blur-sm">
                Jelajahi Sekolah
            </a>
        </div>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent z-0"></div>
</section>

<!-- Quick Stats -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-6">
                <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">50+</div>
                <div class="text-gray-600">Siswa Aktif</div>
            </div>
            <div class="text-center p-6">
                <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">10+</div>
                <div class="text-gray-600">Pengajar Profesional</div>
            </div>
            <div class="text-center p-6">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">8</div>
                <div class="text-gray-600">Fasilitas Lengkap</div>
            </div>
            <div class="text-center p-6">
                <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">15+</div>
                <div class="text-gray-600">Tahun Pengalaman</div>
            </div>
        </div>
    </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<section class="py-20 bg-gradient-to-b from-white to-blue-50" id="sambutan">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-2/5">
                <div class="relative">
                    <div class="w-full h-96 rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/kepala-sekolah.jpg') }}" 
                             alt="Kepala Sekolah TK Harapan Bangsa 1"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-xl flex items-center justify-center">
                        <i class="fas fa-award text-white text-4xl"></i>
                    </div>
                </div>
            </div>
            <div class="lg:w-3/5">
                <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full mb-6">
                    Sambutan Kepala Sekolah
                </div>
                <h2 class="text-4xl font-bold mb-6 text-gray-800">
                    Membangun Fondasi <span class="text-blue-600">Masa Depan</span> Bersama
                </h2>
                <div class="text-gray-600 text-lg mb-8 leading-relaxed space-y-4">
                    <p>"Selamat datang di <span class="font-semibold text-blue-600">TK Harapan Bangsa 1</span>, tempat di mana setiap anak menemukan kebahagiaan dalam belajar dan berkembang."</p>
                    <p>Kami percaya bahwa pendidikan usia dini adalah fondasi penting bagi perkembangan anak. Dengan pendekatan pembelajaran yang menyenangkan, kreatif, dan berpusat pada anak, kami berkomitmen menumbuhkan rasa ingin tahu, karakter positif, dan kecintaan belajar seumur hidup.</p>
                    <p>Bersama para pendidik profesional dan fasilitas yang memadai, kami siap membimbing putra-putri Anda menjadi generasi yang cerdas, kreatif, dan berakhlak mulia.</p>
                </div>
                <div class="border-l-4 border-blue-500 pl-6 py-2">
                    <p class="font-bold text-xl text-gray-800">Ibu Siti Nurhaliza, S.Pd</p>
                    <p class="text-gray-600">Kepala TK Harapan Bangsa 1</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guru yang Mengajar -->
<section class="py-20 bg-white" id="guru">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full mb-4">
                Tim Pengajar
            </div>
            <h2 class="text-4xl font-bold mb-4 text-gray-800">
                Pengajar <span class="text-green-600">Profesional</span> & Berpengalaman
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                Ditemani oleh pendidik yang penuh kasih sayang dan kompeten di bidang pendidikan anak usia dini
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach([1,2,3] as $index)
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('images/kepala-sekolah.jpg') }}"
                         alt="Guru TK Harapan Bangsa 1"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full">
                            <span class="font-semibold text-gray-800">
                                @if($index == 1) Kelas A
                                @elseif($index == 2) Kelas B
                                @else Kelas Bermain
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2 text-gray-800">
                        @if($index == 1) Andi Wijaya, S.Pd
                        @elseif($index == 2) Rina Susanti, S.Psi
                        @else Budi Santoso, S.Pd
                        @endif
                    </h3>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-user-graduate mr-3 text-blue-500"></i>
                            <span>@if($index == 1) Pendidikan Anak Usia Dini
                                  @elseif($index == 2) Psikologi Anak
                                  @else Pendidikan Seni Kreatif
                                  @endif</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-clock mr-3 text-green-500"></i>
                            <span>@if($index == 1) 5 Tahun Pengalaman
                                  @elseif($index == 2) 3 Tahun Pengalaman
                                  @else 4 Tahun Pengalaman
                                  @endif</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-heart mr-3 text-pink-500"></i>
                            <span>Spesialisasi: @if($index == 1) Pengembangan Motorik
                                  @elseif($index == 2) Perkembangan Sosial
                                  @else Kreativitas Seni
                                  @endif</span>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 text-sm rounded-full">Ramah Anak</span>
                            <span class="px-3 py-1 bg-green-100 text-green-600 text-sm rounded-full">Kreatif</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 text-sm rounded-full">Sabar</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Fasilitas -->
<section class="py-20 bg-gradient-to-b from-white to-blue-50" id="fasilitas">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full mb-4">
                Fasilitas Kami
            </div>
            <h2 class="text-4xl font-bold mb-4 text-gray-800">
                Lingkungan Belajar yang <span class="text-purple-600">Nyaman & Aman</span>
            </h2>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'fas fa-child', 'title' => 'Area Bermain', 'desc' => 'Area bermain luas dengan alat permainan edukatif'],
                ['icon' => 'fas fa-book', 'title' => 'Perpustakaan Anak', 'desc' => 'Koleksi buku cerita dan edukasi anak'],
                ['icon' => 'fas fa-paint-brush', 'title' => 'Ruang Kreatif', 'desc' => 'Ruangan khusus untuk seni dan kreativitas'],
                ['icon' => 'fas fa-utensils', 'title' => 'Kantin Sehat', 'desc' => 'Menyediakan makanan sehat dan bergizi'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Keamanan 24/7', 'desc' => 'Pengawasan CCTV dan satpam'],
                ['icon' => 'fas fa-heartbeat', 'title' => 'Klinik Kesehatan', 'desc' => 'Pemeriksaan kesehatan rutin'],
                ['icon' => 'fas fa-music', 'title' => 'Ruang Musik', 'desc' => 'Alat musik untuk pengembangan bakat'],
                ['icon' => 'fas fa-car', 'title' => 'Transportasi Aman', 'desc' => 'Fasilitas antar jemput']
            ] as $fasilitas)
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-4">
                    <i class="{{ $fasilitas['icon'] }} text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2 text-gray-800">{{ $fasilitas['title'] }}</h3>
                <p class="text-gray-600">{{ $fasilitas['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Galeri Kegiatan -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12">
            <div>
                <div class="inline-block px-4 py-2 bg-orange-100 text-orange-600 rounded-full mb-4">
                    Galeri Kegiatan
                </div>
                <h2 class="text-4xl font-bold text-gray-800">
                    Momen <span class="text-orange-600">Berharga</span> di TK Harapan Bangsa 1
                </h2>
            </div>
            @if(Route::has('galeri.index'))
                <a href="{{ route('galeri.index') }}" 
                   class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                    Lihat Semua Galeri
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @endif
        </div>
        
        @if(isset($galeris) && $galeris->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galeris as $index => $galeri)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="relative overflow-hidden h-56">
                        <img src="{{ $galeri->thumbnail_url }}"  
                             alt="{{ $galeri->judul }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                        
                        <!-- Overlay Kategori -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="inline-block px-3 py-1 bg-orange-500 text-white text-xs rounded-full">
                                    {{ $galeri->kategori ?? 'Kegiatan' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Badge Tanggal -->
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg">
                            <span class="font-semibold text-sm {{ $loop->first ? 'text-blue-600' : 'text-green-600' }}">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $galeri->tanggal ? \Carbon\Carbon::parse($galeri->tanggal)->format('d M Y') : now()->format('d M Y') }}
                            </span>
                        </div>
                        
                        <!-- Views Counter -->
                        <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm px-3 py-1 rounded-full shadow-lg">
                            <span class="text-white text-xs">
                                <i class="far fa-eye mr-1"></i>
                                {{ number_format($galeri->views ?? 0) }}x
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                            {{ $galeri->judul }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($galeri->deskripsi, 80) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-xs">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span class="truncate max-w-[150px]">{{ $galeri->lokasi ?? 'TK Harapan Bangsa 1' }}</span>
                            </div>
                            
                            <a href="{{ route('galeri.show', $galeri->slug) }}" 
                               class="inline-flex items-center text-orange-600 hover:text-orange-700 text-sm font-medium">
                                Detail
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <!-- Tampilan ketika belum ada galeri (konsisten dengan berita) -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                <i class="fas fa-images text-4xl text-orange-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Galeri</h3>
            <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                Saat ini belum ada foto atau video kegiatan. Silakan kunjungi kembali nanti untuk melihat momen-momen berharga dari TK Harapan Bangsa 1.
            </p>
            @if(Route::has('beranda'))
                <a href="{{ route('beranda') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-full hover:bg-orange-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                    Kembali ke Beranda
                    <i class="fas fa-home ml-2"></i>
                </a>
            @endif
        </div>
        @endif
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12">
            <div>
                <div class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full mb-4">
                    Informasi Terkini
                </div>
                <h2 class="text-4xl font-bold text-gray-800">
                    Berita & <span class="text-red-600">Informasi</span> Terbaru
                </h2>
            </div>
            @if(Route::has('berita.index'))
                <a href="{{ route('berita.index') }}" 
                   class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                    Lihat Semua Berita
                    <i class="fas fa-newspaper ml-2"></i>
                </a>
            @endif
        </div>
        
        @if(isset($beritas) && $beritas->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($beritas as $index => $item)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden">
                        @if($item->gambar && Storage::disk('public')->exists($item->gambar))
                            <img 
                                src="{{ asset('storage/' . $item->gambar) }}"
                                alt="{{ $item->judul }}"
                                class="w-full h-full object-cover"
                            />
                        @else
                        <div class="w-full h-full bg-gradient-to-br {{ $index == 0 ? 'from-blue-50 to-blue-100' : ($index == 1 ? 'from-green-50 to-green-100' : 'from-purple-50 to-purple-100') }} flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl {{ $index == 0 ? 'text-blue-400' : ($index == 1 ? 'text-green-400' : 'text-purple-400') }}"></i>
                        </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg shadow">
                            <span class="font-semibold text-sm {{ $index == 0 ? 'text-blue-600' : ($index == 1 ? 'text-green-600' : 'text-purple-600') }}">
                                @if(isset($item->tanggal_publish))
                                    {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M') }}
                                @elseif(isset($item->created_at))
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M') }}
                                @else
                                    {{ now()->subDays($index * 2)->format('d M') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                            {{ $item->judul ?? 'Judul Berita' }}
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            @if(isset($item->isi_berita))
                                {{ Str::limit(strip_tags($item->isi_berita), 100) }}
                            @elseif(isset($item->isi))
                                {{ Str::limit(strip_tags($item->isi), 100) }}
                            @else
                                Deskripsi berita akan ditampilkan di sini.
                            @endif
                        </p>
                        <a href="{{ isset($item->slug) ? route('berita.show', $item->slug) : '#' }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium group">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right ml-2 group-hover:ml-3 transition-all duration-300"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <!-- Tampilan ketika belum ada berita -->
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Berita</h3>
            <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                Saat ini belum ada berita terbaru. Silakan kunjungi kembali nanti untuk mendapatkan informasi terbaru dari kami.
            </p>
            @if(Route::has('beranda'))
                <a href="{{ route('beranda') }}" 
                   class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                    Kembali ke Beranda
                    <i class="fas fa-home ml-2"></i>
                </a>
            @endif
        </div>
        @endif
    </div>
</section>

<!-- CTA Pendaftaran -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white" id="pendaftaran">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <i class="fas fa-school text-2xl"></i>
            </div>
            <h2 class="text-4xl font-bold mb-6">
                Bergabunglah dengan <span class="text-yellow-300">TK Harapan Bangsa 1</span>
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Tahun ajaran baru akan segera dibuka. Daftarkan putra/putri Anda sekarang untuk mendapatkan pengalaman belajar terbaik.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('spmb.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="#" class="border-2 border-white hover:bg-white/20 px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 backdrop-blur-sm">
                    Konsultasi Gratis
                </a>
            </div>
            <div class="mt-8 text-sm opacity-75">
                <i class="fas fa-phone-alt mr-2"></i>
                Hubungi kami: (021) 1234-5678
                <span class="mx-4">•</span>
                <i class="fas fa-envelope mr-2"></i>
                info@tkharapanbangsa1.sch.id
            </div>
        </div>
    </div>
</section>

<!-- Footer Info -->
<section class="py-12 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span class="text-2xl font-bold">TK Harapan Bangsa 1</span>
                </div>
                <p class="text-gray-400 mt-2">Mendidik dengan hati, menginspirasi dengan aksi</p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-pink-600 rounded-full flex items-center justify-center transition-colors duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-blue-400 rounded-full flex items-center justify-center transition-colors duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-green-600 rounded-full flex items-center justify-center transition-colors duration-300">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .scroll-smooth {
        scroll-behavior: smooth;
    }
    
    .guru-card {
        scroll-snap-align: start;
    }
</style>
@endpush

@push('scripts')
<script>
    // Smooth scroll untuk bagian guru
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('guru-track');
        if (track) {
            let isDown = false;
            let startX;
            let scrollLeft;

            track.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - track.offsetLeft;
                scrollLeft = track.scrollLeft;
            });

            track.addEventListener('mouseleave', () => {
                isDown = false;
            });

            track.addEventListener('mouseup', () => {
                isDown = false;
            });

            track.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - track.offsetLeft;
                const walk = (x - startX) * 2;
                track.scrollLeft = scrollLeft - walk;
            });
        }
    });
</script>
@endpush