{{-- resources/views/berita/show.blade.php --}}
@extends('layouts.frontend')

@section('title', $berita->judul . ' - TK Harapan Bangsa 1')

@section('meta')
    {{-- Meta tags untuk SEO dan Social Media --}}
    <meta name="description" content="{{ Str::limit(strip_tags($berita->isi_berita), 160) }}">
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($berita->isi_berita), 200) }}">
    @if($berita->gambar)
    <meta property="og:image" content="{{ Storage::url($berita->gambar) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $berita->tanggal_publish?->toIso8601String() }}">
    <meta property="article:author" content="{{ $berita->penulis ?? 'TK Harapan Bangsa 1' }}">
    <meta name="twitter:card" content="summary_large_image">
    
    {{-- Viewport untuk responsive --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
@endsection

@section('content')
{{-- Hero Section Sederhana dengan background yang lebih responsive --}}
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-white">
            {{-- Breadcrumb responsive --}}
            <div class="flex items-center text-xs sm:text-sm mb-3 md:mb-4 overflow-x-auto pb-2 whitespace-nowrap scrollbar-hide">
                <a href="{{ route('home') }}" class="hover:underline flex-shrink-0">Beranda</a>
                <i class="fas fa-chevron-right mx-1 sm:mx-2 text-[10px] sm:text-xs flex-shrink-0"></i>
                <a href="{{ route('berita.index') }}" class="hover:underline flex-shrink-0">Berita</a>
                <i class="fas fa-chevron-right mx-1 sm:mx-2 text-[10px] sm:text-xs flex-shrink-0"></i>
                <span class="text-white/80 truncate flex-shrink-0">Detail Berita</span>
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold leading-tight">
                {{ $berita->judul }}
            </h1>
        </div>
    </div>
</div>

{{-- Konten Berita --}}
<section class="py-8 md:py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            {{-- Kolom Kiri (2/3) - Konten Utama --}}
            <div class="lg:col-span-2">
                {{-- Card Utama --}}
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Gambar Utama dengan fitur fullscreen --}}
                    @if($berita->gambar)
                    <div class="relative group cursor-pointer" onclick="openFullscreen(this)">
                        <div class="relative h-[250px] sm:h-[300px] md:h-[350px] lg:h-[400px] overflow-hidden bg-gray-100">
                            <img src="{{ Storage::url($berita->gambar) }}" 
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy"
                                 id="mainImage">
                            
                            {{-- Overlay Gradien --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            
                            {{-- Tombol Fullscreen --}}
                            <button onclick="event.stopPropagation(); openFullscreen(this)" 
                                    class="absolute bottom-4 right-4 bg-black/70 hover:bg-black/90 text-white p-2.5 rounded-full transition-all duration-300 transform hover:scale-110 shadow-lg z-10">
                                <i class="fas fa-expand text-sm sm:text-base"></i>
                            </button>
                            
                            {{-- Badge Status --}}
                            @if($berita->created_at && $berita->created_at->diffInDays(now()) < 7)
                            <div class="absolute top-4 left-4">
                                <span class="px-2 sm:px-3 py-1 bg-red-500 text-white text-xs sm:text-sm font-medium rounded-full shadow-lg">
                                    <i class="fas fa-newspaper mr-1"></i> Berita Baru
                                </span>
                            </div>
                            @endif
                            
                            {{-- Indikator Klik untuk Zoom --}}
                            <div class="absolute bottom-4 left-4 bg-black/50 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                <i class="fas fa-search-plus mr-1"></i> Klik untuk perbesar
                            </div>
                        </div>
                    </div>
                    
                    {{-- Modal Fullscreen --}}
                    <div id="fullscreenModal" class="fixed inset-0 z-50 hidden bg-black/95 flex items-center justify-center" onclick="closeFullscreen()">
                        <div class="relative w-full h-full flex items-center justify-center p-4">
                            {{-- Tombol Close --}}
                            <button onclick="closeFullscreen()" class="absolute top-4 right-4 text-white bg-black/50 hover:bg-black/70 p-3 rounded-full transition-all z-10">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                            
                            {{-- Tombol Zoom In/Out --}}
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 bg-black/50 p-2 rounded-full backdrop-blur-sm">
                                <button onclick="zoomImage('out')" class="text-white hover:bg-white/20 p-2 rounded-full transition">
                                    <i class="fas fa-search-minus"></i>
                                </button>
                                <button onclick="zoomImage('in')" class="text-white hover:bg-white/20 p-2 rounded-full transition">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                                <button onclick="resetZoom()" class="text-white hover:bg-white/20 p-2 rounded-full transition">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                            
                            {{-- Gambar Fullscreen --}}
                            <img id="fullscreenImage" src="{{ Storage::url($berita->gambar) }}" 
                                 alt="{{ $berita->judul }}"
                                 class="max-w-full max-h-full object-contain transition-transform duration-300 cursor-move"
                                 style="transform: scale(1);"
                                 onmousedown="startDrag(event)"
                                 onmousemove="drag(event)"
                                 onmouseup="stopDrag()"
                                 onmouseleave="stopDrag()">
                        </div>
                    </div>
                    @endif
                    
                    {{-- Meta Info dengan responsive grid --}}
                    <div class="p-4 sm:p-5 md:p-6 border-b border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 text-sm text-gray-600">
                            {{-- Penulis --}}
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-2 flex-shrink-0">
                                    <i class="fas fa-user text-xs sm:text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-gray-500 text-xs">Penulis</span>
                                    <p class="font-medium text-gray-900 truncate">{{ $berita->penulis ?? 'Admin' }}</p>
                                </div>
                            </div>
                            
                            {{-- Tanggal --}}
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-2 flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-xs sm:text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-gray-500 text-xs">Dipublikasikan</span>
                                    <p class="font-medium text-gray-900 truncate">
                                        {{ $berita->tanggal_publish ? $berita->tanggal_publish->format('d F Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            
                            {{-- Views --}}
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-2 flex-shrink-0">
                                    <i class="fas fa-eye text-xs sm:text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-gray-500 text-xs">Dilihat</span>
                                    <p class="font-medium text-gray-900">{{ number_format($berita->views ?? 0) }} kali</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Kategori (jika ada) --}}
                        @if(isset($berita->kategori))
                        <div class="mt-3 flex items-center text-sm">
                            <i class="fas fa-tag text-gray-400 mr-2"></i>
                            <span class="text-gray-600">Kategori:</span>
                            <span class="ml-2 px-2 sm:px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                                {{ $berita->kategori }}
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Isi Berita dengan responsive typography --}}
                    <div class="p-4 sm:p-5 md:p-6">
                        <div class="prose prose-sm sm:prose-base md:prose-lg max-w-none">
                            {!! nl2br(e($berita->isi_berita)) !!}
                        </div>
                        
                        {{-- Share Buttons responsive --}}
                        <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Bagikan Berita:</h4>
                            <div class="flex flex-wrap gap-2">
                                {{-- Facebook --}}
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                   target="_blank"
                                   class="flex items-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm"
                                   onclick="window.open(this.href, 'facebook-share', 'width=580,height=296'); return false;">
                                    <i class="fab fa-facebook-f mr-1 sm:mr-2"></i>
                                    <span class="hidden xs:inline">Facebook</span>
                                </a>
                                
                                {{-- Twitter --}}
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(url()->current()) }}" 
                                   target="_blank"
                                   class="flex items-center px-3 sm:px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors text-sm"
                                   onclick="window.open(this.href, 'twitter-share', 'width=550,height=235'); return false;">
                                    <i class="fab fa-twitter mr-1 sm:mr-2"></i>
                                    <span class="hidden xs:inline">Twitter</span>
                                </a>
                                
                                {{-- WhatsApp --}}
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" 
                                   target="_blank"
                                   class="flex items-center px-3 sm:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    <i class="fab fa-whatsapp mr-1 sm:mr-2"></i>
                                    <span class="hidden xs:inline">WhatsApp</span>
                                </a>
                                
                                {{-- Telegram --}}
                                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" 
                                   target="_blank"
                                   class="flex items-center px-3 sm:px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                    <i class="fab fa-telegram-plane mr-1 sm:mr-2"></i>
                                    <span class="hidden xs:inline">Telegram</span>
                                </a>
                                
                                {{-- Copy Link --}}
                                <button onclick="copyToClipboard()" 
                                        class="flex items-center px-3 sm:px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm"
                                        id="copyButton">
                                    <i class="fas fa-link mr-1 sm:mr-2"></i>
                                    <span class="hidden xs:inline">Salin Link</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Kolom Kanan (1/3) - Sidebar dengan responsive spacing --}}
            <div class="space-y-4 md:space-y-6">
                {{-- CARD BERITA LAINNYA --}}
                @if(isset($beritaLainnya) && $beritaLainnya->count() > 0)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">
                            <i class="fas fa-layer-group text-blue-600 mr-2"></i>
                            Berita Lainnya
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($beritaLainnya as $lainnya)
                            <a href="{{ route('berita.show', $lainnya->slug) }}" 
                               class="block group">
                                <div class="flex items-start space-x-2 sm:space-x-3">
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($lainnya->gambar)
                                            <img src="{{ Storage::url($lainnya->gambar) }}" 
                                                 alt="{{ $lainnya->judul }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-blue-50">
                                                <i class="fas fa-newspaper text-blue-400 text-lg sm:text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $lainnya->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $lainnya->tanggal_publish ? $lainnya->tanggal_publish->format('d M Y') : '-' }}
                                        </p>
                                        @if($lainnya->views)
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ number_format($lainnya->views) }} dilihat
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        
                        <div class="mt-3 sm:mt-4 text-center">
                            <a href="{{ route('berita.index') }}" 
                               class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua Berita
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Card Berita Terkait --}}
                @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">
                            <i class="fas fa-newspaper text-indigo-600 mr-2"></i>
                            Berita Terkait
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($beritaTerkait as $terkait)
                            <a href="{{ route('berita.show', $terkait->slug) }}" 
                               class="block group">
                                <div class="flex items-start space-x-2 sm:space-x-3">
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($terkait->gambar)
                                            <img src="{{ Storage::url($terkait->gambar) }}" 
                                                 alt="{{ $terkait->judul }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-50">
                                                <i class="fas fa-newspaper text-indigo-400 text-lg sm:text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                            {{ $terkait->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $terkait->tanggal_publish ? $terkait->tanggal_publish->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                {{-- Card Berita Terbaru --}}
                @if(isset($beritaTerbaru) && $beritaTerbaru->count() > 0)
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">
                            <i class="fas fa-clock text-green-600 mr-2"></i>
                            Berita Terbaru
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($beritaTerbaru as $terbaru)
                            <a href="{{ route('berita.show', $terbaru->slug) }}" 
                               class="block group">
                                <div class="flex items-start space-x-2 sm:space-x-3">
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($terbaru->gambar)
                                            <img src="{{ Storage::url($terbaru->gambar) }}" 
                                                 alt="{{ $terbaru->judul }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-green-50">
                                                <i class="fas fa-newspaper text-green-400 text-lg sm:text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-medium text-gray-900 group-hover:text-green-600 transition-colors line-clamp-2">
                                            {{ $terbaru->judul }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $terbaru->tanggal_publish ? $terbaru->tanggal_publish->diffForHumans() : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* Styling untuk konten berita */
    .prose {
        line-height: 1.6;
        color: #374151;
        font-size: 0.95rem;
    }
    
    @media (min-width: 640px) {
        .prose {
            font-size: 1rem;
            line-height: 1.7;
        }
    }
    
    @media (min-width: 1024px) {
        .prose {
            font-size: 1.05rem;
            line-height: 1.8;
        }
    }
    
    .prose p {
        margin-bottom: 1.25em;
    }
    
    .prose h1, .prose h2, .prose h3 {
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        font-weight: 600;
        color: #111827;
    }
    
    .prose h1 {
        font-size: 1.5em;
    }
    
    .prose h2 {
        font-size: 1.25em;
    }
    
    .prose h3 {
        font-size: 1.1em;
    }
    
    @media (min-width: 640px) {
        .prose h1 {
            font-size: 1.8em;
        }
        
        .prose h2 {
            font-size: 1.4em;
        }
        
        .prose h3 {
            font-size: 1.2em;
        }
    }
    
    @media (min-width: 1024px) {
        .prose h1 {
            font-size: 2em;
        }
        
        .prose h2 {
            font-size: 1.5em;
        }
        
        .prose h3 {
            font-size: 1.25em;
        }
    }
    
    .prose ul, .prose ol {
        margin-bottom: 1.25em;
        padding-left: 1.5em;
    }
    
    .prose li {
        margin-bottom: 0.5em;
    }
    
    .prose blockquote {
        border-left: 4px solid #6366f1;
        padding-left: 1em;
        font-style: italic;
        color: #4b5563;
        margin: 1.5em 0;
    }
    
    .prose img {
        border-radius: 0.5rem;
        margin: 1.5em 0;
        max-width: 100%;
        height: auto;
    }
    
    /* Line clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Animasi untuk copy button */
    #copyButton.success {
        background-color: #10b981;
    }
    
    /* Hide scrollbar for breadcrumb */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Fullscreen modal styles */
    #fullscreenModal {
        backdrop-filter: blur(8px);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    
    /* Touch optimization untuk mobile */
    @media (hover: none) and (pointer: coarse) {
        .group:hover .group-hover\:scale-110 {
            transform: none;
        }
        
        button, a {
            min-height: 44px;
            min-width: 44px;
        }
    }
    
    /* Hide text on very small screens */
    @media (max-width: 380px) {
        .xs\:inline {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Fungsi untuk copy link
    function copyToClipboard() {
        const url = window.location.href;
        const button = document.getElementById('copyButton');
        const originalText = button.innerHTML;
        
        navigator.clipboard.writeText(url).then(function() {
            button.innerHTML = '<i class="fas fa-check mr-1 sm:mr-2"></i><span class="hidden xs:inline">Tersalin!</span>';
            button.classList.add('success');
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('success');
            }, 2000);
        }, function() {
            alert('Gagal menyalin link. Silakan coba manual.');
        });
    }
    
    // Fullscreen image functionality
    let isDragging = false;
    let startX, startY;
    let translateX = 0, translateY = 0;
    let scale = 1;
    let fullscreenImage;
    
    function openFullscreen(element) {
        const modal = document.getElementById('fullscreenModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        fullscreenImage = document.getElementById('fullscreenImage');
        resetZoom();
    }
    
    function closeFullscreen() {
        const modal = document.getElementById('fullscreenModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        resetZoom();
    }
    
    function zoomImage(direction) {
        if (!fullscreenImage) return;
        
        if (direction === 'in') {
            scale = Math.min(scale + 0.5, 3);
        } else {
            scale = Math.max(scale - 0.5, 1);
        }
        
        fullscreenImage.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
    }
    
    function resetZoom() {
        scale = 1;
        translateX = 0;
        translateY = 0;
        if (fullscreenImage) {
            fullscreenImage.style.transform = `scale(1) translate(0px, 0px)`;
        }
    }
    
    // Drag functionality for zoomed image
    function startDrag(e) {
        if (scale <= 1) return;
        
        isDragging = true;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        fullscreenImage.style.cursor = 'grabbing';
    }
    
    function drag(e) {
        if (!isDragging || scale <= 1) return;
        e.preventDefault();
        
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        
        fullscreenImage.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
    }
    
    function stopDrag() {
        isDragging = false;
        if (fullscreenImage) {
            fullscreenImage.style.cursor = 'move';
        }
    }
    
    // Touch events for mobile
    document.addEventListener('DOMContentLoaded', function() {
        fullscreenImage = document.getElementById('fullscreenImage');
        
        if (fullscreenImage) {
            fullscreenImage.addEventListener('touchstart', (e) => {
                if (scale <= 1) return;
                e.preventDefault();
                const touch = e.touches[0];
                startX = touch.clientX - translateX;
                startY = touch.clientY - translateY;
                isDragging = true;
            });
            
            fullscreenImage.addEventListener('touchmove', (e) => {
                if (!isDragging || scale <= 1) return;
                e.preventDefault();
                const touch = e.touches[0];
                translateX = touch.clientX - startX;
                translateY = touch.clientY - startY;
                fullscreenImage.style.transform = `scale(${scale}) translate(${translateX}px, ${translateY}px)`;
            });
            
            fullscreenImage.addEventListener('touchend', () => {
                isDragging = false;
            });
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFullscreen();
        }
    });
    
    // Tracking views
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route("berita.show", $berita->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).catch(error => {
            console.log('Error tracking view:', error);
        });
    });
</script>
@endpush