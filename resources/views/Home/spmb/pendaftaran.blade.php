{{-- resources/views/ppdb/index.blade.php --}}
@extends('layouts.ppdb')

@section('title', 'Pendaftaran PPDB - TK Ceria Bangsa')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                    @if(session('no_pendaftaran'))
                    <p class="text-sm text-green-700 mt-1">
                        <strong>Simpan nomor pendaftaran Anda:</strong> {{ session('no_pendaftaran') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <div>
                    <h4 class="font-medium text-red-800">Terjadi kesalahan:</h4>
                    <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Page Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-6 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl mb-6 shadow-lg">
                <i class="fas fa-user-graduate text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Pendaftaran Peserta Didik Baru
            </h1>
            <p class="text-gray-600 text-lg">TK Ceria Bangsa - Tahun Ajaran 2026/2027</p>
            <div class="flex items-center justify-center mt-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mr-3">
                    <i class="fas fa-building mr-1"></i> SPMB Jabar
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-calendar-check mr-1"></i> 2026/2027
                </span>
            </div>
            <div class="w-32 h-1 bg-gradient-to-r from-blue-500 to-blue-700 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-start">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-bold text-gray-900">Periode Pendaftaran</h3>
                        <p class="text-gray-600 text-sm mt-1">Mei - Juni 2026</p>
                        <p class="text-xs text-gray-500 mt-1">Menunggu juknis Februari 2026</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                <div class="flex items-start">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-bold text-gray-900">Kuota Terbatas</h3>
                        <p class="text-gray-600 text-sm mt-1">30 siswa per kelas</p>
                        <p class="text-xs text-gray-500 mt-1">Berdasarkan daya tampung</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition">
                <div class="flex items-start">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-bold text-gray-900">Jalur Pendaftaran</h3>
                        <p class="text-gray-600 text-sm mt-1">4 Jalur SPMB</p>
                        <p class="text-xs text-gray-500 mt-1">Zonasi, Afirmasi, Prestasi, Mutasi</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition">
                <div class="flex items-start">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <i class="fas fa-file-alt text-orange-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-bold text-gray-900">Penyelenggara</h3>
                        <p class="text-gray-600 text-sm mt-1">Kemendikdasmen</p>
                        <p class="text-xs text-gray-500 mt-1">Provinsi Jawa Barat</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jalur Info Cards -->
        <div class="mb-10">
            <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Jalur Pendaftaran SPMB Jabar 2026/2027</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-blue-600 rounded-lg mr-3">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <h4 class="font-bold text-blue-800">Jalur Zonasi</h4>
                    </div>
                    <p class="text-sm text-gray-700">Berdasarkan domisili sesuai ketentuan zonasi sekolah</p>
                    <p class="text-xs text-gray-500 mt-2">Kuota minimal 50%</p>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-green-600 rounded-lg mr-3">
                            <i class="fas fa-hands-helping text-white"></i>
                        </div>
                        <h4 class="font-bold text-green-800">Jalur Afirmasi</h4>
                    </div>
                    <p class="text-sm text-gray-700">Untuk keluarga kurang mampu dengan bukti valid</p>
                    <p class="text-xs text-gray-500 mt-2">Kuota minimal 15%</p>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-purple-600 rounded-lg mr-3">
                            <i class="fas fa-trophy text-white"></i>
                        </div>
                        <h4 class="font-bold text-purple-800">Jalur Prestasi</h4>
                    </div>
                    <p class="text-sm text-gray-700">Berdasarkan prestasi akademik/non-akademik</p>
                    <p class="text-xs text-gray-500 mt-2">Kuota maksimal 30%</p>
                </div>
                
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-5">
                    <div class="flex items-center mb-3">
                        <div class="p-2 bg-orange-600 rounded-lg mr-3">
                            <i class="fas fa-exchange-alt text-white"></i>
                        </div>
                        <h4 class="font-bold text-orange-800">Jalur Mutasi</h4>
                    </div>
                    <p class="text-sm text-gray-700">Untuk orang tua siswa yang pindah tugas</p>
                    <p class="text-xs text-gray-500 mt-2">Kuota maksimal 5%</p>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Formulir Pendaftaran Online SPMB</h2>
                        <p class="text-blue-100 mt-1">Isi data dengan benar dan lengkap sesuai SPMB Jabar</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="px-4 py-2 bg-blue-500 bg-opacity-30 rounded-lg">
                            <p class="text-white text-sm">
                                <i class="fas fa-clock mr-2"></i>
                                Waktu pengisian: ±15 menit
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="px-8 pt-6">
                <div class="mb-2 flex justify-between">
                    <span class="text-sm font-medium text-gray-700">Langkah 1 dari 3</span>
                    <span class="text-sm font-medium text-blue-600">33%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 33%"></div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                <form action="{{ route('ppdb.store') }}" method="POST" class="space-y-8" id="ppdbForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- SECTION 1: Data Calon Siswa -->
                    <div class="border-b pb-8">
                        <div class="flex items-center mb-6">
                            <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="font-bold text-blue-600">1</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Data Calon Siswa</h3>
                                <p class="text-gray-600">Informasi pribadi calon peserta didik</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Nama Lengkap Calon Siswa
                                </label>
                                <input type="text" name="nama_calon_siswa" required 
                                       value="{{ old('nama_calon_siswa') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="Contoh: Andi Pratama">
                                <p class="text-xs text-gray-500 mt-1">Sesuai akta kelahiran</p>
                            </div>
                            
                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            
                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Tempat Lahir
                                </label>
                                <input type="text" name="tempat_lahir" required 
                                       value="{{ old('tempat_lahir') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="Contoh: Bandung">
                            </div>
                            
                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" required 
                                       id="tanggal_lahir_public"
                                       value="{{ old('tanggal_lahir') }}"
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                <div id="ageDisplayPublic" class="mt-2 text-sm">
                                    @if(old('tanggal_lahir'))
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                hitungUsiaDanSaranKelompokPublic('{{ old('tanggal_lahir') }}');
                                            });
                                        </script>
                                    @endif
                                </div>
                                <div id="kelompokSuggestionPublic" class="mt-1 text-sm hidden"></div>
                            </div>

                            <!-- Agama -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Agama
                                </label>
                                <select name="agama" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                            </div>

                            <!-- NIK (Untuk SPMB) -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    NIK Calon Siswa
                                </label>
                                <input type="text" name="nik" required 
                                       value="{{ old('nik') }}"
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="16 digit NIK">
                                <p class="text-xs text-gray-500 mt-1">Nomor Induk Kependudukan</p>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mt-6">
                            <label class="block text-gray-700 font-medium mb-2 required">
                                Alamat Lengkap
                            </label>
                            <textarea name="alamat" rows="3" required 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                      placeholder="Tulis alamat lengkap beserta RT/RW, Kelurahan, Kecamatan, dan Kode Pos">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Dokumen Upload -->
                        <div class="mt-6">
                            <label class="block text-gray-700 font-medium mb-2">
                                Upload Dokumen Pendukung
                            </label>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Akta Kelahiran (PDF/Image)</label>
                                    <input type="file" name="akta_kelahiran" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Kartu Keluarga (PDF/Image)</label>
                                    <input type="file" name="kartu_keluarga" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Maksimal 2MB per file. Format: PDF, JPG, PNG</p>
                        </div>
                    </div>

                    <!-- SECTION 2: Data Orang Tua -->
                    <div class="border-b pb-8">
                        <div class="flex items-center mb-6">
                            <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="font-bold text-green-600">2</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Data Orang Tua</h3>
                                <p class="text-gray-600">Informasi ayah dan ibu calon peserta didik</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Nama Ayah -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Nama Ayah
                                </label>
                                <input type="text" name="nama_ayah" required 
                                       value="{{ old('nama_ayah') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="Nama lengkap ayah">
                            </div>
                            
                            <!-- NIK Ayah -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    NIK Ayah
                                </label>
                                <input type="text" name="nik_ayah" required 
                                       value="{{ old('nik_ayah') }}"
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="16 digit NIK ayah">
                            </div>
                            
                            <!-- Pekerjaan Ayah -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Pekerjaan Ayah
                                </label>
                                <select name="pekerjaan_ayah" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Wiraswasta" {{ old('pekerjaan_ayah') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="PNS" {{ old('pekerjaan_ayah') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="TNI/Polri" {{ old('pekerjaan_ayah') == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan_ayah') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Petani" {{ old('pekerjaan_ayah') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Nelayan" {{ old('pekerjaan_ayah') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Buruh" {{ old('pekerjaan_ayah') == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                    <option value="Dokter" {{ old('pekerjaan_ayah') == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                                    <option value="Guru" {{ old('pekerjaan_ayah') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Lainnya" {{ old('pekerjaan_ayah') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            
                            <!-- Penghasilan Ayah -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Penghasilan Ayah (per bulan)
                                </label>
                                <select name="penghasilan_ayah" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< 1 juta" {{ old('penghasilan_ayah') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                    <option value="1-3 juta" {{ old('penghasilan_ayah') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                    <option value="3-5 juta" {{ old('penghasilan_ayah') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                    <option value="5-10 juta" {{ old('penghasilan_ayah') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                    <option value="> 10 juta" {{ old('penghasilan_ayah') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                                </select>
                            </div>

                            <!-- Nama Ibu -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Nama Ibu
                                </label>
                                <input type="text" name="nama_ibu" required 
                                       value="{{ old('nama_ibu') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="Nama lengkap ibu">
                            </div>
                            
                            <!-- NIK Ibu -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    NIK Ibu
                                </label>
                                <input type="text" name="nik_ibu" required 
                                       value="{{ old('nik_ibu') }}"
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                       placeholder="16 digit NIK ibu">
                            </div>
                            
                            <!-- Pekerjaan Ibu -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Pekerjaan Ibu
                                </label>
                                <select name="pekerjaan_ibu" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                    <option value="Wiraswasta" {{ old('pekerjaan_ibu') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="PNS" {{ old('pekerjaan_ibu') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan_ibu') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Guru" {{ old('pekerjaan_ibu') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                    <option value="Perawat" {{ old('pekerjaan_ibu') == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                                    <option value="Lainnya" {{ old('pekerjaan_ibu') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    No. HP/WhatsApp
                                </label>
                                <input type="tel" name="no_hp_ortu" required 
                                       pattern="[0-9]{10,15}"
                                       placeholder="081234567890"
                                       value="{{ old('no_hp_ortu') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                <p class="text-xs text-gray-500 mt-1">Pastikan nomor aktif untuk konfirmasi</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Email Orang Tua
                                </label>
                                <input type="email" name="email_ortu" 
                                       placeholder="orangtua@email.com"
                                       value="{{ old('email_ortu') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                <p class="text-xs text-gray-500 mt-1">Untuk pemberitahuan via email</p>
                            </div>
                        </div>

                        <!-- Data Wali (jika diperlukan) -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Data Wali (jika berbeda dengan orang tua)</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Nama Wali</label>
                                    <input type="text" name="nama_wali" 
                                           value="{{ old('nama_wali') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Hubungan dengan Calon Siswa</label>
                                    <select name="hubungan_wali" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="kakek" {{ old('hubungan_wali') == 'kakek' ? 'selected' : '' }}>Kakek</option>
                                        <option value="nenek" {{ old('hubungan_wali') == 'nenek' ? 'selected' : '' }}>Nenek</option>
                                        <option value="paman" {{ old('hubungan_wali') == 'paman' ? 'selected' : '' }}>Paman</option>
                                        <option value="bibi" {{ old('hubungan_wali') == 'bibi' ? 'selected' : '' }}>Bibi</option>
                                        <option value="lainnya" {{ old('hubungan_wali') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: Pilihan Program SPMB -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="font-bold text-purple-600">3</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Pilihan Program SPMB</h3>
                                <p class="text-gray-600">Pilih jalur pendaftaran sesuai ketentuan SPMB Jabar</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    Jalur Pendaftaran SPMB
                                </label>
                                <select name="jalur_pendaftaran" required 
                                        id="jalur_pendaftaran"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input">
                                    <option value="">Pilih Jalur SPMB</option>
                                    <option value="zonasi" {{ old('jalur_pendaftaran') == 'zonasi' ? 'selected' : '' }}>Zonasi (Berdasarkan Domisili)</option>
                                    <option value="afirmasi" {{ old('jalur_pendaftaran') == 'afirmasi' ? 'selected' : '' }}>Afirmasi (Keluarga Kurang Mampu)</option>
                                    <option value="prestasi" {{ old('jalur_pendaftaran') == 'prestasi' ? 'selected' : '' }}>Prestasi (Akademik/Non-Akademik)</option>
                                    <option value="mutasi" {{ old('jalur_pendaftaran') == 'mutasi' ? 'selected' : '' }}>Mutasi (Pindah Tugas Orang Tua)</option>
                                </select>
                                
                                <!-- Informasi Jalur -->
                                <div id="jalurInfo" class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                                    <div id="jalurContent"></div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">
                                    Catatan Khusus (Opsional)
                                </label>
                                <textarea name="catatan_khusus" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-input"
                                          placeholder="Contoh: Alergi makanan tertentu, kebutuhan khusus, atau informasi tambahan lainnya">{{ old('catatan_khusus') }}</textarea>
                            </div>
                        </div>

                        <!-- Dokumen Tambahan Berdasarkan Jalur -->
                        <div id="dokumenJalur" class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                            <h4 class="font-medium text-yellow-800 mb-3">Dokumen Tambahan yang Diperlukan:</h4>
                            <div id="dokumenContent"></div>
                        </div>

                        <!-- Prestasi (jika jalur prestasi) -->
                        <div id="prestasiSection" class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
                            <h4 class="font-medium text-green-800 mb-3">Data Prestasi</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Jenis Prestasi</label>
                                    <select name="jenis_prestasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Jenis Prestasi</option>
                                        <option value="akademik" {{ old('jenis_prestasi') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="seni" {{ old('jenis_prestasi') == 'seni' ? 'selected' : '' }}>Seni</option>
                                        <option value="olahraga" {{ old('jenis_prestasi') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                                        <option value="lainnya" {{ old('jenis_prestasi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Tingkat Prestasi</label>
                                    <select name="tingkat_prestasi" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Tingkat</option>
                                        <option value="sekolah" {{ old('tingkat_prestasi') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                                        <option value="kecamatan" {{ old('tingkat_prestasi') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="kota" {{ old('tingkat_prestasi') == 'kota' ? 'selected' : '' }}>Kota/Kabupaten</option>
                                        <option value="provinsi" {{ old('tingkat_prestasi') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="nasional" {{ old('tingkat_prestasi') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Upload Sertifikat Prestasi</label>
                                    <input type="file" name="sertifikat_prestasi" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Mutasi (jika jalur mutasi) -->
                        <div id="mutasiSection" class="mt-6 p-4 bg-orange-50 border border-orange-200 rounded-lg hidden">
                            <h4 class="font-medium text-orange-800 mb-3">Data Mutasi</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Nama Instansi Pemberi Tugas</label>
                                    <input type="text" name="instansi_mutasi" 
                                           value="{{ old('instansi_mutasi') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                           placeholder="Nama perusahaan/instansi">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Upload Surat Mutasi</label>
                                    <input type="file" name="surat_mutasi" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Afirmasi (jika jalur afirmasi) -->
                        <div id="afirmasiSection" class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg hidden">
                            <h4 class="font-medium text-red-800 mb-3">Data Afirmasi</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Jenis Bantuan yang Diterima</label>
                                    <select name="jenis_bantuan" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Jenis Bantuan</option>
                                        <option value="pkh" {{ old('jenis_bantuan') == 'pkh' ? 'selected' : '' }}>Program Keluarga Harapan (PKH)</option>
                                        <option value="kks" {{ old('jenis_bantuan') == 'kks' ? 'selected' : '' }}>Kartu Keluarga Sejahtera (KKS)</option>
                                        <option value="kip" {{ old('jenis_bantuan') == 'kip' ? 'selected' : '' }}>Kartu Indonesia Pintar (KIP)</option>
                                        <option value="bsm" {{ old('jenis_bantuan') == 'bsm' ? 'selected' : '' }}>Bantuan Siswa Miskin (BSM)</option>
                                        <option value="lainnya" {{ old('jenis_bantuan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Upload Bukti Bantuan</label>
                                    <input type="file" name="bukti_bantuan" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden field untuk status (selalu menunggu untuk publik) -->
                    <input type="hidden" name="status" value="menunggu">
                    <input type="hidden" name="tahun_ajaran" value="2026/2027">

                    <!-- Form Footer -->
                    <div class="bg-gray-50 rounded-xl p-6 mt-8">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-shield-alt text-green-600 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-bold text-gray-900">Keamanan Data</h4>
                                <p class="text-sm text-gray-600">Data Anda dilindungi UU No. 19 Tahun 2016 dan hanya digunakan untuk keperluan pendaftaran SPMB</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <input type="checkbox" id="agreeTerms" required 
                                   class="mt-1 mr-3 h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                            <label for="agreeTerms" class="text-sm text-gray-700">
                                Saya menyatakan bahwa data yang saya berikan adalah benar dan sah. 
                                Saya setuju dengan 
                                <a href="#" class="text-blue-600 hover:underline">syarat dan ketentuan SPMB Jabar 2026/2027</a> 
                                yang berlaku.
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center shadow-lg">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Kirim Pendaftaran SPMB
                        </button>
                        
                        <button type="button" id="resetButton"
                                class="flex-1 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-redo mr-3"></i>
                            Reset Form
                        </button>
                    </div>
                    
                    <div class="text-center mt-6">
                        <p class="text-gray-600 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Pendaftaran akan diproses sesuai jadwal SPMB Jabar 2026/2027. Status dapat dicek via WhatsApp atau portal SPMB.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- WhatsApp Help -->
        <div class="mt-8 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center">
                            <i class="fab fa-whatsapp text-white text-3xl mr-4"></i>
                            <div>
                                <h3 class="text-xl font-bold text-white">Butuh Bantuan?</h3>
                                <p class="text-green-100">Tim SPMB siap membantu via WhatsApp</p>
                            </div>
                        </div>
                    </div>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20TK%20Ceria%20Bangsa,%20saya%20ingin%20bertanya%20tentang%20SPMB%202026/2027" 
                       target="_blank"
                       class="bg-white text-green-600 hover:bg-green-50 font-bold py-3 px-6 rounded-lg transition duration-300 flex items-center">
                        <i class="fab fa-whatsapp mr-3 text-xl"></i>
                        Chat Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- SPMB Info Footer -->
        <div class="mt-8 bg-gray-800 rounded-xl p-6 text-white">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h4 class="font-bold text-lg mb-2">SPMB Jabar 2026/2027</h4>
                    <p class="text-gray-300 text-sm">Sistem Penerimaan Peserta Didik Baru Jawa Barat</p>
                    <p class="text-gray-400 text-xs mt-2">Diselenggarakan oleh Kemendikdasmen Provinsi Jawa Barat</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="#" class="text-blue-300 hover:text-white text-sm flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Download Juknis SPMB 2026
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/ppdb-public.js') }}"></script>
<script>
// Fungsi khusus untuk SPMB
document.addEventListener('DOMContentLoaded', function() {
    // Jalur pendaftaran change handler
    const jalurSelect = document.getElementById('jalur_pendaftaran');
    const jalurInfo = document.getElementById('jalurInfo');
    const dokumenJalur = document.getElementById('dokumenJalur');
    const prestasiSection = document.getElementById('prestasiSection');
    const mutasiSection = document.getElementById('mutasiSection');
    const afirmasiSection = document.getElementById('afirmasiSection');
    
    jalurSelect.addEventListener('change', function() {
        const value = this.value;
        const dokumenContent = document.getElementById('dokumenContent');
        const jalurContent = document.getElementById('jalurContent');
        
        // Reset semua section
        prestasiSection.classList.add('hidden');
        mutasiSection.classList.add('hidden');
        afirmasiSection.classList.add('hidden');
        
        if (value) {
            jalurInfo.classList.remove('hidden');
            dokumenJalur.classList.remove('hidden');
            
            // Set info berdasarkan jalur
            let info = '';
            let dokumen = '';
            
            switch(value) {
                case 'zonasi':
                    info = `
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                            <div>
                                <h5 class="font-bold text-blue-800">Jalur Zonasi</h5>
                                <p class="text-sm text-gray-700">Berdasarkan domisili sesuai zona sekolah. Kuota minimal 50%.</p>
                            </div>
                        </div>
                    `;
                    dokumen = `
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Kartu Keluarga (KK)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Akta Kelahiran</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Surat Keterangan Domisili</li>
                        </ul>
                    `;
                    break;
                    
                case 'afirmasi':
                    info = `
                        <div class="flex items-center">
                            <i class="fas fa-hands-helping text-red-600 mr-3"></i>
                            <div>
                                <h5 class="font-bold text-red-800">Jalur Afirmasi</h5>
                                <p class="text-sm text-gray-700">Untuk keluarga kurang mampu dengan bukti valid. Kuota minimal 15%.</p>
                            </div>
                        </div>
                    `;
                    dokumen = `
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Kartu Keluarga (KK)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Akta Kelahiran</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Kartu Bantuan Sosial (KPS/KKS/KIP)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Surat Keterangan Tidak Mampu dari Kelurahan</li>
                        </ul>
                    `;
                    afirmasiSection.classList.remove('hidden');
                    break;
                    
                case 'prestasi':
                    info = `
                        <div class="flex items-center">
                            <i class="fas fa-trophy text-green-600 mr-3"></i>
                            <div>
                                <h5 class="font-bold text-green-800">Jalur Prestasi</h5>
                                <p class="text-sm text-gray-700">Berdasarkan prestasi akademik/non-akademik. Kuota maksimal 30%.</p>
                            </div>
                        </div>
                    `;
                    dokumen = `
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Kartu Keluarga (KK)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Akta Kelahiran</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Sertifikat Prestasi (legalisir)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Raport/SKHUN</li>
                        </ul>
                    `;
                    prestasiSection.classList.remove('hidden');
                    break;
                    
                case 'mutasi':
                    info = `
                        <div class="flex items-center">
                            <i class="fas fa-exchange-alt text-orange-600 mr-3"></i>
                            <div>
                                <h5 class="font-bold text-orange-800">Jalur Mutasi</h5>
                                <p class="text-sm text-gray-700">Untuk orang tua siswa yang pindah tugas. Kuota maksimal 5%.</p>
                            </div>
                        </div>
                    `;
                    dokumen = `
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Kartu Keluarga (KK)</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Akta Kelahiran</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Surat Mutasi Kerja Orang Tua</li>
                            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Surat Keterangan Domisili Baru</li>
                        </ul>
                    `;
                    mutasiSection.classList.remove('hidden');
                    break;
            }
            
            jalurContent.innerHTML = info;
            dokumenContent.innerHTML = dokumen;
        } else {
            jalurInfo.classList.add('hidden');
            dokumenJalur.classList.add('hidden');
        }
    });
    
    // Reset button
    document.getElementById('resetButton').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan semua data yang telah diisi?')) {
            document.getElementById('ppdbForm').reset();
            jalurInfo.classList.add('hidden');
            dokumenJalur.classList.add('hidden');
            prestasiSection.classList.add('hidden');
            mutasiSection.classList.add('hidden');
            afirmasiSection.classList.add('hidden');
            
            // Reset tampilan usia
            const ageDisplay = document.getElementById('ageDisplayPublic');
            if (ageDisplay) ageDisplay.textContent = '';
            
            alert('Form telah direset. Silakan isi kembali.');
        }
    });
    
    // Validasi NIK
    const nikInputs = document.querySelectorAll('input[name="nik"], input[name="nik_ayah"], input[name="nik_ibu"]');
    nikInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.value.length !== 16 && this.value.length > 0) {
                alert('NIK harus 16 digit angka');
                this.focus();
            }
        });
    });
    
    // File size validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileSize = this.files[0].size / 1024 / 1024; // in MB
                const maxSize = 2; // 2MB
                
                if (fileSize > maxSize) {
                    alert(`Ukuran file terlalu besar. Maksimal ${maxSize}MB`);
                    this.value = '';
                }
                
                // Validate file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(this.files[0].type)) {
                    alert('Format file tidak didukung. Gunakan PDF, JPG, atau PNG');
                    this.value = '';
                }
            }
        });
    });
    
    // Trigger jalur change jika sudah ada value dari old input
    if (jalurSelect.value) {
        jalurSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

@push('styles')
<style>
.required::after {
    content: " *";
    color: #ef4444;
}
</style>
@endpush