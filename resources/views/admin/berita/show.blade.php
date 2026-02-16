@extends('layouts.admin')

@section('title', 'Detail Berita - TK Harapan Bangsa 1')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="text-lg font-semibold text-gray-900">Detail Berita</h2>
            <div class="flex space-x-2">
                    @if($berita->status == 'draft')
                        <a href="{{ route('admin.berita.publish', $berita->id) }}" 
                        class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 inline-block">
                            <i class="fas fa-check mr-1"></i> Publish
                        </a>
                    @else
                        <a href="{{ route('admin.berita.unpublish', $berita->id) }}" 
                        class="px-3 py-1 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 inline-block">
                            <i class="fas fa-clock mr-1"></i> Jadikan Draft
                        </a>
                    @endif
                <a href="{{ route('admin.berita.edit', $berita) }}" 
                   class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ $berita->status == 'publish' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                <i class="{{ $berita->status == 'publish' ? 'fas fa-check-circle' : 'fas fa-clock' }} mr-1"></i>
                {{ $berita->status == 'publish' ? 'Published' : 'Draft' }}
            </span>
        </div>
        
        @if($berita->gambar)
        <div class="mb-6">
            <div class="flex flex-col items-start">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Gambar Utama</h3>
                <div class="relative group">
                    {{-- Gambar dengan ukuran kecil --}}
                    <img src="{{ Storage::url($berita->gambar) }}" 
                         alt="{{ $berita->judul }}"
                         class="rounded-lg max-w-md max-h-64 object-contain cursor-pointer"
                         onclick="openImageModal(this.src)">
                    
                    {{-- Tooltip untuk memperbesar --}}
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity duration-200 rounded-lg cursor-pointer flex items-center justify-center opacity-0 group-hover:opacity-100"
                         onclick="openImageModal('{{ Storage::url($berita->gambar) }}')">
                        <span class="bg-white px-3 py-1 rounded-lg text-sm shadow-lg">
                            <i class="fas fa-search-plus mr-1"></i> Klik untuk memperbesar
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Judul</h3>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $berita->judul }}</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">Slug URL</h3>
                <p class="mt-1 text-gray-900 font-mono">{{ $berita->slug }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Penulis</h3>
                    <p class="mt-1 text-gray-900">{{ $berita->penulis }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tanggal Publish</h3>
                    <p class="mt-1 text-gray-900">{{ $berita->tanggal_publish->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Dibuat Oleh</h3>
                    <p class="mt-1 text-gray-900">{{ $berita->user->name ?? 'Admin' }}</p>
                </div>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-500">Isi Berita</h3>
                <div class="mt-2 p-4 bg-gray-50 rounded-lg">
                    <div class="prose max-w-none">
                        {!! $berita->isi_berita !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="text-sm text-gray-500 space-y-1">
                    <p>Dibuat: {{ $berita->created_at->format('d/m/Y H:i') }}</p>
                    <p>Diupdate: {{ $berita->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('admin.berita.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <form action="{{ route('admin.berita.destroy', $berita) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk gambar besar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-[90vh]">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg">
        <button onclick="closeImageModal()" 
                class="absolute -top-3 -right-3 bg-white text-gray-800 rounded-full w-8 h-8 flex items-center justify-center shadow-lg hover:bg-gray-100">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

@push('scripts')
<script>
// Fungsi untuk modal gambar
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Tutup modal dengan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeImageModal();
});

// Dapatkan dimensi gambar setelah load
document.addEventListener('DOMContentLoaded', function() {
    const img = document.querySelector('img[alt="{{ $berita->judul }}"]');
    if (img) {
        img.onload = function() {
            const dimensions = document.getElementById('image-dimensions');
            if (dimensions) {
                dimensions.textContent = `${this.naturalWidth} × ${this.naturalHeight}px`;
            }
        };
        
        // Jika gambar sudah di-cache
        if (img.complete) {
            const dimensions = document.getElementById('image-dimensions');
            if (dimensions) {
                dimensions.textContent = `${img.naturalWidth} × ${img.naturalHeight}px`;
            }
        }
    }
});
</script>
@endpush

<style>
/* Custom styles untuk gambar */
img.max-w-md {
    max-width: 28rem; /* 448px */
}

img.max-h-64 {
    max-height: 16rem; /* 256px */
}

/* Efek hover untuk gambar */
.group:hover img {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

/* Style untuk modal */
#imageModal {
    backdrop-filter: blur(4px);
}
</style>
@endsection