@extends('layouts.admin')

@section('title', 'Edit Data Siswa')
@section('breadcrumb', 'Edit Siswa')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Edit Data Siswa</h2>
                    <p class="text-sm text-gray-600">Update data siswa: {{ $siswa->nama_lengkap }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($siswa->foto)
                    <img src="{{ asset('storage/' . $siswa->foto) }}" 
                         alt="{{ $siswa->nama_lengkap }}"
                         class="h-10 w-10 rounded-full object-cover border">
                    @else
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.siswa.siswa-aktif.update', $siswa) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Nav tabs -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabMenu" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg active-tab" id="profile-tab" type="button" role="tab" onclick="showTab('profile')">Data Pribadi</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="address-tab" type="button" role="tab" onclick="showTab('address')">Alamat & Kesehatan</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="father-tab" type="button" role="tab" onclick="showTab('father')">Data Ayah</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="mother-tab" type="button" role="tab" onclick="showTab('mother')">Data Ibu</button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="academic-tab" type="button" role="tab" onclick="showTab('academic')">Akademik</button>
                    </li>
                </ul>
            </div>

            <!-- Tab: Data Pribadi -->
            <div id="profile" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" id="nik" 
                               value="{{ old('nik', $siswa->nik) }}"
                               maxlength="16"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIS -->
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">
                            NIS
                        </label>
                        <input type="text" name="nis" id="nis" 
                               value="{{ old('nis', $siswa->nis) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nis')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">
                            NISN
                        </label>
                        <input type="text" name="nisn" id="nisn" 
                               value="{{ old('nisn', $siswa->nisn) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                               value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('nama_lengkap')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Panggilan -->
                    <div>
                        <label for="nama_panggilan" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Panggilan
                        </label>
                        <input type="text" name="nama_panggilan" id="nama_panggilan" 
                               value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama_panggilan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" 
                               value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('tempat_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        <div id="ageDisplay" class="mt-1 text-sm text-gray-600"></div>
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="L" 
                                       {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                       class="form-radio text-blue-600">
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="P"
                                       {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                       class="form-radio text-pink-600">
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                        <select id="agama" name="agama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('agama', $siswa->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('agama', $siswa->agama) == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                            <option value="Hindu" {{ old('agama', $siswa->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $siswa->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama', $siswa->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            <option value="Lainnya" {{ old('agama', $siswa->agama) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('agama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tab: Alamat & Kesehatan -->
            <div id="address" class="tab-content hidden">
                <div class="space-y-6">
                    <!-- Alamat Lengkap -->
                    <div>
                        <h4 class="text-md font-medium text-gray-700 mb-3">Alamat Lengkap</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" name="provinsi" id="provinsi" 
                                       value="{{ old('provinsi', $siswa->provinsi) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="kota_kabupaten" class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                                <input type="text" name="kota_kabupaten" id="kota_kabupaten" 
                                       value="{{ old('kota_kabupaten', $siswa->kota_kabupaten) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                                <input type="text" name="kecamatan" id="kecamatan" 
                                       value="{{ old('kecamatan', $siswa->kecamatan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan/Desa</label>
                                <input type="text" name="kelurahan" id="kelurahan" 
                                       value="{{ old('kelurahan', $siswa->kelurahan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label for="nama_jalan" class="block text-sm font-medium text-gray-700 mb-1">Nama Jalan, RT/RW</label>
                                <input type="text" name="nama_jalan" id="nama_jalan" 
                                       value="{{ old('nama_jalan', $siswa->nama_jalan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <!-- Alamat Lengkap (satu baris) -->
                        <div class="mt-4">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat Lengkap (satu baris) <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="2"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      required>{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Kesehatan -->
                    <div class="pt-6 border-t border-gray-200">
                        <h4 class="text-md font-medium text-gray-700 mb-3">Data Kesehatan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-1">Berat Badan (kg)</label>
                                <input type="number" step="0.1" name="berat_badan" id="berat_badan" 
                                       value="{{ old('berat_badan', $siswa->berat_badan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" 
                                       value="{{ old('tinggi_badan', $siswa->tinggi_badan) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-1">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih</option>
                                    <option value="A" {{ old('golongan_darah', $siswa->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah', $siswa->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah', $siswa->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah', $siswa->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="penyakit_pernah_diderita" class="block text-sm font-medium text-gray-700 mb-1">Penyakit Pernah Diderita</label>
                                <textarea name="penyakit_pernah_diderita" id="penyakit_pernah_diderita" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('penyakit_pernah_diderita', $siswa->penyakit_pernah_diderita) }}</textarea>
                            </div>
                            <div>
                                <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-1">Imunisasi</label>
                                <textarea name="imunisasi" id="imunisasi" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('imunisasi', $siswa->imunisasi) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab: Data Ayah -->
            <div id="father" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Ayah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_ayah" id="nama_ayah"
                               value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('nama_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ayah" class="block text-sm font-medium text-gray-700 mb-1">NIK Ayah</label>
                        <input type="text" name="nik_ayah" id="nik_ayah" 
                               value="{{ old('nik_ayah', $siswa->nik_ayah) }}"
                               maxlength="16"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nik_ayah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tempat_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" 
                               value="{{ old('tempat_lahir_ayah', $siswa->tempat_lahir_ayah) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" 
                               value="{{ old('tanggal_lahir_ayah', $siswa->tanggal_lahir_ayah?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="pendidikan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" id="pendidikan_ayah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="Tidak Sekolah" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                            <option value="SD" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="D1-D3" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                            <option value="S1" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_ayah', $siswa->pendidikan_ayah) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                        <select name="pekerjaan_ayah" id="pekerjaan_ayah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Pekerjaan</option>
                            <option value="Wiraswasta" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option value="PNS" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="TNI/Polri" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                            <option value="Karyawan Swasta" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                            <option value="Petani" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Petani' ? 'selected' : '' }}>Petani</option>
                            <option value="Nelayan" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                            <option value="Buruh" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                            <option value="Dokter" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="Guru" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Lainnya" {{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="bidang_pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Bidang Pekerjaan</label>
                        <input type="text" name="bidang_pekerjaan_ayah" id="bidang_pekerjaan_ayah" 
                               value="{{ old('bidang_pekerjaan_ayah', $siswa->bidang_pekerjaan_ayah) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="penghasilan_ayah" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan per Bulan</label>
                        <select name="penghasilan_ayah" id="penghasilan_ayah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Penghasilan</option>
                            <option value="< 1 juta" {{ old('penghasilan_ayah', $siswa->penghasilan_ayah) == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="1-3 juta" {{ old('penghasilan_ayah', $siswa->penghasilan_ayah) == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                            <option value="3-5 juta" {{ old('penghasilan_ayah', $siswa->penghasilan_ayah) == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                            <option value="5-10 juta" {{ old('penghasilan_ayah', $siswa->penghasilan_ayah) == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                            <option value="> 10 juta" {{ old('penghasilan_ayah', $siswa->penghasilan_ayah) == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                        </select>
                    </div>

                    <div>
                        <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 mb-1">No. HP Ayah</label>
                        <input type="tel" name="no_hp_ayah" id="no_hp_ayah" 
                               value="{{ old('no_hp_ayah', $siswa->no_hp_ayah) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email_ayah" class="block text-sm font-medium text-gray-700 mb-1">Email Ayah</label>
                        <input type="email" name="email_ayah" id="email_ayah" 
                               value="{{ old('email_ayah', $siswa->email_ayah) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Tab: Data Ibu -->
            <div id="mother" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Ibu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_ibu" id="nama_ibu"
                               value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('nama_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nik_ibu" class="block text-sm font-medium text-gray-700 mb-1">NIK Ibu</label>
                        <input type="text" name="nik_ibu" id="nik_ibu" 
                               value="{{ old('nik_ibu', $siswa->nik_ibu) }}"
                               maxlength="16"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nik_ibu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tempat_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" 
                               value="{{ old('tempat_lahir_ibu', $siswa->tempat_lahir_ibu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" 
                               value="{{ old('tanggal_lahir_ibu', $siswa->tanggal_lahir_ibu?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="pendidikan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" id="pendidikan_ibu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Pendidikan</option>
                            <option value="Tidak Sekolah" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                            <option value="SD" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="D1-D3" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                            <option value="S1" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_ibu', $siswa->pendidikan_ibu) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>

                    <div>
                        <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                        <select name="pekerjaan_ibu" id="pekerjaan_ibu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Pekerjaan</option>
                            <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                            <option value="Wiraswasta" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option value="PNS" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="Karyawan Swasta" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                            <option value="Guru" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Perawat" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                            <option value="Lainnya" {{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="bidang_pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Bidang Pekerjaan</label>
                        <input type="text" name="bidang_pekerjaan_ibu" id="bidang_pekerjaan_ibu" 
                               value="{{ old('bidang_pekerjaan_ibu', $siswa->bidang_pekerjaan_ibu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="penghasilan_ibu" class="block text-sm font-medium text-gray-700 mb-1">Penghasilan per Bulan</label>
                        <select name="penghasilan_ibu" id="penghasilan_ibu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Penghasilan</option>
                            <option value="< 1 juta" {{ old('penghasilan_ibu', $siswa->penghasilan_ibu) == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="1-3 juta" {{ old('penghasilan_ibu', $siswa->penghasilan_ibu) == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                            <option value="3-5 juta" {{ old('penghasilan_ibu', $siswa->penghasilan_ibu) == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                            <option value="5-10 juta" {{ old('penghasilan_ibu', $siswa->penghasilan_ibu) == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                            <option value="> 10 juta" {{ old('penghasilan_ibu', $siswa->penghasilan_ibu) == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                        </select>
                    </div>

                    <div>
                        <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 mb-1">No. HP Ibu</label>
                        <input type="tel" name="no_hp_ibu" id="no_hp_ibu" 
                               value="{{ old('no_hp_ibu', $siswa->no_hp_ibu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email_ibu" class="block text-sm font-medium text-gray-700 mb-1">Email Ibu</label>
                        <input type="email" name="email_ibu" id="email_ibu" 
                               value="{{ old('email_ibu', $siswa->email_ibu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Tab: Akademik -->
            <div id="academic" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kelompok -->
                    <div>
                        <label for="kelompok" class="block text-sm font-medium text-gray-700 mb-1">
                            Kelompok <span class="text-red-500">*</span>
                        </label>
                        <select name="kelompok" id="kelompok"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">Pilih Kelompok</option>
                            <option value="A" {{ old('kelompok', $siswa->kelompok) == 'A' ? 'selected' : '' }}>Kelompok A (3-4 tahun)</option>
                            <option value="B" {{ old('kelompok', $siswa->kelompok) == 'B' ? 'selected' : '' }}>Kelompok B (5-6 tahun)</option>
                        </select>
                        @error('kelompok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Ajaran ID -->
                    <div>
                        <label for="tahun_ajaran_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $siswa->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} - Semester {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', $siswa->tahun_ajaran) }}">
                        @error('tahun_ajaran_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Siswa -->
                    <div>
                        <label for="status_siswa" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status_siswa" id="status_siswa"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @foreach(['aktif', 'lulus', 'pindah'] as $status)
                            <option value="{{ $status }}" 
                                    {{ old('status_siswa', $siswa->status_siswa) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status_siswa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                               value="{{ old('tanggal_masuk', $siswa->tanggal_masuk->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('tanggal_masuk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Keluar -->
                    <div>
                        <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                               value="{{ old('tanggal_keluar', $siswa->tanggal_keluar?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tanggal_keluar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jalur Masuk -->
                    <div>
                        <label for="jalur_masuk" class="block text-sm font-medium text-gray-700 mb-1">Jalur Masuk</label>
                        <select name="jalur_masuk" id="jalur_masuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Jalur</option>
                            <option value="zonasi" {{ old('jalur_masuk', $siswa->jalur_masuk) == 'zonasi' ? 'selected' : '' }}>Zonasi</option>
                            <option value="afirmasi" {{ old('jalur_masuk', $siswa->jalur_masuk) == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                            <option value="prestasi" {{ old('jalur_masuk', $siswa->jalur_masuk) == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="mutasi" {{ old('jalur_masuk', $siswa->jalur_masuk) == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                            <option value="reguler" {{ old('jalur_masuk', $siswa->jalur_masuk) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <input type="text" name="kelas" id="kelas" 
                               value="{{ old('kelas', $siswa->kelas) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Guru Kelas -->
                    <div>
                        <label for="guru_kelas" class="block text-sm font-medium text-gray-700 mb-1">Guru Kelas</label>
                        <input type="text" name="guru_kelas" id="guru_kelas" 
                               value="{{ old('guru_kelas', $siswa->guru_kelas) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Catatan -->
                    <div class="md:col-span-3">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan', $siswa->catatan) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Kontak Gabungan -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-md font-medium text-gray-700 mb-3">Kontak Utama</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-1">
                            No. HP/WA Utama <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="no_hp_ortu" id="no_hp_ortu"
                               value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('no_hp_ortu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_ortu" class="block text-sm font-medium text-gray-700 mb-1">Email Utama</label>
                        <input type="email" name="email_ortu" id="email_ortu" 
                               value="{{ old('email_ortu', $siswa->email_ortu) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email_ortu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Wali -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-md font-medium text-gray-700">Data Wali (Jika Ada)</h4>
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="punya_wali" name="punya_wali" value="1" 
                               {{ old('punya_wali', $siswa->punya_wali) ? 'checked' : '' }}
                               class="form-checkbox text-blue-600">
                        <span class="ml-2 text-sm text-gray-700">Punya wali</span>
                    </label>
                </div>
                
                <div id="dataWaliContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6 {{ old('punya_wali', $siswa->punya_wali) ? '' : 'hidden' }}">
                    <div>
                        <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-1">Nama Wali</label>
                        <input type="text" name="nama_wali" id="nama_wali" 
                               value="{{ old('nama_wali', $siswa->nama_wali) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="hubungan_wali" class="block text-sm font-medium text-gray-700 mb-1">Hubungan dengan Anak</label>
                        <select name="hubungan_wali" id="hubungan_wali" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Hubungan</option>
                            <option value="Kakek" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Kakek' ? 'selected' : '' }}>Kakek</option>
                            <option value="Nenek" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Nenek' ? 'selected' : '' }}>Nenek</option>
                            <option value="Paman" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Paman' ? 'selected' : '' }}>Paman</option>
                            <option value="Bibi" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Bibi' ? 'selected' : '' }}>Bibi</option>
                            <option value="Kakak" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Kakak' ? 'selected' : '' }}>Kakak</option>
                            <option value="Lainnya" {{ old('hubungan_wali', $siswa->hubungan_wali) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label for="nik_wali" class="block text-sm font-medium text-gray-700 mb-1">NIK Wali</label>
                        <input type="text" name="nik_wali" id="nik_wali" 
                               value="{{ old('nik_wali', $siswa->nik_wali) }}"
                               maxlength="16"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" id="pekerjaan_wali" 
                               value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="nomor_telepon_wali" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon Wali</label>
                        <input type="tel" name="nomor_telepon_wali" id="nomor_telepon_wali" 
                               value="{{ old('nomor_telepon_wali', $siswa->nomor_telepon_wali) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-md font-medium text-gray-700 mb-3">Foto Siswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        @if($siswa->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                 alt="{{ $siswa->nama_lengkap }}"
                                 class="h-24 w-24 rounded-lg object-cover border">
                        </div>
                        @endif
                        
                        <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                            Ganti Foto
                        </label>
                        <input type="file" name="foto" id="foto" 
                               accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               onchange="previewImage(event)">
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG (maks. 2MB)</p>
                        @error('foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Image Preview -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preview Foto Baru</label>
                        <div id="imagePreview" class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center">
                            <div class="text-center" id="previewPlaceholder">
                                <i class="fas fa-user text-gray-400 text-4xl mb-2"></i>
                                <p class="text-sm text-gray-500">Preview akan muncul di sini</p>
                            </div>
                            <img id="preview" class="hidden h-32 w-32 rounded-lg object-cover">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tombol -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                <div>
                    <a href="{{ route('admin.siswa.siswa-aktif.show', $siswa) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 flex items-center">
                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                    </a>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk tab switching
    function showTab(tabName) {
        // Sembunyikan semua tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Hapus active class dari semua tab button
        document.querySelectorAll('[role="tab"]').forEach(btn => {
            btn.classList.remove('active-tab', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent');
        });
        
        // Tampilkan tab yang dipilih
        document.getElementById(tabName).classList.remove('hidden');
        
        // Activekan tab button
        const activeBtn = document.getElementById(tabName + '-tab');
        activeBtn.classList.add('active-tab', 'border-blue-500', 'text-blue-600');
        activeBtn.classList.remove('border-transparent');
    }

    // Toggle data wali
    document.getElementById('punya_wali')?.addEventListener('change', function() {
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
                previewPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Hitung dan tampilkan usia
    document.getElementById('tanggal_lahir')?.addEventListener('change', function() {
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

    // Auto-fill tahun_ajaran string dari tahun_ajaran_id
    document.getElementById('tahun_ajaran_id')?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tahunAjaranText = selectedOption.text.split(' - ')[0];
        document.getElementById('tahun_ajaran').value = tahunAjaranText;
    });

    // Validasi NIK dan nomor telepon
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    document.querySelectorAll('input[maxlength="16"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    });

    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
        // Tampilkan tab pertama
        showTab('profile');
        
        // Hitung usia jika tanggal lahir sudah diisi
        const birthDateInput = document.getElementById('tanggal_lahir');
        if (birthDateInput && birthDateInput.value) {
            birthDateInput.dispatchEvent(new Event('change'));
        }
        
        // Trigger change untuk tahun_ajaran_id
        const tahunAjaranSelect = document.getElementById('tahun_ajaran_id');
        if (tahunAjaranSelect && tahunAjaranSelect.value) {
            tahunAjaranSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

<style>
    .active-tab {
        border-bottom-color: #3b82f6;
        color: #2563eb;
    }
</style>
@endsection