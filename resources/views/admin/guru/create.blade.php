{{-- resources/views/admin/guru/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('breadcrumb', 'Tambah Guru')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Tambah Data Guru</h2>
    </div>
    
    <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom 1 -->
            <div class="space-y-6">
                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" id="nip" name="nip" 
                           value="{{ old('nip') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="198001012022011001">
                    @error('nip')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" required
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nama lengkap guru">
                    @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Tempat & Tanggal Lahir -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                               value="{{ old('tempat_lahir') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Kota kelahiran">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                               value="{{ old('tanggal_lahir') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="L" required
                                   {{ old('jenis_kelamin') == 'L' ? 'checked' : 'checked' }}
                                   class="text-blue-600 focus:ring-blue-500">
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenis_kelamin" value="P"
                                   {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}
                                   class="text-pink-600 focus:ring-pink-500">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                    <textarea id="alamat" name="alamat" rows="3" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Kolom 2 -->
            <div class="space-y-6">
                <!-- No HP & Email -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP *</label>
                        <input type="tel" id="no_hp" name="no_hp" required
                               value="{{ old('no_hp') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="081234567890">
                        @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" id="email" name="email" required
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="guru@sekolah.com">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Jabatan (hanya guru dan staff) -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan *</label>
                <select id="jabatan" name="jabatan" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Jabatan</option>
                    <option value="guru" {{ old('jabatan') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="staff" {{ old('jabatan') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('jabatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Kelompok (hanya untuk guru) -->
            <div id="kelompok-container" class="hidden">
                <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-1">Kelompok *</label>
                <select id="kelompok" name="kelompok"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kelompok</option>
                    <option value="A" {{ old('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                    <option value="B" {{ old('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                </select>
                @error('kelompok')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Pendidikan Terakhir -->
            <div>
                <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir</label>
                <select id="pendidikan_terakhir" name="pendidikan_terakhir"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Pendidikan</option>
                    <option value="SMA" {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}>SMA/Sederajat</option>
                    <option value="D1" {{ old('pendidikan_terakhir') == 'D1' ? 'selected' : '' }}>Diploma 1</option>
                    <option value="D2" {{ old('pendidikan_terakhir') == 'D2' ? 'selected' : '' }}>Diploma 2</option>
                    <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>Diploma 3</option>
                    <option value="D4" {{ old('pendidikan_terakhir') == 'D4' ? 'selected' : '' }}>Diploma 4</option>
                    <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                    <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                    <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                </select>
            </div>
            
            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                <div class="mt-1 flex items-center space-x-4">
                    <div class="relative">
                        <input type="file" id="foto" name="foto" accept="image/*"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-colors">
                            <i class="fas fa-upload mr-2"></i> Pilih File
                        </div>
                    </div>
                    <div id="file-name" class="text-sm text-gray-500 truncate max-w-xs">
                        Tidak ada file dipilih
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Maksimal 2MB. Format: JPG, PNG, JPEG</p>
                @error('foto')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Preview -->
                <div id="image-preview" class="mt-3 hidden">
                    <img id="preview-image" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tombol Submit -->
    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
        <a href="{{ route('admin.guru.index') }}" 
           class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            Batal
        </a>
        <button type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-save mr-2"></i> Simpan Data
        </button>
    </div>
</form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview foto
    const fotoInput = document.getElementById('foto');
    const fileName = document.getElementById('file-name');
    const imagePreview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview-image');
    
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Update file name
                fileName.textContent = file.name;
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'Tidak ada file dipilih';
                imagePreview.classList.add('hidden');
            }
        });
    }
    
    // Set tanggal maksimum untuk tanggal lahir (minimal 18 tahun)
    const tanggalLahirInput = document.getElementById('tanggal_lahir');
    if (tanggalLahirInput) {
        const today = new Date();
        const minDate = new Date(today.getFullYear() - 65, today.getMonth(), today.getDate()); // Maks 65 tahun
        const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate()); // Minimal 18 tahun
        
        tanggalLahirInput.max = maxDate.toISOString().split('T')[0];
        tanggalLahirInput.min = minDate.toISOString().split('T')[0];
    }
    
    // Tampilkan/sembunyikan kelompok berdasarkan jabatan
    const jabatanSelect = document.getElementById('jabatan');
    const kelompokContainer = document.getElementById('kelompok-container');
    const kelompokSelect = document.getElementById('kelompok');
    
    function toggleKelompok() {
        if (jabatanSelect.value === 'guru') {
            kelompokContainer.classList.remove('hidden');
            kelompokSelect.required = true;
        } else {
            kelompokContainer.classList.add('hidden');
            kelompokSelect.required = false;
            kelompokSelect.value = '';
        }
    }
    
    // Set initial state
    toggleKelompok();
    
    // Add change event listener
    if (jabatanSelect) {
        jabatanSelect.addEventListener('change', toggleKelompok);
    }
    
    // Jika ada nilai old untuk kelompok, pastikan ditampilkan
    @if(old('jabatan') == 'guru')
        kelompokContainer.classList.remove('hidden');
        kelompokSelect.required = true;
    @endif
});
</script>
@endpush