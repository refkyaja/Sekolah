{{-- resources/views/admin/siswa/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Siswa Baru
                </h1>
                <p class="text-gray-600 mt-2">Tambah data siswa secara manual</p>
            </div>
            <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Formulir Data Siswa</h3>
            <p class="text-sm text-gray-600">Isi data siswa dan orang tua lengkap</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.siswa.siswa-aktif.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Data Siswa -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-child text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Siswa</h4>
                            <p class="text-sm text-gray-600">Informasi pribadi siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- NIK -->
                        <div class="md:col-span-1">
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nik"
                                   name="nik" 
                                   value="{{ old('nik') }}"
                                   required
                                   maxlength="16"
                                   placeholder="16 digit NIK"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror">
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIS -->
                        <div class="md:col-span-1">
                            <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                                NIS (Nomor Induk Siswa)
                            </label>
                            <input type="text" 
                                   id="nis"
                                   name="nis" 
                                   value="{{ old('nis') }}"
                                   placeholder="Contoh: NIS-2026-0001"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nis') border-red-500 @enderror">
                            @error('nis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NISN -->
                        <div class="md:col-span-1">
                            <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                                NISN (Nomor Induk Siswa Nasional)
                            </label>
                            <input type="text" 
                                   id="nisn"
                                   name="nisn" 
                                   value="{{ old('nisn') }}"
                                   placeholder="10 digit NISN"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nisn') border-red-500 @enderror">
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_lengkap"
                                   name="nama_lengkap" 
                                   value="{{ old('nama_lengkap') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                   placeholder="Nama lengkap sesuai akta">
                            @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Panggilan -->
                        <div>
                            <label for="nama_panggilan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Panggilan
                            </label>
                            <input type="text" 
                                   id="nama_panggilan"
                                   name="nama_panggilan" 
                                   value="{{ old('nama_panggilan') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nama panggilan sehari-hari">
                            @error('nama_panggilan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="tempat_lahir"
                                   name="tempat_lahir" 
                                   value="{{ old('tempat_lahir') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir"
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir') }}"
                                   max="{{ date('Y-m-d') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div id="ageDisplay" class="mt-1 text-sm text-gray-600"></div>
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis_kelamin" 
                                    name="jenis_kelamin" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                Agama
                            </label>
                            <select id="agama" 
                                    name="agama" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Provinsi -->
                            <div>
                                <label for="provinsi" class="block text-xs font-medium text-gray-500 mb-1">
                                    Provinsi
                                </label>
                                <input type="text" 
                                       id="provinsi"
                                       name="provinsi" 
                                       value="{{ old('provinsi') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Jawa Barat">
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div>
                                <label for="kota_kabupaten" class="block text-xs font-medium text-gray-500 mb-1">
                                    Kota/Kabupaten
                                </label>
                                <input type="text" 
                                       id="kota_kabupaten"
                                       name="kota_kabupaten" 
                                       value="{{ old('kota_kabupaten') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Kota Bandung">
                            </div>

                            <!-- Kecamatan -->
                            <div>
                                <label for="kecamatan" class="block text-xs font-medium text-gray-500 mb-1">
                                    Kecamatan
                                </label>
                                <input type="text" 
                                       id="kecamatan"
                                       name="kecamatan" 
                                       value="{{ old('kecamatan') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Kiaracondong">
                            </div>

                            <!-- Kelurahan -->
                            <div>
                                <label for="kelurahan" class="block text-xs font-medium text-gray-500 mb-1">
                                    Kelurahan/Desa
                                </label>
                                <input type="text" 
                                       id="kelurahan"
                                       name="kelurahan" 
                                       value="{{ old('kelurahan') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Sukapura">
                            </div>
                        </div>

                        <!-- Nama Jalan -->
                        <div class="mb-4">
                            <label for="nama_jalan" class="block text-xs font-medium text-gray-500 mb-1">
                                Nama Jalan, RT/RW
                            </label>
                            <input type="text" 
                                   id="nama_jalan"
                                   name="nama_jalan" 
                                   value="{{ old('nama_jalan') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Jl. Terusan PSM No. 1A, RT 01 RW 02">
                        </div>

                        <!-- Alamat Lengkap (satu baris) -->
                        <div>
                            <label for="alamat" class="block text-xs font-medium text-gray-500 mb-1">
                                Alamat Lengkap (satu baris) <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat" 
                                      name="alamat" 
                                      rows="2"
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Jl. Terusan PSM No. 1A, RT 01 RW 02, Kel. Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Kesehatan -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h5 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                            Data Kesehatan (Opsional)
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="berat_badan" class="block text-xs font-medium text-gray-500 mb-1">
                                    Berat Badan (kg)
                                </label>
                                <input type="number" 
                                       id="berat_badan"
                                       name="berat_badan" 
                                       value="{{ old('berat_badan') }}"
                                       step="0.1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="15.5">
                            </div>

                            <div>
                                <label for="tinggi_badan" class="block text-xs font-medium text-gray-500 mb-1">
                                    Tinggi Badan (cm)
                                </label>
                                <input type="number" 
                                       id="tinggi_badan"
                                       name="tinggi_badan" 
                                       value="{{ old('tinggi_badan') }}"
                                       step="0.1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="95.5">
                            </div>

                            <div>
                                <label for="golongan_darah" class="block text-xs font-medium text-gray-500 mb-1">
                                    Golongan Darah
                                </label>
                                <select id="golongan_darah" 
                                        name="golongan_darah" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="penyakit_pernah_diderita" class="block text-xs font-medium text-gray-500 mb-1">
                                    Penyakit yang Pernah Diderita
                                </label>
                                <textarea id="penyakit_pernah_diderita" 
                                          name="penyakit_pernah_diderita" 
                                          rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Contoh: Demam berdarah, cacar, asma">{{ old('penyakit_pernah_diderita') }}</textarea>
                            </div>

                            <div>
                                <label for="imunisasi" class="block text-xs font-medium text-gray-500 mb-1">
                                    Imunisasi yang Sudah Diterima
                                </label>
                                <textarea id="imunisasi" 
                                          name="imunisasi" 
                                          rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Contoh: BCG, Polio, Campak, DPT">{{ old('imunisasi') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua (Ayah) -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-male text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Ayah</h4>
                            <p class="text-sm text-gray-600">Informasi ayah siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Nama Ayah -->
                        <div class="md:col-span-1">
                            <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_ayah"
                                   name="nama_ayah" 
                                   value="{{ old('nama_ayah') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK Ayah -->
                        <div>
                            <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Ayah
                            </label>
                            <input type="text" 
                                   id="nik_ayah"
                                   name="nik_ayah" 
                                   value="{{ old('nik_ayah') }}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="16 digit NIK">
                            @error('nik_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir Ayah -->
                        <div>
                            <label for="tempat_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir Ayah
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_ayah"
                                   name="tempat_lahir_ayah" 
                                   value="{{ old('tempat_lahir_ayah') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tanggal Lahir Ayah -->
                        <div>
                            <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir Ayah
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_ayah"
                                   name="tanggal_lahir_ayah" 
                                   value="{{ old('tanggal_lahir_ayah') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pendidikan Ayah -->
                        <div>
                            <label for="pendidikan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendidikan Ayah
                            </label>
                            <select id="pendidikan_ayah" 
                                    name="pendidikan_ayah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah" {{ old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ayah') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan_ayah') == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>

                        <!-- Pekerjaan Ayah -->
                        <div>
                            <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Ayah
                            </label>
                            <select id="pekerjaan_ayah" 
                                    name="pekerjaan_ayah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

                        <!-- Bidang Pekerjaan Ayah -->
                        <div>
                            <label for="bidang_pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Pekerjaan
                            </label>
                            <input type="text" 
                                   id="bidang_pekerjaan_ayah"
                                   name="bidang_pekerjaan_ayah" 
                                   value="{{ old('bidang_pekerjaan_ayah') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Pendidikan, Kesehatan">
                        </div>

                        <!-- Penghasilan Ayah -->
                        <div>
                            <label for="penghasilan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan per Bulan
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

                        <!-- No HP Ayah -->
                        <div>
                            <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP/WA Ayah
                            </label>
                            <input type="tel" 
                                   id="no_hp_ayah"
                                   name="no_hp_ayah" 
                                   value="{{ old('no_hp_ayah') }}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email Ayah -->
                        <div>
                            <label for="email_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Ayah
                            </label>
                            <input type="email" 
                                   id="email_ayah"
                                   name="email_ayah" 
                                   value="{{ old('email_ayah') }}"
                                   placeholder="ayah@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua (Ibu) -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-female text-pink-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Ibu</h4>
                            <p class="text-sm text-gray-600">Informasi ibu siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Nama Ibu -->
                        <div class="md:col-span-1">
                            <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_ibu"
                                   name="nama_ibu" 
                                   value="{{ old('nama_ibu') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK Ibu -->
                        <div>
                            <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Ibu
                            </label>
                            <input type="text" 
                                   id="nik_ibu"
                                   name="nik_ibu" 
                                   value="{{ old('nik_ibu') }}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="16 digit NIK">
                            @error('nik_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir Ibu -->
                        <div>
                            <label for="tempat_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir Ibu
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_ibu"
                                   name="tempat_lahir_ibu" 
                                   value="{{ old('tempat_lahir_ibu') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tanggal Lahir Ibu -->
                        <div>
                            <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir Ibu
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_ibu"
                                   name="tanggal_lahir_ibu" 
                                   value="{{ old('tanggal_lahir_ibu') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pendidikan Ibu -->
                        <div>
                            <label for="pendidikan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendidikan Ibu
                            </label>
                            <select id="pendidikan_ibu" 
                                    name="pendidikan_ibu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah" {{ old('pendidikan_ibu') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ibu') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan_ibu') == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ibu') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ibu') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>

                        <!-- Pekerjaan Ibu -->
                        <div>
                            <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Ibu
                            </label>
                            <select id="pekerjaan_ibu" 
                                    name="pekerjaan_ibu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

                        <!-- Bidang Pekerjaan Ibu -->
                        <div>
                            <label for="bidang_pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Pekerjaan
                            </label>
                            <input type="text" 
                                   id="bidang_pekerjaan_ibu"
                                   name="bidang_pekerjaan_ibu" 
                                   value="{{ old('bidang_pekerjaan_ibu') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Kesehatan, Pendidikan">
                        </div>

                        <!-- Penghasilan Ibu -->
                        <div>
                            <label for="penghasilan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan per Bulan
                            </label>
                            <select id="penghasilan_ibu" 
                                    name="penghasilan_ibu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Penghasilan</option>
                                <option value="< 1 juta" {{ old('penghasilan_ibu') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                <option value="1-3 juta" {{ old('penghasilan_ibu') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                <option value="3-5 juta" {{ old('penghasilan_ibu') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                <option value="5-10 juta" {{ old('penghasilan_ibu') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                <option value="> 10 juta" {{ old('penghasilan_ibu') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                            </select>
                        </div>

                        <!-- No HP Ibu -->
                        <div>
                            <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP/WA Ibu
                            </label>
                            <input type="tel" 
                                   id="no_hp_ibu"
                                   name="no_hp_ibu" 
                                   value="{{ old('no_hp_ibu') }}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email Ibu -->
                        <div>
                            <label for="email_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Ibu
                            </label>
                            <input type="email" 
                                   id="email_ibu"
                                   name="email_ibu" 
                                   value="{{ old('email_ibu') }}"
                                   placeholder="ibu@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Kontak Gabungan (untuk kompatibilitas) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 pt-4 border-t border-gray-200">
                        <div>
                            <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP/WA Utama <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="no_hp_ortu"
                                   name="no_hp_ortu" 
                                   value="{{ old('no_hp_ortu') }}"
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Nomor HP utama yang bisa dihubungi</p>
                            @error('no_hp_ortu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Utama
                            </label>
                            <input type="email" 
                                   id="email_ortu"
                                   name="email_ortu" 
                                   value="{{ old('email_ortu') }}"
                                   placeholder="orangtua@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_ortu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Wali (Opsional) -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Wali (Jika Ada)</h4>
                            <p class="text-sm text-gray-600">Isi jika siswa tinggal dengan wali</p>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <input type="checkbox" 
                               id="punya_wali" 
                               name="punya_wali" 
                               value="1"
                               {{ old('punya_wali') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="punya_wali" class="ml-2 text-sm text-gray-700">
                            Centang jika memiliki wali
                        </label>
                    </div>

                    <div id="dataWaliContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6 {{ old('punya_wali') ? '' : 'hidden' }}">
                        <!-- Nama Wali -->
                        <div>
                            <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Wali
                            </label>
                            <input type="text" 
                                   id="nama_wali"
                                   name="nama_wali" 
                                   value="{{ old('nama_wali') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Hubungan dengan Anak -->
                        <div>
                            <label for="hubungan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Hubungan dengan Anak
                            </label>
                            <select id="hubungan_wali" 
                                    name="hubungan_wali" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Hubungan</option>
                                <option value="Kakek" {{ old('hubungan_wali') == 'Kakek' ? 'selected' : '' }}>Kakek</option>
                                <option value="Nenek" {{ old('hubungan_wali') == 'Nenek' ? 'selected' : '' }}>Nenek</option>
                                <option value="Paman" {{ old('hubungan_wali') == 'Paman' ? 'selected' : '' }}>Paman</option>
                                <option value="Bibi" {{ old('hubungan_wali') == 'Bibi' ? 'selected' : '' }}>Bibi</option>
                                <option value="Kakak" {{ old('hubungan_wali') == 'Kakak' ? 'selected' : '' }}>Kakak</option>
                                <option value="Lainnya" {{ old('hubungan_wali') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- NIK Wali -->
                        <div>
                            <label for="nik_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Wali
                            </label>
                            <input type="text" 
                                   id="nik_wali"
                                   name="nik_wali" 
                                   value="{{ old('nik_wali') }}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pekerjaan Wali -->
                        <div>
                            <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Wali
                            </label>
                            <input type="text" 
                                   id="pekerjaan_wali"
                                   name="pekerjaan_wali" 
                                   value="{{ old('pekerjaan_wali') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- No Telepon Wali -->
                        <div>
                            <label for="nomor_telepon_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                No. Telepon Wali
                            </label>
                            <input type="tel" 
                                   id="nomor_telepon_wali"
                                   name="nomor_telepon_wali" 
                                   value="{{ old('nomor_telepon_wali') }}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Informasi Sekolah -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-school text-indigo-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Informasi Sekolah</h4>
                            <p class="text-sm text-gray-600">Data akademik siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Kelompok -->
                        <div>
                            <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelompok <span class="text-red-500">*</span>
                            </label>
                            <select id="kelompok" 
                                    name="kelompok" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelompok</option>
                                <option value="A" {{ old('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A (3-4 tahun)</option>
                                <option value="B" {{ old('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B (5-6 tahun)</option>
                            </select>
                            @error('kelompok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun Ajaran ID -->
                        <div>
                            <label for="tahun_ajaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>
                            <select id="tahun_ajaran_id" 
                                    name="tahun_ajaran_id" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $tahunAjaranAktif->id ?? '') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} - Semester {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun Ajaran String (untuk kompatibilitas) -->
                        <input type="hidden" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran') }}">

                        <!-- Status Siswa -->
                        <div>
                            <label for="status_siswa" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Siswa <span class="text-red-500">*</span>
                            </label>
                            <select id="status_siswa" 
                                    name="status_siswa" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="aktif" {{ old('status_siswa') == 'aktif' ? 'selected' : 'selected' }}>Aktif</option>
                                <option value="lulus" {{ old('status_siswa') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="pindah" {{ old('status_siswa') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            </select>
                            @error('status_siswa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Masuk -->
                        <div>
                            <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Masuk <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   id="tanggal_masuk"
                                   name="tanggal_masuk" 
                                   value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tanggal_masuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jalur Masuk -->
                        <div>
                            <label for="jalur_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                                Jalur Masuk
                            </label>
                            <select id="jalur_masuk" 
                                    name="jalur_masuk" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jalur</option>
                                <option value="zonasi" {{ old('jalur_masuk') == 'zonasi' ? 'selected' : '' }}>Zonasi</option>
                                <option value="afirmasi" {{ old('jalur_masuk') == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                                <option value="prestasi" {{ old('jalur_masuk') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="mutasi" {{ old('jalur_masuk') == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                                <option value="reguler" {{ old('jalur_masuk') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                            </select>
                            @error('jalur_masuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kelas dan Guru Kelas (Opsional) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas
                            </label>
                            <input type="text" 
                                   id="kelas"
                                   name="kelas" 
                                   value="{{ old('kelas') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Kelas A1">
                        </div>

                        <div>
                            <label for="guru_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                                Guru Kelas
                            </label>
                            <input type="text" 
                                   id="guru_kelas"
                                   name="guru_kelas" 
                                   value="{{ old('guru_kelas') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nama guru kelas">
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea id="catatan" 
                                  name="catatan" 
                                  rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Catatan tambahan tentang siswa">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-camera text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Foto Siswa</h4>
                            <p class="text-sm text-gray-600">Upload foto siswa (opsional)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto Siswa -->
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Siswa
                            </label>
                            <input type="file" 
                                   id="foto"
                                   name="foto" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   onchange="previewImage(event)">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG (maks. 2MB)</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview Foto</label>
                            <div id="imagePreview" class="mt-2 border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center">
                                <div class="text-center" id="previewPlaceholder">
                                    <i class="fas fa-user text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-500">Foto akan muncul di sini</p>
                                </div>
                                <img id="preview" class="hidden h-32 w-32 rounded-lg object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Data Siswa
                        </button>
                        
                        <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                           class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-4 px-6 rounded-lg text-center transition duration-300">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk mengisi tahun_ajaran string otomatis -->
<script>
    document.getElementById('tahun_ajaran_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tahunAjaranText = selectedOption.text.split(' - ')[0]; // Ambil "2025/2026" dari "2025/2026 - Semester Ganjil"
        document.getElementById('tahun_ajaran').value = tahunAjaranText;
    });

    // Trigger change on page load if there's a selected value
    document.addEventListener('DOMContentLoaded', function() {
        const tahunAjaranSelect = document.getElementById('tahun_ajaran_id');
        if (tahunAjaranSelect.value) {
            tahunAjaranSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection

@push('scripts')
<script>
    // Validasi input NIK hanya angka
    document.getElementById('nik').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    // Validasi NIK Ayah & Ibu hanya angka
    document.getElementById('nik_ayah')?.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    document.getElementById('nik_ibu')?.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });

    document.getElementById('nik_wali')?.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });
    
    // Hitung dan tampilkan usia
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        const ageDisplay = document.getElementById('ageDisplay');
        const kelompokSelect = document.getElementById('kelompok');
        
        if (age > 0) {
            let message = `Usia: ${age} tahun`;
            
            // Peringatan jika usia tidak sesuai untuk TK
            if (age < 3) {
                message += ' <span class="text-red-500">(Di bawah usia minimal TK: 3 tahun)</span>';
                if (kelompokSelect) kelompokSelect.value = '';
            } else if (age > 6) {
                message += ' <span class="text-orange-500">(Di atas usia maksimal TK: 6 tahun)</span>';
                if (kelompokSelect) kelompokSelect.value = '';
            } else if (age >= 3 && age <= 4) {
                message += ' <span class="text-green-500">(Usia cocok untuk Kelompok A)</span>';
                if (kelompokSelect && !kelompokSelect.value) kelompokSelect.value = 'A';
            } else if (age >= 5 && age <= 6) {
                message += ' <span class="text-blue-500">(Usia cocok untuk Kelompok B)</span>';
                if (kelompokSelect && !kelompokSelect.value) kelompokSelect.value = 'B';
            }
            
            ageDisplay.innerHTML = message;
        } else {
            ageDisplay.textContent = '';
        }
    });

    // Validasi nomor telepon
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // Toggle data wali
    document.getElementById('punya_wali').addEventListener('change', function() {
        const container = document.getElementById('dataWaliContainer');
        if (this.checked) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    });

    // Preview image
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewPlaceholder = document.getElementById('previewPlaceholder');
        const file = event.target.files[0];
        
        if (file) {
            // Validasi ukuran file (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                this.value = '';
                return;
            }
            
            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (previewPlaceholder) previewPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Inisialisasi jika sudah ada value dari old input
    document.addEventListener('DOMContentLoaded', function() {
        // Hitung usia jika tanggal lahir sudah diisi
        const birthDateInput = document.getElementById('tanggal_lahir');
        if (birthDateInput.value) {
            birthDateInput.dispatchEvent(new Event('change'));
        }
        
        // Toggle wali jika sudah dicentang
        const punyaWaliCheckbox = document.getElementById('punya_wali');
        if (punyaWaliCheckbox && punyaWaliCheckbox.checked) {
            document.getElementById('dataWaliContainer').classList.remove('hidden');
        }
    });
</script>
@endpush