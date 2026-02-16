{{-- resources/views/admin/galeri/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Galeri - ' . $galeri->judul)

@section('header')
<div class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.galeri.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-semibold text-gray-900 truncate">
                    {{ $galeri->judul }}
                </h1>
            </div>
            <div class="flex space-x-2">
                <span class="px-3 py-1 text-sm rounded-full {{ $galeri->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $galeri->is_published ? 'PUBLISHED' : 'DRAFT' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Gambar</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $galeri->jumlah_gambar }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Dilihat</p>
                    <p class="text-xl font-semibold text-gray-900">{{ number_format($galeri->views ?? 0) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Tanggal Kegiatan</p>
                    <p class="text-base font-semibold text-gray-900">{{ $galeri->tanggal->format('d M Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-orange-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-base font-semibold text-gray-900 capitalize">{{ $galeri->kategori }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-4">
                {{-- Author Info --}}
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $galeri->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">Pembuat</p>
                            </div>
                        </div>
                        
                        @if($galeri->lokasi)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $galeri->lokasi }}</p>
                                <p class="text-xs text-gray-500">Lokasi</p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $galeri->created_at->format('d M Y H:i') }}</p>
                                <p class="text-xs text-gray-500">Dibuat</p>
                            </div>
                        </div>
                        
                        @if($galeri->updated_at != $galeri->created_at)
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $galeri->updated_at->format('d M Y H:i') }}</p>
                                <p class="text-xs text-gray-500">Diupdate</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="p-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Aksi</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.galeri.edit', $galeri) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Galeri
                        </a>
                        
                        <form action="{{ route('admin.galeri.toggle-publish', $galeri) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-2 border {{ $galeri->is_published ? 'border-yellow-300 text-yellow-700 hover:bg-yellow-50' : 'border-green-300 text-green-700 hover:bg-green-50' }} rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($galeri->is_published)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H3m0 0l4-4M3 7l4 4m5 6h5m0 0l-4 4m4-4l-4-4"></path>
                                    @endif
                                </svg>
                                {{ $galeri->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        
                        <button type="button" 
                                onclick="confirmDelete({{ $galeri->id }})"
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Galeri
                        </button>
                    </div>
                </div>
                
                {{-- Share Links --}}
                <div class="p-4 border-t border-gray-100">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Bagikan</h3>
                    
                    <div class="flex space-x-2">
                        <button onclick="copyToClipboard()" class="flex-1 flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Main Content Area --}}
        <div class="lg:col-span-3 space-y-6">
            {{-- Description Card --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                </div>
                <div class="p-6">
                    @if($galeri->deskripsi)
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($galeri->deskripsi)) !!}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <p class="text-gray-500 italic">Tidak ada deskripsi untuk galeri ini</p>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- Gallery Card --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Galeri Foto</h2>
                        <p class="text-sm text-gray-500 mt-1">Klik gambar untuk melihat dalam ukuran besar</p>
                    </div>
                    
                    @if($galeri->gambar->count() > 0)
                    <div class="flex space-x-2">
                        <button onclick="playSlideShow()" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Slide Show
                        </button>
                        <span class="text-sm text-gray-500 self-center">
                            {{ $galeri->gambar->count() }} foto
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-6">
                    @if($galeri->gambar->count() > 0)
                        {{-- Masonry Grid --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-max">
                            @foreach($galeri->gambar as $index => $gambar)
                            <div class="group relative {{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                                <div class="relative overflow-hidden rounded-lg bg-gray-100 cursor-pointer {{ $index === 0 ? 'aspect-auto' : 'aspect-w-1 aspect-h-1' }}"
                                     onclick="openModal({{ $index }})">
                                    
                                    {{-- Image --}}
                                    <img src="{{ $gambar->url }}" 
                                         alt="{{ $galeri->judul }} - Foto {{ $index + 1 }}"
                                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                                         loading="lazy"
                                         onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';">
                                    
                                    {{-- Overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute bottom-0 left-0 right-0 p-3">
                                            <p class="text-white text-sm truncate">
                                                Foto #{{ $index + 1 }}
                                            </p>
                                            @if($index === 0)
                                            <span class="inline-block mt-1 px-2 py-0.5 bg-blue-600 text-white text-xs rounded">
                                                Cover
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Index Badge --}}
                                    <span class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded backdrop-blur-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    
                                    {{-- Zoom Icon --}}
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="bg-white bg-opacity-90 rounded-full p-2 transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Download Button --}}
                                <a href="{{ $gambar->url }}" 
                                   download
                                   class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-white"
                                   onclick="event.stopPropagation()"
                                   title="Download">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-16">
                            <div class="bg-gray-50 rounded-full w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Gambar</h3>
                            <p class="text-gray-500 mb-6">Galeri ini belum memiliki gambar. Tambahkan gambar sekarang!</p>
                            <a href="{{ route('admin.galeri.edit', $galeri) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Gambar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Gallery --}}
<div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden transition-opacity duration-300">
    <div class="absolute top-4 right-4 z-50 flex space-x-2">
        <button onclick="togglePlayPause()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full p-2 transition-colors">
            <svg id="playIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <svg id="pauseIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
        <button onclick="closeModal()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full p-2 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <button onclick="prevImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full p-3 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    
    <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full p-3 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    
    <div class="flex items-center justify-center h-full p-4">
        <div class="relative max-w-6xl max-h-full">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-screen object-contain">
            
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                <div class="flex justify-between items-end text-white">
                    <div>
                        <p id="modalTitle" class="text-lg font-medium">{{ $galeri->judul }}</p>
                        <p id="modalCounter" class="text-sm opacity-75"></p>
                    </div>
                    <p class="text-sm opacity-75">{{ $galeri->tanggal->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Form Delete Hidden --}}
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Gallery data
    const images = @json($galeri->gambar->map(function($gambar) {
        return [
            'url' => $gambar->url,
            'name' => $gambar->nama_file
        ];
    }));
    
    let currentIndex = 0;
    let slideshowInterval = null;
    let isPlaying = false;
    
    // Modal functions
    function openModal(index) {
        currentIndex = index;
        updateModalImage();
        document.getElementById('galleryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        stopSlideShow();
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    function updateModalImage() {
        if (images.length > 0) {
            document.getElementById('modalImage').src = images[currentIndex].url;
            document.getElementById('modalCounter').innerHTML = 
                `Foto ${currentIndex + 1} dari ${images.length}`;
        }
    }
    
    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateModalImage();
    }
    
    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        updateModalImage();
    }
    
    // Slideshow functions
    function playSlideShow() {
        if (images.length === 0) return;
        
        openModal(0);
        startSlideShow();
    }
    
    function startSlideShow() {
        if (slideshowInterval) clearInterval(slideshowInterval);
        
        slideshowInterval = setInterval(() => {
            nextImage();
        }, 3000);
        
        isPlaying = true;
        updatePlayPauseIcons();
    }
    
    function stopSlideShow() {
        if (slideshowInterval) {
            clearInterval(slideshowInterval);
            slideshowInterval = null;
        }
        isPlaying = false;
        updatePlayPauseIcons();
    }
    
    function togglePlayPause() {
        if (isPlaying) {
            stopSlideShow();
        } else {
            startSlideShow();
        }
    }
    
    function updatePlayPauseIcons() {
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        
        if (isPlaying) {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        } else {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        }
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('galleryModal');
        if (!modal.classList.contains('hidden')) {
            if (e.key === 'Escape') {
                closeModal();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === ' ') {
                e.preventDefault();
                togglePlayPause();
            }
        }
    });
    
    // Copy link function
    function copyToClipboard() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        }).catch(() => {
            alert('Gagal menyalin link');
        });
    }
    
    // Delete confirmation
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus galeri ini? Semua gambar akan ikut terhapus.')) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/galeri/${id}`;
            form.submit();
        }
    }
    
    // Clean up on page unload
    window.addEventListener('beforeunload', function() {
        if (slideshowInterval) {
            clearInterval(slideshowInterval);
        }
    });
</script>
@endpush