{{-- resources/views/admin/tahun-ajaran/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran Baru')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-calendar-plus mr-2 text-blue-600"></i>Tambah Tahun Ajaran Baru
                </h1>
                <p class="text-gray-600 mt-2">Buat tahun ajaran baru untuk sistem PPDB dan akademik</p>
            </div>
            <a href="{{ route('admin.tahun-ajaran.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-3xl mx-auto">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                Formulir Tahun Ajaran
            </h3>
            <p class="text-sm text-gray-600 mt-1">Isi informasi tahun ajaran baru</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="tahun_ajaran"
                               name="tahun_ajaran" 
                               value="{{ old('tahun_ajaran') }}"
                               required
                               placeholder="Contoh: 2024/2025"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tahun_ajaran') border-red-500 @enderror">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Format: YYYY/YYYY (contoh: 2024/2025)</p>
                    @error('tahun_ajaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-layer-group text-gray-400"></i>
                        </div>
                        <select id="semester" 
                                name="semester" 
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('semester') border-red-500 @enderror">
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai dan Selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-play text-green-500"></i>
                            </div>
                            <input type="date" 
                                   id="tanggal_mulai"
                                   name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai') }}"
                                   required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_mulai') border-red-500 @enderror">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Tanggal dimulainya tahun ajaran</p>
                        @error('tanggal_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-stop text-red-500"></i>
                            </div>
                            <input type="date" 
                                   id="tanggal_selesai"
                                   name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai') }}"
                                   required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_selesai') border-red-500 @enderror">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Tanggal berakhirnya tahun ajaran</p>
                        @error('tanggal_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_aktif" 
                               name="is_aktif" 
                               value="1"
                               {{ old('is_aktif') ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500">
                        <label for="is_aktif" class="ml-3 block">
                            <span class="text-sm font-medium text-gray-900">Aktifkan tahun ajaran ini</span>
                            <span class="text-xs text-gray-500 block mt-1">
                                Jika dicentang, tahun ajaran ini akan menjadi tahun ajaran aktif dan 
                                tahun ajaran lain akan otomatis dinonaktifkan
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan (Opsional)
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <i class="fas fa-sticky-note text-gray-400"></i>
                        </div>
                        <textarea id="keterangan" 
                                  name="keterangan" 
                                  rows="4"
                                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keterangan') border-red-500 @enderror"
                                  placeholder="Tambahkan keterangan atau catatan tentang tahun ajaran ini...">{{ old('keterangan') }}</textarea>
                    </div>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <h4 class="text-sm font-medium text-yellow-800 flex items-center mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi
                    </h4>
                    <ul class="text-xs text-yellow-700 space-y-1 list-disc list-inside">
                        <li>Tahun ajaran yang aktif akan digunakan sebagai default di semua form</li>
                        <li>Pastikan tanggal mulai lebih awal dari tanggal selesai</li>
                        <li>Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025)</li>
                        <li>Anda dapat mengaktifkan/nonaktifkan tahun ajaran kapan saja</li>
                    </ul>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Simpan Tahun Ajaran
                    </button>
                    
                    <a href="{{ route('admin.tahun-ajaran.index') }}" 
                       class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-lg text-center transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi format tahun ajaran
        const tahunAjaranInput = document.getElementById('tahun_ajaran');
        
        tahunAjaranInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9/]/g, '');
            
            // Auto-format untuk tahun ajaran
            if (value.length === 4 && !value.includes('/')) {
                value = value + '/';
            }
            
            // Batasi panjang maksimal
            if (value.length > 9) {
                value = value.slice(0, 9);
            }
            
            this.value = value;
        });

        // Validasi tanggal selesai harus setelah tanggal mulai
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');

        function validateDates() {
            if (tanggalMulai.value && tanggalSelesai.value) {
                if (tanggalSelesai.value < tanggalMulai.value) {
                    tanggalSelesai.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
                } else {
                    tanggalSelesai.setCustomValidity('');
                }
            }
        }

        tanggalMulai.addEventListener('change', validateDates);
        tanggalSelesai.addEventListener('change', validateDates);

        // Set minimal date untuk tanggal selesai
        tanggalMulai.addEventListener('change', function() {
            tanggalSelesai.min = this.value;
        });

        // Tampilkan pesan error jika ada dari session
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    });

    // Fungsi untuk generate tahun ajaran otomatis
    function generateTahunAjaran() {
        const now = new Date();
        const tahunSekarang = now.getFullYear();
        const bulan = now.getMonth() + 1; // Januari = 1
        
        let tahunMulai, tahunSelesai;
        
        // Jika bulan >= 7 (Juli), tahun mulai = tahun sekarang, tahun selesai = tahun sekarang + 1
        // Jika bulan < 7, tahun mulai = tahun sekarang - 1, tahun selesai = tahun sekarang
        if (bulan >= 7) {
            tahunMulai = tahunSekarang;
            tahunSelesai = tahunSekarang + 1;
        } else {
            tahunMulai = tahunSekarang - 1;
            tahunSelesai = tahunSekarang;
        }
        
        return tahunMulai + '/' + tahunSelesai;
    }

    // Isi otomatis tahun ajaran jika kosong
    const tahunAjaranField = document.getElementById('tahun_ajaran');
    if (!tahunAjaranField.value) {
        tahunAjaranField.value = generateTahunAjaran();
    }
</script>
@endpush