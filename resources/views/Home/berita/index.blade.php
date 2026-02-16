{{-- resources/views/berita/index.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Berita - TK Harapan Bangsa 1')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 py-12">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Berita Sekolah</h1>
        <p class="text-lg md:text-xl opacity-90">Informasi terkini dari TK Harapan Bangsa 1</p>
    </div>
</div>

<!-- Berita Section -->
<div class="container mx-auto px-4 py-8">
    @if($beritas->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($beritas as $berita)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
            <div class="relative overflow-hidden h-48">
                @if($berita->gambar && Storage::disk('public')->exists($berita->gambar))
                    <img src="{{ asset('storage/' . $berita->gambar) }}"
                         alt="{{ $berita->judul }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-blue-400"></i>
                    </div>
                @endif
                
                <!-- Badge Tanggal (konsisten dengan galeri) -->
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 text-xs font-medium bg-white/90 backdrop-blur-sm rounded-full shadow-sm">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ $berita->tanggal_publish ? $berita->tanggal_publish->format('d M Y') : now()->format('d M Y') }}
                    </span>
                </div>
                
                <!-- Badge Views (konsisten dengan galeri) -->
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 text-xs font-medium bg-black/70 text-white rounded-full shadow-sm">
                        <i class="far fa-eye mr-1"></i>
                        {{ number_format($berita->views ?? 0) }}
                    </span>
                </div>
            </div>
            
            <div class="p-5">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <i class="fas fa-user mr-1"></i>
                    {{ $berita->penulis ?? 'Admin' }}
                </div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 hover:text-indigo-600 transition-colors">
                    <a href="{{ route('berita.show', $berita->slug) }}" class="hover:text-indigo-600">
                        {{ $berita->judul }}
                    </a>
                </h3>
                
                <div class="text-gray-600 mb-4 line-clamp-2 text-sm">
                    @if($berita->isi_berita)
                        {{ Str::limit(strip_tags($berita->isi_berita), 80) }}
                    @else
                        Tidak ada konten
                    @endif
                </div>
                
                <a href="{{ route('berita.show', $berita->slug) }}"
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                    Baca Selengkapnya
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($beritas->hasPages())
    <div class="mt-8">
        {{ $beritas->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
    @endif

    @else
    <!-- Empty State (Konsisten dengan Galeri) -->
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-newspaper text-5xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Berita</h3>
        <p class="text-gray-500">Tidak ada berita yang tersedia saat ini.</p>
        <div class="mt-6">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-home mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
    @endif
</div>

<!-- CTA Section (konsisten dengan galeri) -->
<section class="bg-gradient-to-br from-indigo-50 to-purple-100 py-16 mt-8">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ingin Mendapatkan Informasi Terkini?</h2>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
            Pantau terus berita terbaru dari TK Harapan Bangsa 1 untuk mengetahui perkembangan dan kegiatan siswa kami.
        </p>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300 shadow-md hover:shadow-lg">
            <i class="fas fa-home mr-2"></i> Kembali ke Beranda
        </a>
    </div>
</section>
@endsection