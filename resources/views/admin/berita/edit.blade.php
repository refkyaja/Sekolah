{{-- resources/views/admin/berita/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Berita - TK Harapan Bangsa 1')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">
            Edit Berita
        </h2>
        <a href="{{ route('admin.berita.index') }}" 
           class="text-sm text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.berita.update', $berita->id) }}" 
              method="POST" 
              enctype="multipart/form-data"
              id="formBerita">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri (2/3) - Form Utama --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul"
                               name="judul" 
                               value="{{ old('judul', $berita->judul) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('judul') border-red-500 @enderror"
                               placeholder="Masukkan judul berita"
                               required>
                        @error('judul')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Isi Berita --}}
                    <div>
                        <label for="isi_berita" class="block text-sm font-medium text-gray-700 mb-2">
                            Isi Berita <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi_berita" 
                                  id="isi_berita"
                                  rows="12"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('isi_berita') border-red-500 @enderror"
                                  placeholder="Tulis isi berita di sini..."
                                  required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                        @error('isi_berita')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                {{-- Kolom Kanan (1/3) - Info Tambahan --}}
                <div class="space-y-6">
                    {{-- Gambar Utama --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Utama
                        </label>
                        
                        {{-- Tampilkan gambar saat ini --}}
                        @if($berita->gambar)
                        <div class="mb-4">
                            <div class="relative inline-block">
                                <img src="{{ Storage::url($berita->gambar) }}" 
                                     alt="Gambar Berita" 
                                     class="h-32 w-full object-cover rounded-lg border-2 border-gray-200">
                                <span class="absolute -top-2 -right-2 px-2 py-1 bg-green-600 text-white text-xs rounded-full shadow-lg">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <i class="fas fa-image mr-1"></i> Gambar saat ini
                            </p>
                        </div>
                        @endif
                        
                        {{-- Dropzone Area untuk upload baru --}}
                        <div class="border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all cursor-pointer group"
                             id="dropzone">
                            <div class="p-4 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-indigo-500 transition-colors" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="font-semibold">Klik</span> atau <span class="font-semibold">drag & drop</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Format: JPG, PNG, GIF (max 2MB)
                                </p>
                                <input type="file" 
                                       id="gambar"
                                       name="gambar" 
                                       class="hidden"
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                            </div>
                        </div>
                        
                        {{-- Preview Gambar Baru --}}
                        <div id="imagePreviewContainer" class="hidden mt-4">
                            <label class="block text-xs font-medium text-gray-700 mb-2">
                                Preview Gambar Baru:
                            </label>
                            <div class="relative inline-block">
                                <img id="previewImage" 
                                     class="h-32 w-full object-cover rounded-lg border-2 border-indigo-200">
                                <button type="button" 
                                        id="removeImage"
                                        class="absolute -top-2 -right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i> Gambar baru akan menggantikan yang lama
                            </p>
                        </div>
                        
                        @error('gambar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Penulis --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">
                            Penulis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="penulis"
                               name="penulis" 
                               value="{{ old('penulis', $berita->penulis) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('penulis') border-red-500 @enderror"
                               placeholder="Nama penulis"
                               required>
                        @error('penulis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Tanggal Publish --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="tanggal_publish" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Publish <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="tanggal_publish"
                               name="tanggal_publish" 
                               value="{{ old('tanggal_publish', $berita->tanggal_publish instanceof \Carbon\Carbon ? $berita->tanggal_publish->format('Y-m-d\TH:i') : date('Y-m-d\TH:i', strtotime($berita->tanggal_publish))) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tanggal_publish') border-red-500 @enderror"
                               required>
                        @error('tanggal_publish')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Status --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>
                                Draft - Simpan sebagai konsep
                            </option>
                            <option value="publish" {{ old('status', $berita->status) == 'publish' ? 'selected' : '' }}>
                                Publish - Langsung terbitkan
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Meta Info --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">
                            Informasi Berita
                        </h4>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Dibuat:</span>
                                <span class="text-gray-700">{{ $berita->created_at ? $berita->created_at->format('d M Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Diperbarui:</span>
                                <span class="text-gray-700">{{ $berita->updated_at ? $berita->updated_at->format('d M Y H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Dilihat:</span>
                                <span class="text-gray-700">{{ number_format($berita->views ?? 0) }}x</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.berita.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit" 
                        id="btnSubmit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-dashed {
        transition: all 0.2s ease;
        border-width: 2px;
    }
    
    /* Animasi untuk preview */
    #imagePreviewContainer {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Styling untuk textarea */
    textarea {
        resize: vertical;
        min-height: 200px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== ELEMENTS ==========
    const imageInput = document.getElementById('gambar');
    const dropzone = document.getElementById('dropzone');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('previewImage');
    const removeImageBtn = document.getElementById('removeImage');
    const form = document.getElementById('formBerita');
    const btnSubmit = document.getElementById('btnSubmit');
    
    // ========== CONSTANTS ==========
    const MAX_SIZE = 2 * 1024 * 1024; // 2MB
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
    // ========== EVENT LISTENERS ==========
    
    // Click dropzone
    if (dropzone) {
        dropzone.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                imageInput.click();
            }
        });
    }
    
    // Drag & drop events
    if (dropzone) {
        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-indigo-500', 'bg-indigo-100');
        });
        
        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-500', 'bg-indigo-100');
        });
        
        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-indigo-500', 'bg-indigo-100');
            
            const file = e.dataTransfer.files[0];
            if (file) {
                handleImageFile(file);
            }
        });
    }
    
    // File input change
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                handleImageFile(this.files[0]);
            }
            this.value = ''; // Reset input
        });
    }
    
    // Remove image button
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function() {
            removeImage();
        });
    }
    
    // Form validation
    if (form) {
        form.addEventListener('submit', function(e) {
            // Disable submit button
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
        });
    }
    
    // ========== FUNCTIONS ==========
    
    function handleImageFile(file) {
        // Check file type
        if (!ALLOWED_TYPES.includes(file.type)) {
            alert('Format file harus JPG, PNG, atau GIF!');
            return;
        }
        
        // Check file size
        if (file.size > MAX_SIZE) {
            alert('Ukuran file maksimal 2MB!');
            return;
        }
        
        // Preview image
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            
            // Create a new File object and set it to input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;
        };
        
        reader.readAsDataURL(file);
    }
    
    function removeImage() {
        // Clear preview
        previewImage.src = '';
        previewContainer.classList.add('hidden');
        
        // Clear file input
        imageInput.value = '';
        
        // Clear any error
        const errorElement = document.querySelector('.text-red-600');
        if (errorElement) {
            errorElement.remove();
        }
    }
    
    // Auto-resize textarea
    const textarea = document.getElementById('isi_berita');
    if (textarea) {
        // Set initial height
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
        
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endpush