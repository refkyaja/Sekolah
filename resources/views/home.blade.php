@extends('layouts.guest')

@section('title', 'TK Ceria Bangsa - Pendidikan Anak Usia Dini')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-bg.jpg') }}" 
             alt="Anak-anak bermain"
             class="w-full h-full object-cover opacity-20">
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">
            TK Ceria Bangsa
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Membentuk generasi cerdas, kreatif, dan berakhlak mulia
        </p>
        <a href="{{ route('ppdb.index') }}" 
           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg">
            Daftar Sekarang
        </a>
    </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="md:w-1/3">
                <img src="{{ asset('images/kepala-sekolah.jpg') }}" 
                     alt="Kepala Sekolah"
                     class="rounded-lg w-full">
            </div>
            <div class="md:w-2/3">
                <h2 class="text-3xl font-bold mb-4">Sambutan Kepala Sekolah</h2>
                <p class="text-gray-700 mb-4">
                    "Selamat datang di TK Ceria Bangsa. Kami berkomitmen memberikan pendidikan terbaik 
                    untuk anak usia dini dengan pendekatan yang menyenangkan."
                </p>
                <p class="font-bold">Ibu Siti Nurhaliza, S.Pd</p>
                <p class="text-gray-600">Kepala TK Ceria Bangsa</p>
            </div>
        </div>
    </div>
</section>

<!-- Guru yang Mengajar -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">Guru yang Mengajar</h2>
        
        <!-- Container dengan horizontal scroll -->
        <div class="relative">
            <div id="guru-scroll" class="overflow-x-auto pb-8 scroll-smooth">
                <div id="guru-track" class="flex space-x-8 min-w-max">
                        <!-- Guru 1 -->
                        <div class="guru-card w-full md:w-[calc(40%-16px)] flex-shrink-0">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <!-- Gambar di Kiri -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('images/kepala-sekolah.jpg') }}"
                                            alt="Guru Andi Wijaya"
                                            class="w-64 h-64 object-cover rounded-xl shadow">
                                    </div>

                                    <!-- Informasi di Kanan -->
                                    <div class="md:w-1/2 p-6">
                                        <h3 class="font-bold text-xl mb-3">Andi Wijaya, S.Pd</h3>
                                        <p class="text-gray-600 mb-2">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            Umur: 28 Tahun
                                        </p>
                                        <p class="text-gray-700">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-green-600"></i>
                                            Mengajar: Kelas A (Usia 4-5 Tahun)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Guru 2 -->
                        <div class="guru-card w-full md:w-[calc(40%-16px)] flex-shrink-0">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <!-- Gambar di Kiri -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('images/kepala-sekolah.jpg') }}"
                                            alt="Guru Andi Wijaya"
                                            class="w-64 h-64 object-cover rounded-xl shadow">
                                    </div>

                                    <!-- Informasi di Kanan -->
                                    <div class="md:w-1/2 p-6">
                                        <h3 class="font-bold text-xl mb-3">Andi Wijaya, S.Pd</h3>
                                        <p class="text-gray-600 mb-2">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            Umur: 28 Tahun
                                        </p>
                                        <p class="text-gray-700">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-green-600"></i>
                                            Mengajar: Kelas A (Usia 4-5 Tahun)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Guru 3 -->
                        <div class="guru-card w-full md:w-[calc(40%-16px)] flex-shrink-0">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <!-- Gambar di Kiri -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('images/kepala-sekolah.jpg') }}"
                                            alt="Guru Andi Wijaya"
                                            class="w-64 h-64 object-cover rounded-xl shadow">
                                    </div>

                                    <!-- Informasi di Kanan -->
                                    <div class="md:w-1/2 p-6">
                                        <h3 class="font-bold text-xl mb-3">Andi Wijaya, S.Pd</h3>
                                        <p class="text-gray-600 mb-2">
                                            <i class="fas fa-user mr-2 text-blue-600"></i>
                                            Umur: 28 Tahun
                                        </p>
                                        <p class="text-gray-700">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-green-600"></i>
                                            Mengajar: Kelas A (Usia 4-5 Tahun)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kegiatan -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Kegiatan Sekolah</h2>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('images/kegiatan1.jpg') }}" 
                     alt="Field Trip"
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Field Trip</h3>
                    <p class="text-gray-700">Belajar langsung di kebun binatang</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('images/kegiatan2.jpg') }}" 
                     alt="Pentas Seni"
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">Pentas Seni</h3>
                    <p class="text-gray-700">Menampilkan bakat anak-anak</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Berita Terbaru -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold">Berita Terbaru</h2>
            @if(Route::has('berita.index'))
                <a href="{{ route('berita.index') }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    Lihat Semua Berita
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            @endif
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($berita as $index => $item)
                <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <img src="{{ asset($item->gambar ?? 'images/default-news.jpg') }}" 
                             alt="{{ $item->judul }}"
                             class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4 {{ $index == 0 ? 'bg-blue-600' : ($index == 1 ? 'bg-green-600' : 'bg-purple-600') }} text-white px-3 py-1 rounded text-sm">
                            @if(isset($item->created_at))
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            @else
                                {{ now()->subDays($index * 2)->format('d M Y') }}
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-3">{{ $item->judul }}</h3>
                        <p class="text-gray-600 mb-4">
                            @if(is_string($item->isi) && strlen($item->isi) > 100)
                                {{ substr($item->isi, 0, 100) }}...
                            @else
                                {{ $item->isi ?? 'Deskripsi berita akan ditampilkan di sini.' }}
                            @endif
                        </p>
                        <a href="{{ route('berita.show', $item->id ?? '#') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


@endsection