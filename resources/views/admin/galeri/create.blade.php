{{-- resources/views/admin/galeri/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Galeri Baru')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">
            Tambah Galeri Baru
        </h2>
        <a href="{{ route('admin.galeri.index') }}" 
           class="text-sm text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.galeri.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              id="formGaleri">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri (2/3) - Form Utama --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Galeri <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="judul"
                               name="judul" 
                               value="{{ old('judul') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror"
                               placeholder="Masukkan judul galeri"
                               required>
                        @error('judul')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" 
                                  id="deskripsi"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror"
                                  placeholder="Deskripsikan galeri ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Multiple Gambar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Gambar <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- Dropzone Area --}}
                        <div class="border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all cursor-pointer group"
                             id="dropzone">
                            <div class="p-8 text-center">
                                {{-- Icon --}}
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition-colors" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                
                                {{-- Text --}}
                                <div class="mt-4 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">
                                    <span class="font-semibold">Klik untuk upload</span>
                                    <span>atau drag and drop</span>
                                </div>
                                
                                <p class="text-xs text-gray-500 mt-2">
                                    Format: JPG, JPEG, PNG, GIF (Max 5MB per file)
                                </p>
                                <p class="text-xs text-gray-500">
                                    Minimal 1 gambar, maksimal 10 gambar
                                </p>
                                
                                {{-- Hidden Input --}}
                                <input type="file" 
                                       id="gambar"
                                       name="gambar[]" 
                                       class="hidden"
                                       multiple
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       required>
                            </div>
                        </div>
                        
                        {{-- Error Messages --}}
                        @error('gambar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('gambar.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        {{-- File Info & Preview --}}
                        <div id="previewSection" class="mt-4 space-y-4">
                            {{-- File Counter --}}
                            <div id="fileCounter" class="hidden">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-images text-blue-500"></i>
                                        <span class="text-sm font-medium text-blue-700">
                                            <span id="fileCount">0</span> gambar dipilih
                                        </span>
                                    </div>
                                    <button type="button" 
                                            id="clearAllBtn"
                                            class="text-xs text-red-600 hover:text-red-800 font-medium">
                                        <i class="fas fa-trash mr-1"></i>Hapus semua
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Preview Container --}}
                            <div id="imagePreviews" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4"></div>
                        </div>
                    </div>
                </div>
                
                {{-- Kolom Kanan (1/3) - Info Tambahan --}}
                <div class="space-y-6">
                    {{-- Kategori --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" 
                                id="kategori"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kategori') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="prestasi" {{ old('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="fasilitas" {{ old('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="acara" {{ old('kategori') == 'acara' ? 'selected' : '' }}>Acara Khusus</option>
                            <option value="harian" {{ old('kategori') == 'harian' ? 'selected' : '' }}>Kegiatan Harian</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Tanggal --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal"
                               name="tanggal" 
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal') border-red-500 @enderror"
                               required>
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Lokasi --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi
                        </label>
                        <input type="text" 
                               id="lokasi"
                               name="lokasi" 
                               value="{{ old('lokasi', 'TK Harapan Bangsa 1') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lokasi') border-red-500 @enderror"
                               placeholder="Tempat kegiatan">
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Status Publish --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="flex items-start space-x-3">
                            <input type="checkbox" 
                                   name="is_published" 
                                   value="1"
                                   class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ old('is_published', true) ? 'checked' : '' }}>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Publish langsung</span>
                                <p class="text-xs text-gray-500 mt-1">
                                    Jika tidak dicentang, galeri akan disimpan sebagai draft
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="mt-8 flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.galeri.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit" 
                        id="btnSubmit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Galeri
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
    
    .preview-item {
        animation: fadeIn 0.3s ease;
        position: relative;
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
    
    /* Hapus button style */
    .remove-btn {
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .preview-item:hover .remove-btn {
        opacity: 1;
    }
    
    /* Image container */
    .image-container {
        position: relative;
        padding-bottom: 100%;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    
    .image-container img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== ELEMENTS ==========
    const imageInput = document.getElementById('gambar');
    const dropzone = document.getElementById('dropzone');
    const previewContainer = document.getElementById('imagePreviews');
    const fileCounter = document.getElementById('fileCounter');
    const fileCountSpan = document.getElementById('fileCount');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const btnSubmit = document.getElementById('btnSubmit');
    const form = document.getElementById('formGaleri');
    
    // ========== CONSTANTS ==========
    const MAX_FILES = 10;
    const MAX_SIZE = 5 * 1024 * 1024; // 5MB
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
    // ========== STATE ==========
    let selectedFiles = [];
    
    // ========== EVENT LISTENERS ==========
    
    // Click dropzone
    dropzone.addEventListener('click', function(e) {
        if (e.target.tagName !== 'INPUT') {
            imageInput.click();
        }
    });
    
    // Prevent click on label from propagating
    dropzone.querySelector('label')?.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Drag & drop events
    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-blue-500', 'bg-blue-100');
    });
    
    dropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-100');
    });
    
    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-blue-500', 'bg-blue-100');
        
        const files = Array.from(e.dataTransfer.files).filter(file => 
            ALLOWED_TYPES.includes(file.type)
        );
        
        if (files.length > 0) {
            handleFiles(files);
        } else {
            alert('Hanya file gambar yang diperbolehkan!');
        }
    });
    
    // File input change
    imageInput.addEventListener('change', function(e) {
        const files = Array.from(this.files);
        handleFiles(files);
        this.value = ''; // Reset input
    });
    
    // Clear all button
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            selectedFiles = [];
            updatePreview();
        });
    }
    
    // Form validation
    form.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Minimal 1 gambar harus diupload!');
            return;
        }
        
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
    
    // ========== FUNCTIONS ==========
    
    function handleFiles(files) {
        // Validate number of files
        if (selectedFiles.length + files.length > MAX_FILES) {
            alert(`Maksimal ${MAX_FILES} file yang dapat diupload!`);
            return;
        }
        
        // Validate each file
        const validFiles = files.filter(file => {
            // Check file type
            if (!ALLOWED_TYPES.includes(file.type)) {
                alert(`File "${file.name}" bukan gambar!`);
                return false;
            }
            
            // Check file size
            if (file.size > MAX_SIZE) {
                alert(`File "${file.name}" melebihi 5MB!`);
                return false;
            }
            
            // Check duplicate (by name and size)
            const isDuplicate = selectedFiles.some(f => 
                f.name === file.name && f.size === file.size
            );
            
            if (isDuplicate) {
                alert(`File "${file.name}" sudah dipilih!`);
                return false;
            }
            
            return true;
        });
        
        // Add valid files
        selectedFiles = [...selectedFiles, ...validFiles];
        updatePreview();
    }
    
    function updatePreview() {
        // Update counter
        if (selectedFiles.length > 0) {
            fileCounter.classList.remove('hidden');
            fileCountSpan.textContent = selectedFiles.length;
            btnSubmit.disabled = false;
        } else {
            fileCounter.classList.add('hidden');
            btnSubmit.disabled = true;
        }
        
        // Clear preview
        previewContainer.innerHTML = '';
        
        // Create preview for each file
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.setAttribute('data-index', index);
                
                previewItem.innerHTML = `
                    <div class="image-container border-2 border-gray-200 group-hover:border-blue-500 transition-all">
                        <img src="${e.target.result}" 
                             alt="${file.name}"
                             loading="lazy">
                        
                        {{-- Hapus button --}}
                        <button type="button" 
                                onclick="removeFile(${index})"
                                class="remove-btn absolute top-1 right-1 p-1.5 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all z-10"
                                title="Hapus">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        {{-- File number --}}
                        <span class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                            ${index + 1}
                        </span>
                        
                        {{-- File size --}}
                        <span class="absolute bottom-1 right-1 bg-black bg-opacity-75 text-white text-xs px-1.5 py-0.5 rounded-full">
                            ${formatFileSize(file.size)}
                        </span>
                    </div>
                    
                    {{-- File name --}}
                    <p class="mt-1 text-xs text-gray-600 truncate px-1" title="${file.name}">
                        ${file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name}
                    </p>
                `;
                
                previewContainer.appendChild(previewItem);
            };
            
            reader.readAsDataURL(file);
        });
        
        // Update file input
        updateFileInput();
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        imageInput.files = dataTransfer.files;
    }
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }
    
    // Global function to remove file
    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updatePreview();
    };
});
</script>
@endpush