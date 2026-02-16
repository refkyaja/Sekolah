{{-- resources/views/admin/spmb/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Pendaftaran SPMB Baru')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Pendaftaran SPMB Baru
                </h1>
                <p class="text-gray-600 mt-2">Tambah data pendaftaran SPMB secara manual</p>
            </div>
            <a href="{{ route('admin.spmb.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Formulir Pendaftaran SPMB</h3>
            <p class="text-sm text-gray-600">Isi data calon siswa dan orang tua untuk SPMB</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.spmb.store') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
                @csrf

                <!-- Data Calon Siswa -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-child text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Calon Siswa</h4>
                            <p class="text-sm text-gray-600">Informasi pribadi calon siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Calon Siswa -->
                        <div>
                            <label for="nama_calon_siswa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Calon Siswa *
                            </label>
                            <input type="text" 
                                   id="nama_calon_siswa"
                                   name="nama_calon_siswa" 
                                   value="{{ old('nama_calon_siswa') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_calon_siswa') border-red-500 @enderror"
                                   placeholder="Nama sesuai akta kelahiran">
                            @error('nama_calon_siswa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Calon Siswa *
                            </label>
                            <input type="text" 
                                   id="nik"
                                   name="nik" 
                                   value="{{ old('nik') }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror"
                                   placeholder="16 digit NIK">
                            <p class="text-xs text-gray-500 mt-1">Nomor Induk Kependudukan</p>
                            @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin *
                            </label>
                            <select id="jenis_kelamin" 
                                    name="jenis_kelamin" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir *
                            </label>
                            <input type="text" 
                                   id="tempat_lahir"
                                   name="tempat_lahir" 
                                   value="{{ old('tempat_lahir') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tempat_lahir') border-red-500 @enderror"
                                   placeholder="Kota/kabupaten">
                            @error('tempat_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir *
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir"
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir') }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_lahir') border-red-500 @enderror">
                            <div id="ageDisplay" class="mt-1 text-sm text-gray-600"></div>
                            <div id="kelompokSuggestion" class="mt-1 text-sm hidden"></div>
                            @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                Agama *
                            </label>
                            <select id="agama" 
                                    name="agama" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('agama') border-red-500 @enderror">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelompok (untuk TK/PAUD) -->
                        <div>
                            <label for="pilihan_kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelompok (untuk TK/PAUD)
                            </label>
                            <select id="pilihan_kelompok" 
                                    name="pilihan_kelompok" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pilihan_kelompok') border-red-500 @enderror">
                                <option value="">Pilih Kelompok</option>
                                <option value="A" {{ old('pilihan_kelompok') == 'A' ? 'selected' : '' }}>Kelompok A (3-4 tahun)</option>
                                <option value="B" {{ old('pilihan_kelompok') == 'B' ? 'selected' : '' }}>Kelompok B (5-6 tahun)</option>
                            </select>
                            <div id="kelompokInfo" class="mt-1 text-sm text-gray-500">
                                Kelompok akan disesuaikan berdasarkan usia (hanya untuk TK/PAUD)
                            </div>
                            @error('pilihan_kelompok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Asal Sekolah (untuk SD/SMP/SMA) -->
                        <div>
                            <label for="asal_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                                Asal Sekolah (untuk SD/SMP/SMA)
                            </label>
                            <input type="text" 
                                   id="asal_sekolah"
                                   name="asal_sekolah" 
                                   value="{{ old('asal_sekolah') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nama sekolah asal">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap *
                        </label>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="3"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror"
                                  placeholder="Alamat lengkap beserta RT/RW, Kelurahan, Kecamatan">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenjang Pendidikan -->
                    <div>
                        <label for="jenjang_pendidikan" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenjang Pendidikan *
                        </label>
                        <select id="jenjang_pendidikan" 
                                name="jenjang_pendidikan" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenjang_pendidikan') border-red-500 @enderror">
                            <option value="">Pilih Jenjang Pendidikan</option>
                            <option value="TK" {{ old('jenjang_pendidikan') == 'TK' ? 'selected' : '' }}>TK/PAUD</option>
                            <option value="SD" {{ old('jenjang_pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('jenjang_pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('jenjang_pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        </select>
                        @error('jenjang_pendidikan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Orang Tua</h4>
                            <p class="text-sm text-gray-600">Informasi ayah dan ibu calon siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ayah -->
                        <div>
                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ayah *
                            </label>
                            <input type="text" 
                                   id="nama_ayah"
                                   name="nama_ayah" 
                                   value="{{ old('nama_ayah') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_ayah') border-red-500 @enderror">
                            @error('nama_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK Ayah -->
                        <div>
                            <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Ayah *
                            </label>
                            <input type="text" 
                                   id="nik_ayah"
                                   name="nik_ayah" 
                                   value="{{ old('nik_ayah') }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_ayah') border-red-500 @enderror">
                            @error('nik_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan Ayah -->
                        <div>
                            <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Ayah
                            </label>
                            <select id="pekerjaan_ayah" 
                                    name="pekerjaan_ayah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pekerjaan_ayah') border-red-500 @enderror">
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
                            @error('pekerjaan_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penghasilan Ayah -->
                        <div>
                            <label for="penghasilan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan Ayah (per bulan)
                            </label>
                            <select id="penghasilan_ayah" 
                                    name="penghasilan_ayah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ibu *
                            </label>
                            <input type="text" 
                                   id="nama_ibu"
                                   name="nama_ibu" 
                                   value="{{ old('nama_ibu') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_ibu') border-red-500 @enderror">
                            @error('nama_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK Ibu -->
                        <div>
                            <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Ibu *
                            </label>
                            <input type="text" 
                                   id="nik_ibu"
                                   name="nik_ibu" 
                                   value="{{ old('nik_ibu') }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_ibu') border-red-500 @enderror">
                            @error('nik_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pekerjaan Ibu -->
                        <div>
                            <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Ibu
                            </label>
                            <select id="pekerjaan_ibu" 
                                    name="pekerjaan_ibu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pekerjaan_ibu') border-red-500 @enderror">
                                <option value="">Pilih Pekerjaan</option>
                                <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                <option value="Wiraswasta" {{ old('pekerjaan_ibu') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="PNS" {{ old('pekerjaan_ibu') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="Karyawan Swasta" {{ old('pekerjaan_ibu') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                <option value="Guru" {{ old('pekerjaan_ibu') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Perawat" {{ old('pekerjaan_ibu') == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                                <option value="Lainnya" {{ old('pekerjaan_ibu') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('pekerjaan_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP Orang Tua -->
                        <div>
                            <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP/WhatsApp Orang Tua *
                            </label>
                            <input type="tel" 
                                   id="no_hp_ortu"
                                   name="no_hp_ortu" 
                                   value="{{ old('no_hp_ortu') }}"
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_hp_ortu') border-red-500 @enderror">
                            @error('no_hp_ortu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Orang Tua -->
                        <div>
                            <label for="email_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Orang Tua
                            </label>
                            <input type="email" 
                                   id="email_ortu"
                                   name="email_ortu" 
                                   value="{{ old('email_ortu') }}"
                                   placeholder="orangtua@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email_ortu') border-red-500 @enderror">
                            @error('email_ortu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Jalur Pendaftaran -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Jalur Pendaftaran</h4>
                            <p class="text-sm text-gray-600">Pilih jalur sesuai SPMB Jabar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jalur Pendaftaran -->
                        <div>
                            <label for="jalur_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Jalur Pendaftaran *
                            </label>
                            <select id="jalur_pendaftaran" 
                                    name="jalur_pendaftaran" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jalur_pendaftaran') border-red-500 @enderror">
                                <option value="">Pilih Jalur SPMB</option>
                                <option value="zonasi" {{ old('jalur_pendaftaran') == 'zonasi' ? 'selected' : '' }}>Zonasi (Berdasarkan Domisili)</option>
                                <option value="afirmasi" {{ old('jalur_pendaftaran') == 'afirmasi' ? 'selected' : '' }}>Afirmasi (Keluarga Kurang Mampu)</option>
                                <option value="prestasi" {{ old('jalur_pendaftaran') == 'prestasi' ? 'selected' : '' }}>Prestasi (Akademik/Non-Akademik)</option>
                                <option value="mutasi" {{ old('jalur_pendaftaran') == 'mutasi' ? 'selected' : '' }}>Mutasi (Pindah Tugas Orang Tua)</option>
                                <option value="reguler" {{ old('jalur_pendaftaran') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                            </select>
                            @error('jalur_pendaftaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Pendaftaran -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Pendaftaran *
                            </label>
                            <select id="status" 
                                    name="status" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Status akan menentukan proses selanjutnya</p>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Jalur (akan muncul berdasarkan pilihan) -->
                    <div id="dataJalurContainer">
                        <!-- Data akan ditampilkan berdasarkan pilihan jalur -->
                    </div>

                    <!-- Catatan Khusus -->
                    <div>
                        <label for="catatan_khusus" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Khusus (Opsional)
                        </label>
                        <textarea id="catatan_khusus" 
                                  name="catatan_khusus" 
                                  rows="2"
                                  placeholder="Catatan khusus dari orang tua"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('catatan_khusus') border-red-500 @enderror">{{ old('catatan_khusus') }}</textarea>
                        @error('catatan_khusus')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-upload text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Dokumen Pendukung</h4>
                            <p class="text-sm text-gray-600">Upload dokumen yang diperlukan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Akta Kelahiran -->
                        <div>
                            <label for="akta_kelahiran" class="block text-sm font-medium text-gray-700 mb-2">
                                Akta Kelahiran *
                            </label>
                            <input type="file" 
                                   id="akta_kelahiran"
                                   name="akta_kelahiran" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('akta_kelahiran') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 2MB)</p>
                            @error('akta_kelahiran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kartu Keluarga -->
                        <div>
                            <label for="kartu_keluarga" class="block text-sm font-medium text-gray-700 mb-2">
                                Kartu Keluarga *
                            </label>
                            <input type="file" 
                                   id="kartu_keluarga"
                                   name="kartu_keluarga" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kartu_keluarga') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 2MB)</p>
                            @error('kartu_keluarga')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dokumen Tambahan Berdasarkan Jalur -->
                    <div id="dokumenJalurContainer">
                        <!-- Dokumen tambahan akan ditampilkan berdasarkan pilihan jalur -->
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Data Pendaftaran SPMB
                        </button>
                        
                        <a href="{{ route('admin.spmb.index') }}" 
                           class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-4 px-6 rounded-lg text-center transition duration-300">
                            Batal
                        </a>
                    </div>
                    
                    <div id="autoConvertWarning" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-yellow-800">Perhatian!</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Jika status dipilih "Diterima", data akan <strong>otomatis dikonversi menjadi data siswa</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menghitung usia dan menyarankan kelompok
    function hitungUsiaDanSaranKelompok(tanggalLahir) {
        const birthDate = new Date(tanggalLahir);
        const today = new Date();
        
        // Validasi: tanggal tidak boleh lebih dari hari ini
        if (birthDate > today) {
            alert('Tanggal lahir tidak boleh lebih dari hari ini');
            document.getElementById('tanggal_lahir').value = '';
            document.getElementById('ageDisplay').textContent = '';
            document.getElementById('kelompokSuggestion').classList.add('hidden');
            document.getElementById('pilihan_kelompok').value = '';
            return;
        }
        
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        const ageDisplay = document.getElementById('ageDisplay');
        const kelompokSuggestion = document.getElementById('kelompokSuggestion');
        const pilihanKelompok = document.getElementById('pilihan_kelompok');
        const kelompokInfo = document.getElementById('kelompokInfo');
        
        if (age > 0) {
            // Tampilkan usia
            ageDisplay.textContent = `Usia: ${age} tahun`;
            
            // Tentukan saran kelompok berdasarkan usia
            let saranKelompok = '';
            let kelas = '';
            
            if (age < 3) {
                ageDisplay.className = 'mt-1 text-sm text-red-600 font-medium';
                saranKelompok = 'Usia terlalu muda untuk TK (minimal 3 tahun)';
                kelas = 'text-red-600';
                pilihanKelompok.value = '';
            } else if (age <= 4) {
                ageDisplay.className = 'mt-1 text-sm text-green-600 font-medium';
                saranKelompok = 'Saran: Kelompok A';
                kelas = 'text-green-600';
                // Auto select kelompok A jika usia sesuai
                if (pilihanKelompok.value === '' || pilihanKelompok.value === 'B') {
                    pilihanKelompok.value = 'A';
                }
            } else if (age <= 6) {
                ageDisplay.className = 'mt-1 text-sm text-blue-600 font-medium';
                saranKelompok = 'Saran: Kelompok B';
                kelas = 'text-blue-600';
                // Auto select kelompok B jika usia sesuai
                if (pilihanKelompok.value === '' || pilihanKelompok.value === 'A') {
                    pilihanKelompok.value = 'B';
                }
            } else {
                ageDisplay.className = 'mt-1 text-sm text-orange-600 font-medium';
                saranKelompok = 'Usia melebihi batas TK (maksimal 6 tahun)';
                kelas = 'text-orange-600';
                pilihanKelompok.value = '';
            }
            
            // Tampilkan saran kelompok
            if (saranKelompok) {
                kelompokSuggestion.innerHTML = `<span class="${kelas}">${saranKelompok}</span>`;
                kelompokSuggestion.classList.remove('hidden');
            }
            
            // Update info kelompok
            if (age >= 3 && age <= 6) {
                kelompokInfo.textContent = `Berdasarkan usia ${age} tahun, disarankan ${age <= 4 ? 'Kelompok A' : 'Kelompok B'}`;
                kelompokInfo.className = 'mt-1 text-sm text-green-600';
            } else {
                kelompokInfo.textContent = 'Hanya untuk TK/PAUD';
                kelompokInfo.className = 'mt-1 text-sm text-gray-500';
            }
            
            // Peringatan jika usia tidak sesuai untuk TK
            if (age < 3 || age > 6) {
                ageDisplay.innerHTML += ' <span class="text-red-500">(Di luar rentang usia TK: 3-6 tahun)</span>';
            } else if (age >= 3 && age <= 4) {
                ageDisplay.innerHTML += ' <span class="text-green-500">(Usia cocok untuk Kelompok A)</span>';
            } else if (age >= 5 && age <= 6) {
                ageDisplay.innerHTML += ' <span class="text-blue-500">(Usia cocok untuk Kelompok B)</span>';
            }
        } else {
            ageDisplay.textContent = '';
            kelompokSuggestion.classList.add('hidden');
            kelompokInfo.textContent = 'Hanya untuk TK/PAUD';
            kelompokInfo.className = 'mt-1 text-sm text-gray-500';
        }
    }
    
    // Event listener untuk tanggal lahir
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        hitungUsiaDanSaranKelompok(this.value);
    });
    
    // Event listener untuk jalur pendaftaran
    document.getElementById('jalur_pendaftaran').addEventListener('change', function() {
        const jalur = this.value;
        const dataJalurContainer = document.getElementById('dataJalurContainer');
        const dokumenJalurContainer = document.getElementById('dokumenJalurContainer');
        
        // Reset containers
        dataJalurContainer.innerHTML = '';
        dokumenJalurContainer.innerHTML = '';
        
        switch(jalur) {
            case 'prestasi':
                dataJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis_prestasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Prestasi *
                            </label>
                            <select id="jenis_prestasi" 
                                    name="jenis_prestasi" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis Prestasi</option>
                                <option value="akademik">Akademik</option>
                                <option value="seni">Seni</option>
                                <option value="olahraga">Olahraga</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="tingkat_prestasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Tingkat Prestasi *
                            </label>
                            <select id="tingkat_prestasi" 
                                    name="tingkat_prestasi" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Tingkat</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="kota">Kota/Kabupaten</option>
                                <option value="provinsi">Provinsi</option>
                                <option value="nasional">Nasional</option>
                            </select>
                        </div>
                    </div>
                `;
                
                dokumenJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sertifikat_prestasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Sertifikat Prestasi *
                            </label>
                            <input type="file" 
                                   id="sertifikat_prestasi"
                                   name="sertifikat_prestasi" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Upload sertifikat prestasi</p>
                        </div>
                    </div>
                `;
                break;
                
            case 'afirmasi':
                dataJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jenis_bantuan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Bantuan yang Diterima *
                            </label>
                            <select id="jenis_bantuan" 
                                    name="jenis_bantuan" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis Bantuan</option>
                                <option value="kks">Kartu Keluarga Sejahtera (KKS)</option>
                                <option value="kip">Kartu Indonesia Pintar (KIP)</option>
                                <option value="pkh">Program Keluarga Harapan (PKH)</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="no_kartu_bantuan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Kartu Bantuan
                            </label>
                            <input type="text" 
                                   id="no_kartu_bantuan"
                                   name="no_kartu_bantuan" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nomor kartu bantuan">
                        </div>
                    </div>
                `;
                
                dokumenJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kartu_bantuan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kartu Bantuan *
                            </label>
                            <input type="file" 
                                   id="kartu_bantuan"
                                   name="kartu_bantuan" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Foto/dokumen kartu bantuan</p>
                        </div>
                    </div>
                `;
                break;
                
            case 'zonasi':
                dataJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="jarak_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Jarak Rumah ke Sekolah *
                            </label>
                            <input type="text" 
                                   id="jarak_rumah"
                                   name="jarak_rumah" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 2.5 km">
                        </div>
                        <div>
                            <label for="waktu_tempuh" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Tempuh ke Sekolah *
                            </label>
                            <input type="text" 
                                   id="waktu_tempuh"
                                   name="waktu_tempuh" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 15 menit">
                        </div>
                    </div>
                `;
                
                dokumenJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="surat_domisili" class="block text-sm font-medium text-gray-700 mb-2">
                                Surat Domisili *
                            </label>
                            <input type="file" 
                                   id="surat_domisili"
                                   name="surat_domisili" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Surat keterangan domisili dari RT/RW</p>
                        </div>
                    </div>
                `;
                break;
                
            case 'mutasi':
                dataJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="alasan_mutasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Mutasi *
                            </label>
                            <select id="alasan_mutasi" 
                                    name="alasan_mutasi" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Alasan Mutasi</option>
                                <option value="pindah_tugas">Pindah Tugas Orang Tua</option>
                                <option value="pindah_rumah">Pindah Rumah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="instansi_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                Instansi Orang Tua
                            </label>
                            <input type="text" 
                                   id="instansi_ortu"
                                   name="instansi_ortu" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nama instansi tempat bekerja">
                        </div>
                    </div>
                `;
                
                dokumenJalurContainer.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="surat_mutasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Surat Mutasi *
                            </label>
                            <input type="file" 
                                   id="surat_mutasi"
                                   name="surat_mutasi" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Surat mutasi dari instansi/surat pindah</p>
                        </div>
                    </div>
                `;
                break;
        }
    });
    
    // Validasi NIK
    function validasiNIK(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 16) {
            input.value = input.value.substring(0, 16);
        }
    }
    
    // Event listener untuk semua field NIK
    document.getElementById('nik').addEventListener('input', function() {
        validasiNIK(this);
    });
    
    document.getElementById('nik_ayah').addEventListener('input', function() {
        validasiNIK(this);
    });
    
    document.getElementById('nik_ibu').addEventListener('input', function() {
        validasiNIK(this);
    });
    
    // Validasi nomor telepon
    document.getElementById('no_hp_ortu').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Tampilkan peringatan jika status dipilih "diterima"
    document.getElementById('status').addEventListener('change', function() {
        const warningDiv = document.getElementById('autoConvertWarning');
        if (this.value === 'diterima') {
            warningDiv.classList.remove('hidden');
        } else {
            warningDiv.classList.add('hidden');
        }
    });
    
    // Tampilkan/atur kelompok berdasarkan jenjang pendidikan
    document.getElementById('jenjang_pendidikan').addEventListener('change', function() {
        const jenjang = this.value;
        const kelompokField = document.getElementById('pilihan_kelompok').closest('div');
        const kelompokInfo = document.getElementById('kelompokInfo');
        const asalSekolahField = document.getElementById('asal_sekolah').closest('div');
        
        if (jenjang === 'TK') {
            kelompokField.classList.remove('hidden');
            kelompokInfo.textContent = 'Kelompok akan disesuaikan berdasarkan usia';
            kelompokInfo.className = 'mt-1 text-sm text-gray-500';
            asalSekolahField.classList.add('hidden');
        } else {
            kelompokField.classList.add('hidden');
            kelompokInfo.textContent = 'Hanya untuk TK/PAUD';
            kelompokInfo.className = 'mt-1 text-sm text-gray-500';
            asalSekolahField.classList.remove('hidden');
        }
    });
    
    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Cek status
        const statusSelect = document.getElementById('status');
        if (statusSelect && statusSelect.value === 'diterima') {
            document.getElementById('autoConvertWarning').classList.remove('hidden');
        }
        
        // Hitung usia jika tanggal lahir sudah diisi dari old input
        const birthDateInput = document.getElementById('tanggal_lahir');
        if (birthDateInput.value) {
            hitungUsiaDanSaranKelompok(birthDateInput.value);
        }
        
        // Set max date untuk tanggal lahir
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_lahir').max = today;
        
        // Inisialisasi berdasarkan jenjang pendidikan
        const jenjangSelect = document.getElementById('jenjang_pendidikan');
        if (jenjangSelect.value) {
            jenjangSelect.dispatchEvent(new Event('change'));
        }
        
        // Inisialisasi berdasarkan jalur pendaftaran
        const jalurSelect = document.getElementById('jalur_pendaftaran');
        if (jalurSelect.value) {
            jalurSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush