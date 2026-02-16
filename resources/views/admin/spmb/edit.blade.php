{{-- resources/views/admin/spmb/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Data SPMB')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-edit mr-2"></i>Edit Data SPMB
                </h1>
                <p class="text-gray-600 mt-2">Edit data pendaftaran SPMB No: {{ $spmb->no_pendaftaran ?? '-' }}</p>
            </div>
            <a href="{{ route('admin.spmb.show', $spmb) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Formulir Edit Pendaftaran SPMB</h3>
            <p class="text-sm text-gray-600">Edit data calon siswa dan orang tua sesuai dokumen resmi</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.spmb.update', $spmb) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Data Calon Siswa (Bagian 1) -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-child text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Calon Siswa</h4>
                            <p class="text-sm text-gray-600">Informasi pribadi calon siswa sesuai akta kelahiran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap Anak -->
                        <div>
                            <label for="nama_lengkap_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Anak *
                            </label>
                            <input type="text" 
                                   id="nama_lengkap_anak"
                                   name="nama_lengkap_anak" 
                                   value="{{ old('nama_lengkap_anak', $spmb->nama_lengkap_anak) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap_anak') border-red-500 @enderror"
                                   placeholder="Nama sesuai akta kelahiran">
                            @error('nama_lengkap_anak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Panggilan -->
                        <div>
                            <label for="nama_panggilan_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Panggilan
                            </label>
                            <input type="text" 
                                   id="nama_panggilan_anak"
                                   name="nama_panggilan_anak" 
                                   value="{{ old('nama_panggilan_anak', $spmb->nama_panggilan_anak) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Nama panggilan sehari-hari">
                            @error('nama_panggilan_anak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK Anak -->
                        <div>
                            <label for="nik_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK Anak *
                            </label>
                            <input type="text" 
                                   id="nik_anak"
                                   name="nik_anak" 
                                   value="{{ old('nik_anak', $spmb->nik_anak) }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_anak') border-red-500 @enderror"
                                   placeholder="16 digit NIK">
                            <p class="text-xs text-gray-500 mt-1">Nomor Induk Kependudukan</p>
                            @error('nik_anak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir *
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_anak"
                                   name="tempat_lahir_anak" 
                                   value="{{ old('tempat_lahir_anak', $spmb->tempat_lahir_anak) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tempat_lahir_anak') border-red-500 @enderror"
                                   placeholder="Kota/kabupaten">
                            @error('tempat_lahir_anak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir *
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_anak"
                                   name="tanggal_lahir_anak" 
                                   value="{{ old('tanggal_lahir_anak', $spmb->tanggal_lahir_anak instanceof \Carbon\Carbon ? $spmb->tanggal_lahir_anak->format('Y-m-d') : $spmb->tanggal_lahir_anak) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_lahir_anak') border-red-500 @enderror">
                            <div id="ageDisplay" class="mt-1 text-sm text-gray-600"></div>
                            @error('tanggal_lahir_anak')
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
                                <option value="Laki-laki" {{ old('jenis_kelamin', $spmb->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $spmb->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
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
                                <option value="Islam" {{ old('agama', $spmb->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ old('agama', $spmb->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Kristen Katolik" {{ old('agama', $spmb->agama) == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                <option value="Hindu" {{ old('agama', $spmb->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $spmb->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $spmb->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                <option value="Lainnya" {{ old('agama', $spmb->agama) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Anak Ke -->
                        <div>
                            <label for="anak_ke" class="block text-sm font-medium text-gray-700 mb-2">
                                Anak Ke *
                            </label>
                            <input type="number" 
                                   id="anak_ke"
                                   name="anak_ke" 
                                   value="{{ old('anak_ke', $spmb->anak_ke) }}"
                                   required
                                   min="1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('anak_ke') border-red-500 @enderror"
                                   placeholder="Contoh: 1, 2, 3">
                            @error('anak_ke')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tinggal Bersama -->
                        <div>
                            <label for="tinggal_bersama" class="block text-sm font-medium text-gray-700 mb-2">
                                Tinggal Bersama *
                            </label>
                            <select id="tinggal_bersama" 
                                    name="tinggal_bersama" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tinggal_bersama') border-red-500 @enderror">
                                <option value="">Pilih</option>
                                <option value="Ayah dan Ibu" {{ old('tinggal_bersama', $spmb->tinggal_bersama) == 'Ayah dan Ibu' ? 'selected' : '' }}>Ayah dan Ibu</option>
                                <option value="Ayah" {{ old('tinggal_bersama', $spmb->tinggal_bersama) == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                <option value="Ibu" {{ old('tinggal_bersama', $spmb->tinggal_bersama) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Wali" {{ old('tinggal_bersama', $spmb->tinggal_bersama) == 'Wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                            @error('tinggal_bersama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Tempat Tinggal -->
                        <div>
                            <label for="status_tempat_tinggal" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Tempat Tinggal *
                            </label>
                            <select id="status_tempat_tinggal" 
                                    name="status_tempat_tinggal" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status_tempat_tinggal') border-red-500 @enderror">
                                <option value="">Pilih</option>
                                <option value="Milik Sendiri" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                <option value="Kontrak" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                <option value="Sewa" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                <option value="Menumpang" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Menumpang' ? 'selected' : '' }}>Menumpang</option>
                                <option value="Dinas" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Dinas' ? 'selected' : '' }}>Dinas</option>
                                <option value="Lainnya" {{ old('status_tempat_tinggal', $spmb->status_tempat_tinggal) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('status_tempat_tinggal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bahasa Sehari-hari -->
                        <div>
                            <label for="bahasa_sehari_hari" class="block text-sm font-medium text-gray-700 mb-2">
                                Bahasa Sehari-hari *
                            </label>
                            <input type="text" 
                                   id="bahasa_sehari_hari"
                                   name="bahasa_sehari_hari" 
                                   value="{{ old('bahasa_sehari_hari', $spmb->bahasa_sehari_hari) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bahasa_sehari_hari') border-red-500 @enderror"
                                   placeholder="Contoh: Indonesia, Sunda, Jawa">
                            @error('bahasa_sehari_hari')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jarak Rumah ke Sekolah -->
                        <div>
                            <label for="jarak_rumah_ke_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                                Jarak Rumah ke Sekolah (meter)
                            </label>
                            <input type="number" 
                                   id="jarak_rumah_ke_sekolah"
                                   name="jarak_rumah_ke_sekolah" 
                                   value="{{ old('jarak_rumah_ke_sekolah', $spmb->jarak_rumah_ke_sekolah) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 500">
                            @error('jarak_rumah_ke_sekolah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Tempuh -->
                        <div>
                            <label for="waktu_tempuh_ke_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Tempuh (menit)
                            </label>
                            <input type="number" 
                                   id="waktu_tempuh_ke_sekolah"
                                   name="waktu_tempuh_ke_sekolah" 
                                   value="{{ old('waktu_tempuh_ke_sekolah', $spmb->waktu_tempuh_ke_sekolah) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 15">
                            @error('waktu_tempuh_ke_sekolah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Berat Badan -->
                        <div>
                            <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                                Berat Badan (kg)
                            </label>
                            <input type="number" 
                                   id="berat_badan"
                                   name="berat_badan" 
                                   value="{{ old('berat_badan', $spmb->berat_badan) }}"
                                   step="0.1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 15.5">
                            @error('berat_badan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tinggi Badan -->
                        <div>
                            <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">
                                Tinggi Badan (cm)
                            </label>
                            <input type="number" 
                                   id="tinggi_badan"
                                   name="tinggi_badan" 
                                   value="{{ old('tinggi_badan', $spmb->tinggi_badan) }}"
                                   step="0.1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 95.5">
                            @error('tinggi_badan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Golongan Darah -->
                        <div>
                            <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">
                                Golongan Darah
                            </label>
                            <select id="golongan_darah" 
                                    name="golongan_darah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ old('golongan_darah', $spmb->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('golongan_darah', $spmb->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('golongan_darah', $spmb->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('golongan_darah', $spmb->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                                <option value="Tidak Tahu" {{ old('golongan_darah', $spmb->golongan_darah) == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                            </select>
                            @error('golongan_darah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Penyakit Pernah Diderita -->
                    <div>
                        <label for="penyakit_pernah_diderita" class="block text-sm font-medium text-gray-700 mb-2">
                            Penyakit yang Pernah Diderita
                        </label>
                        <textarea id="penyakit_pernah_diderita" 
                                  name="penyakit_pernah_diderita" 
                                  rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: Demam berdarah, cacar, asma, dll">{{ old('penyakit_pernah_diderita', $spmb->penyakit_pernah_diderita) }}</textarea>
                        @error('penyakit_pernah_diderita')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imunisasi -->
                    <div>
                        <label for="imunisasi_pernah_diterima" class="block text-sm font-medium text-gray-700 mb-2">
                            Imunisasi yang Pernah Diterima
                        </label>
                        <textarea id="imunisasi_pernah_diterima" 
                                  name="imunisasi_pernah_diterima" 
                                  rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: BCG, Polio, Campak, Hepatitis, DPT">{{ old('imunisasi_pernah_diterima', $spmb->imunisasi_pernah_diterima) }}</textarea>
                        @error('imunisasi_pernah_diterima')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- ALAMAT LENGKAP -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-indigo-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Alamat Lengkap</h4>
                            <p class="text-sm text-gray-600">Alamat sesuai domisili saat ini</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Provinsi -->
                        <div>
                            <label for="provinsi_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi *
                            </label>
                            <input type="text" 
                                   id="provinsi_rumah"
                                   name="provinsi_rumah" 
                                   value="{{ old('provinsi_rumah', $spmb->provinsi_rumah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('provinsi_rumah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota/Kabupaten -->
                        <div>
                            <label for="kota_kabupaten_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota/Kabupaten *
                            </label>
                            <input type="text" 
                                   id="kota_kabupaten_rumah"
                                   name="kota_kabupaten_rumah" 
                                   value="{{ old('kota_kabupaten_rumah', $spmb->kota_kabupaten_rumah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('kota_kabupaten_rumah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label for="kecamatan_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan *
                            </label>
                            <input type="text" 
                                   id="kecamatan_rumah"
                                   name="kecamatan_rumah" 
                                   value="{{ old('kecamatan_rumah', $spmb->kecamatan_rumah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('kecamatan_rumah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <label for="kelurahan_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa *
                            </label>
                            <input type="text" 
                                   id="kelurahan_rumah"
                                   name="kelurahan_rumah" 
                                   value="{{ old('kelurahan_rumah', $spmb->kelurahan_rumah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('kelurahan_rumah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Jalan -->
                        <div class="md:col-span-2">
                            <label for="nama_jalan_rumah" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jalan *
                            </label>
                            <input type="text" 
                                   id="nama_jalan_rumah"
                                   name="nama_jalan_rumah" 
                                   value="{{ old('nama_jalan_rumah', $spmb->nama_jalan_rumah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Jl. Terusan PSM No. 1A, RT 01 RW 02">
                            @error('nama_jalan_rumah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Checkbox Alamat KK Sama -->
                    <div class="flex items-center mt-4">
                        <input type="checkbox" 
                               id="alamat_kk_sama" 
                               name="alamat_kk_sama" 
                               value="1"
                               {{ old('alamat_kk_sama', $spmb->alamat_kk_sama) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="alamat_kk_sama" class="ml-2 text-sm text-gray-700">
                            Alamat di Kartu Keluarga (KK) sama dengan alamat di atas
                        </label>
                    </div>

                    <!-- Alamat KK (akan muncul jika checkbox tidak dicentang) -->
                    <div id="alamatKKContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 {{ old('alamat_kk_sama', $spmb->alamat_kk_sama) ? 'hidden' : '' }}">
                        <div>
                            <label for="provinsi_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi (KK)
                            </label>
                            <input type="text" 
                                   id="provinsi_kk"
                                   name="provinsi_kk" 
                                   value="{{ old('provinsi_kk', $spmb->provinsi_kk) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="kota_kabupaten_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota/Kabupaten (KK)
                            </label>
                            <input type="text" 
                                   id="kota_kabupaten_kk"
                                   name="kota_kabupaten_kk" 
                                   value="{{ old('kota_kabupaten_kk', $spmb->kota_kabupaten_kk) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="kecamatan_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan (KK)
                            </label>
                            <input type="text" 
                                   id="kecamatan_kk"
                                   name="kecamatan_kk" 
                                   value="{{ old('kecamatan_kk', $spmb->kecamatan_kk) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="kelurahan_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa (KK)
                            </label>
                            <input type="text" 
                                   id="kelurahan_kk"
                                   name="kelurahan_kk" 
                                   value="{{ old('kelurahan_kk', $spmb->kelurahan_kk) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="nama_jalan_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jalan (KK)
                            </label>
                            <input type="text" 
                                   id="nama_jalan_kk"
                                   name="nama_jalan_kk" 
                                   value="{{ old('nama_jalan_kk', $spmb->nama_jalan_kk) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Alamat lengkap sesuai KK">
                        </div>

                        <div class="md:col-span-2">
                            <label for="alamat_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat KK Lengkap
                            </label>
                            <textarea id="alamat_kk" 
                                      name="alamat_kk" 
                                      rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Alamat lengkap sesuai KK (opsional)">{{ old('alamat_kk', $spmb->alamat_kk) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Data Ayah -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-male text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Ayah</h4>
                            <p class="text-sm text-gray-600">Informasi ayah calon siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ayah -->
                        <div>
                            <label for="nama_lengkap_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Ayah *
                            </label>
                            <input type="text" 
                                   id="nama_lengkap_ayah"
                                   name="nama_lengkap_ayah" 
                                   value="{{ old('nama_lengkap_ayah', $spmb->nama_lengkap_ayah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap_ayah') border-red-500 @enderror">
                            @error('nama_lengkap_ayah')
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
                                   value="{{ old('nik_ayah', $spmb->nik_ayah) }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_ayah') border-red-500 @enderror">
                            @error('nik_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir Ayah -->
                        <div>
                            <label for="tempat_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir Ayah *
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_ayah"
                                   name="tempat_lahir_ayah" 
                                   value="{{ old('tempat_lahir_ayah', $spmb->tempat_lahir_ayah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tempat_lahir_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir Ayah -->
                        <div>
                            <label for="tanggal_lahir_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir Ayah *
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_ayah"
                                   name="tanggal_lahir_ayah" 
                                   value="{{ old('tanggal_lahir_ayah', $spmb->tanggal_lahir_ayah instanceof \Carbon\Carbon ? $spmb->tanggal_lahir_ayah->format('Y-m-d') : $spmb->tanggal_lahir_ayah) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tanggal_lahir_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                <option value="Tidak Sekolah" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ayah', $spmb->pendidikan_ayah) == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('pendidikan_ayah')
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
                                <option value="Wiraswasta" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="PNS" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="TNI/Polri" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                                <option value="Karyawan Swasta" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                <option value="Petani" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                <option value="Nelayan" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                <option value="Buruh" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                <option value="Dokter" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                                <option value="Guru" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Lainnya" {{ old('pekerjaan_ayah', $spmb->pekerjaan_ayah) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('pekerjaan_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang Pekerjaan Ayah -->
                        <div>
                            <label for="bidang_pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Pekerjaan
                            </label>
                            <input type="text" 
                                   id="bidang_pekerjaan_ayah"
                                   name="bidang_pekerjaan_ayah" 
                                   value="{{ old('bidang_pekerjaan_ayah', $spmb->bidang_pekerjaan_ayah) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Teknologi Informasi, Pendidikan, dll">
                            @error('bidang_pekerjaan_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penghasilan Ayah -->
                        <div>
                            <label for="penghasilan_per_bulan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan per Bulan
                            </label>
                            <select id="penghasilan_per_bulan_ayah" 
                                    name="penghasilan_per_bulan_ayah" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Penghasilan</option>
                                <option value="< 1 juta" {{ old('penghasilan_per_bulan_ayah', $spmb->penghasilan_per_bulan_ayah) == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                <option value="1-3 juta" {{ old('penghasilan_per_bulan_ayah', $spmb->penghasilan_per_bulan_ayah) == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                <option value="3-5 juta" {{ old('penghasilan_per_bulan_ayah', $spmb->penghasilan_per_bulan_ayah) == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                <option value="5-10 juta" {{ old('penghasilan_per_bulan_ayah', $spmb->penghasilan_per_bulan_ayah) == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                <option value="> 10 juta" {{ old('penghasilan_per_bulan_ayah', $spmb->penghasilan_per_bulan_ayah) == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                            </select>
                        </div>

                        <!-- No Telepon Ayah -->
                        <div>
                            <label for="nomor_telepon_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon/WA Ayah *
                            </label>
                            <input type="tel" 
                                   id="nomor_telepon_ayah"
                                   name="nomor_telepon_ayah" 
                                   value="{{ old('nomor_telepon_ayah', $spmb->nomor_telepon_ayah) }}"
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nomor_telepon_ayah') border-red-500 @enderror">
                            @error('nomor_telepon_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Ayah -->
                        <div>
                            <label for="email_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Ayah
                            </label>
                            <input type="email" 
                                   id="email_ayah"
                                   name="email_ayah" 
                                   value="{{ old('email_ayah', $spmb->email_ayah) }}"
                                   placeholder="ayah@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_ayah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-female text-pink-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Ibu</h4>
                            <p class="text-sm text-gray-600">Informasi ibu calon siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ibu -->
                        <div>
                            <label for="nama_lengkap_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Ibu *
                            </label>
                            <input type="text" 
                                   id="nama_lengkap_ibu"
                                   name="nama_lengkap_ibu" 
                                   value="{{ old('nama_lengkap_ibu', $spmb->nama_lengkap_ibu) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap_ibu') border-red-500 @enderror">
                            @error('nama_lengkap_ibu')
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
                                   value="{{ old('nik_ibu', $spmb->nik_ibu) }}"
                                   required
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik_ibu') border-red-500 @enderror">
                            @error('nik_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir Ibu -->
                        <div>
                            <label for="tempat_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir Ibu *
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_ibu"
                                   name="tempat_lahir_ibu" 
                                   value="{{ old('tempat_lahir_ibu', $spmb->tempat_lahir_ibu) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tempat_lahir_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir Ibu -->
                        <div>
                            <label for="tanggal_lahir_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir Ibu *
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_ibu"
                                   name="tanggal_lahir_ibu" 
                                   value="{{ old('tanggal_lahir_ibu', $spmb->tanggal_lahir_ibu instanceof \Carbon\Carbon ? $spmb->tanggal_lahir_ibu->format('Y-m-d') : $spmb->tanggal_lahir_ibu) }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('tanggal_lahir_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                                <option value="Tidak Sekolah" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ibu', $spmb->pendidikan_ibu) == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                            @error('pendidikan_ibu')
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
                                <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                <option value="Wiraswasta" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="PNS" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="Karyawan Swasta" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                <option value="Guru" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Perawat" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                                <option value="Lainnya" {{ old('pekerjaan_ibu', $spmb->pekerjaan_ibu) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('pekerjaan_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang Pekerjaan Ibu -->
                        <div>
                            <label for="bidang_pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Pekerjaan
                            </label>
                            <input type="text" 
                                   id="bidang_pekerjaan_ibu"
                                   name="bidang_pekerjaan_ibu" 
                                   value="{{ old('bidang_pekerjaan_ibu', $spmb->bidang_pekerjaan_ibu) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: Kesehatan, Pendidikan, dll">
                            @error('bidang_pekerjaan_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penghasilan Ibu -->
                        <div>
                            <label for="penghasilan_per_bulan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan per Bulan
                            </label>
                            <select id="penghasilan_per_bulan_ibu" 
                                    name="penghasilan_per_bulan_ibu" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Penghasilan</option>
                                <option value="< 1 juta" {{ old('penghasilan_per_bulan_ibu', $spmb->penghasilan_per_bulan_ibu) == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                <option value="1-3 juta" {{ old('penghasilan_per_bulan_ibu', $spmb->penghasilan_per_bulan_ibu) == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                <option value="3-5 juta" {{ old('penghasilan_per_bulan_ibu', $spmb->penghasilan_per_bulan_ibu) == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                <option value="5-10 juta" {{ old('penghasilan_per_bulan_ibu', $spmb->penghasilan_per_bulan_ibu) == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                <option value="> 10 juta" {{ old('penghasilan_per_bulan_ibu', $spmb->penghasilan_per_bulan_ibu) == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                            </select>
                        </div>

                        <!-- No Telepon Ibu -->
                        <div>
                            <label for="nomor_telepon_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon/WA Ibu *
                            </label>
                            <input type="tel" 
                                   id="nomor_telepon_ibu"
                                   name="nomor_telepon_ibu" 
                                   value="{{ old('nomor_telepon_ibu', $spmb->nomor_telepon_ibu) }}"
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nomor_telepon_ibu') border-red-500 @enderror">
                            @error('nomor_telepon_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Ibu -->
                        <div>
                            <label for="email_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Ibu
                            </label>
                            <input type="email" 
                                   id="email_ibu"
                                   name="email_ibu" 
                                   value="{{ old('email_ibu', $spmb->email_ibu) }}"
                                   placeholder="ibu@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_ibu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Wali -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Data Wali (Jika Ada)</h4>
                            <p class="text-sm text-gray-600">Isi jika anak tinggal dengan wali</p>
                        </div>
                    </div>

                    <div class="flex items-center mb-4">
                        <input type="checkbox" 
                               id="punya_wali" 
                               name="punya_wali" 
                               value="1"
                               {{ old('punya_wali', $spmb->punya_wali) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="punya_wali" class="ml-2 text-sm text-gray-700">
                            Centang jika memiliki wali
                        </label>
                    </div>

                    <div id="dataWaliContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ old('punya_wali', $spmb->punya_wali) ? '' : 'hidden' }}">
                        <!-- Nama Wali -->
                        <div>
                            <label for="nama_lengkap_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Wali
                            </label>
                            <input type="text" 
                                   id="nama_lengkap_wali"
                                   name="nama_lengkap_wali" 
                                   value="{{ old('nama_lengkap_wali', $spmb->nama_lengkap_wali) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Hubungan dengan Anak -->
                        <div>
                            <label for="hubungan_dengan_anak" class="block text-sm font-medium text-gray-700 mb-2">
                                Hubungan dengan Anak
                            </label>
                            <select id="hubungan_dengan_anak" 
                                    name="hubungan_dengan_anak" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Hubungan</option>
                                <option value="Kakek" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Kakek' ? 'selected' : '' }}>Kakek</option>
                                <option value="Nenek" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Nenek' ? 'selected' : '' }}>Nenek</option>
                                <option value="Paman" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Paman' ? 'selected' : '' }}>Paman</option>
                                <option value="Bibi" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Bibi' ? 'selected' : '' }}>Bibi</option>
                                <option value="Kakak" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Kakak' ? 'selected' : '' }}>Kakak</option>
                                <option value="Lainnya" {{ old('hubungan_dengan_anak', $spmb->hubungan_dengan_anak) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                   value="{{ old('nik_wali', $spmb->nik_wali) }}"
                                   pattern="[0-9]{16}"
                                   maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tempat Lahir Wali -->
                        <div>
                            <label for="tempat_lahir_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir Wali
                            </label>
                            <input type="text" 
                                   id="tempat_lahir_wali"
                                   name="tempat_lahir_wali" 
                                   value="{{ old('tempat_lahir_wali', $spmb->tempat_lahir_wali) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tanggal Lahir Wali -->
                        <div>
                            <label for="tanggal_lahir_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir Wali
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir_wali"
                                   name="tanggal_lahir_wali" 
                                   value="{{ old('tanggal_lahir_wali', $spmb->tanggal_lahir_wali instanceof \Carbon\Carbon ? $spmb->tanggal_lahir_wali->format('Y-m-d') : $spmb->tanggal_lahir_wali) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pendidikan Wali -->
                        <div>
                            <label for="pendidikan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendidikan Wali
                            </label>
                            <select id="pendidikan_wali" 
                                    name="pendidikan_wali" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak Sekolah" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D1-D3" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'D1-D3' ? 'selected' : '' }}>D1-D3</option>
                                <option value="S1" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_wali', $spmb->pendidikan_wali) == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>

                        <!-- Pekerjaan Wali -->
                        <div>
                            <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Pekerjaan Wali
                            </label>
                            <input type="text" 
                                   id="pekerjaan_wali"
                                   name="pekerjaan_wali" 
                                   value="{{ old('pekerjaan_wali', $spmb->pekerjaan_wali) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Bidang Pekerjaan Wali -->
                        <div>
                            <label for="bidang_pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Pekerjaan
                            </label>
                            <input type="text" 
                                   id="bidang_pekerjaan_wali"
                                   name="bidang_pekerjaan_wali" 
                                   value="{{ old('bidang_pekerjaan_wali', $spmb->bidang_pekerjaan_wali) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Penghasilan Wali -->
                        <div>
                            <label for="penghasilan_per_bulan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan per Bulan
                            </label>
                            <select id="penghasilan_per_bulan_wali" 
                                    name="penghasilan_per_bulan_wali" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Penghasilan</option>
                                <option value="< 1 juta" {{ old('penghasilan_per_bulan_wali', $spmb->penghasilan_per_bulan_wali) == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                <option value="1-3 juta" {{ old('penghasilan_per_bulan_wali', $spmb->penghasilan_per_bulan_wali) == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                <option value="3-5 juta" {{ old('penghasilan_per_bulan_wali', $spmb->penghasilan_per_bulan_wali) == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                <option value="5-10 juta" {{ old('penghasilan_per_bulan_wali', $spmb->penghasilan_per_bulan_wali) == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                <option value="> 10 juta" {{ old('penghasilan_per_bulan_wali', $spmb->penghasilan_per_bulan_wali) == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                            </select>
                        </div>

                        <!-- No Telepon Wali -->
                        <div>
                            <label for="nomor_telepon_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon/WA Wali
                            </label>
                            <input type="tel" 
                                   id="nomor_telepon_wali"
                                   name="nomor_telepon_wali" 
                                   value="{{ old('nomor_telepon_wali', $spmb->nomor_telepon_wali) }}"
                                   pattern="[0-9]{10,15}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email Wali -->
                        <div>
                            <label for="email_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Wali
                            </label>
                            <input type="email" 
                                   id="email_wali"
                                   name="email_wali" 
                                   value="{{ old('email_wali', $spmb->email_wali) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-orange-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Informasi Tambahan</h4>
                            <p class="text-sm text-gray-600">Informasi seputar pendaftaran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun Ajaran -->
                        <div>
                            <label for="tahun_ajaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran *
                            </label>
                            <select id="tahun_ajaran_id" 
                                    name="tahun_ajaran_id" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tahun_ajaran_id') border-red-500 @enderror">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $spmb->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Daftar -->
                        <div>
                            <label for="jenis_daftar" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Pendaftaran *
                            </label>
                            <select id="jenis_daftar" 
                                    name="jenis_daftar" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_daftar') border-red-500 @enderror">
                                <option value="">Pilih Jenis</option>
                                <option value="Siswa Baru" {{ old('jenis_daftar', $spmb->jenis_daftar) == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                                <option value="Pindahan" {{ old('jenis_daftar', $spmb->jenis_daftar) == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                            </select>
                            @error('jenis_daftar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sumber Informasi -->
                        <div>
                            <label for="sumber_informasi_ppdb" class="block text-sm font-medium text-gray-700 mb-2">
                                Sumber Informasi PPDB
                            </label>
                            <select id="sumber_informasi_ppdb" 
                                    name="sumber_informasi_ppdb" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Sumber</option>
                                <option value="Media Sosial" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Media Sosial' ? 'selected' : '' }}>Media Sosial</option>
                                <option value="Website Sekolah" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Website Sekolah' ? 'selected' : '' }}>Website Sekolah</option>
                                <option value="Spanduk/Baliho" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Spanduk/Baliho' ? 'selected' : '' }}>Spanduk/Baliho</option>
                                <option value="Teman/Keluarga" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Teman/Keluarga' ? 'selected' : '' }}>Teman/Keluarga</option>
                                <option value="Guru" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Lainnya" {{ old('sumber_informasi_ppdb', $spmb->sumber_informasi_ppdb) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Punya Saudara Sekolah TK -->
                        <div class="flex items-center mt-4">
                            <input type="checkbox" 
                                   id="punya_saudara_sekolah_tk" 
                                   name="punya_saudara_sekolah_tk" 
                                   value="1"
                                   {{ old('punya_saudara_sekolah_tk', $spmb->punya_saudara_sekolah_tk) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="punya_saudara_sekolah_tk" class="ml-2 text-sm text-gray-700">
                                Apakah anak memiliki saudara yang bersekolah di TK ini?
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Status Pendaftaran -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flag-checkered text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Status Pendaftaran</h4>
                            <p class="text-sm text-gray-600">Atur status pendaftaran dan verifikasi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status Pendaftaran -->
                        <div>
                            <label for="status_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Pendaftaran *    
                            </label>
                            <select id="status_pendaftaran" 
                                    name="status_pendaftaran" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status_pendaftaran') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="Menunggu Verifikasi" {{ old('status_pendaftaran', $spmb->status_pendaftaran) == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="Diterima" {{ old('status_pendaftaran', $spmb->status_pendaftaran) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Mundur" {{ old('status_pendaftaran', $spmb->status_pendaftaran) == 'Mundur' ? 'selected' : '' }}>Mundur</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Status akan menentukan proses selanjutnya</p>
                            @error('status_pendaftaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        
                        <a href="{{ route('admin.spmb.show', $spmb) }}" 
                           class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-4 px-6 rounded-lg text-center transition duration-300">
                            Batal
                        </a>
                    </div>
                    
                    <!-- Warning konversi status -->
                    <div id="autoConvertWarning" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-yellow-800">Perhatian!</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Jika status diubah menjadi "Diterima", data akan <strong>otomatis dikonversi menjadi data siswa</strong>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Warning jika sudah ada siswa -->
                    @if($spmb->siswa)
                    <div id="existingSiswaWarning" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-blue-800">Informasi</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Data ini sudah dikonversi menjadi data siswa. 
                                    <a href="{{ route('admin.siswa.siswa-aktif.show', $spmb->siswa) }}" class="font-medium underline hover:text-blue-900">
                                        Lihat data siswa
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menghitung usia
    function hitungUsia(tanggalLahir) {
        const birthDate = new Date(tanggalLahir);
        const today = new Date();
        
        // Validasi: tanggal tidak boleh lebih dari hari ini
        if (birthDate > today) {
            alert('Tanggal lahir tidak boleh lebih dari hari ini');
            document.getElementById('tanggal_lahir_anak').value = '';
            document.getElementById('ageDisplay').textContent = '';
            return;
        }
        
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        const ageDisplay = document.getElementById('ageDisplay');
        
        if (age > 0) {
            // Tampilkan usia
            ageDisplay.textContent = `Usia: ${age} tahun`;
            
            // Peringatan jika usia tidak sesuai untuk TK
            if (age < 3) {
                ageDisplay.innerHTML += ' <span class="text-red-500">(Di bawah usia minimal TK: 3 tahun)</span>';
            } else if (age > 6) {
                ageDisplay.innerHTML += ' <span class="text-orange-500">(Di atas usia maksimal TK: 6 tahun)</span>';
            } else if (age >= 3 && age <= 4) {
                ageDisplay.innerHTML += ' <span class="text-green-500">(Usia cocok untuk Kelompok A)</span>';
            } else if (age >= 5 && age <= 6) {
                ageDisplay.innerHTML += ' <span class="text-blue-500">(Usia cocok untuk Kelompok B)</span>';
            }
        } else {
            ageDisplay.textContent = '';
        }
    }
    
    // Event listener untuk tanggal lahir
    document.getElementById('tanggal_lahir_anak').addEventListener('change', function() {
        hitungUsia(this.value);
    });
    
    // Toggle alamat KK
    document.getElementById('alamat_kk_sama').addEventListener('change', function() {
        const container = document.getElementById('alamatKKContainer');
        if (this.checked) {
            container.classList.add('hidden');
        } else {
            container.classList.remove('hidden');
        }
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
    
    // Validasi NIK
    function validasiNIK(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 16) {
            input.value = input.value.substring(0, 16);
        }
    }
    
    // Event listener untuk semua field NIK
    const nikInputs = ['nik_anak', 'nik_ayah', 'nik_ibu', 'nik_wali'];
    nikInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                validasiNIK(this);
            });
        }
    });
    
    // Validasi nomor telepon
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    
    // Tampilkan peringatan jika status dipilih "Diterima"
    const statusSelect = document.getElementById('status_pendaftaran');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            const warningDiv = document.getElementById('autoConvertWarning');
            if (this.value === 'Diterima') {
                warningDiv.classList.remove('hidden');
            } else {
                warningDiv.classList.add('hidden');
            }
        });
    }
    
    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Set max date untuk tanggal lahir
        const today = new Date().toISOString().split('T')[0];
        const tanggalLahirInput = document.getElementById('tanggal_lahir_anak');
        if (tanggalLahirInput) {
            tanggalLahirInput.max = today;
        }
        
        // Cek status
        if (statusSelect && statusSelect.value === 'Diterima') {
            const warningDiv = document.getElementById('autoConvertWarning');
            if (warningDiv) warningDiv.classList.remove('hidden');
        }
        
        // Hitung usia jika tanggal lahir sudah diisi
        if (tanggalLahirInput && tanggalLahirInput.value) {
            hitungUsia(tanggalLahirInput.value);
        }
        
        // Validasi ukuran file untuk semua input file
        const maxSize = 2 * 1024 * 1024;
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validasi ukuran
                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Validasi tipe file
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak valid. Hanya boleh JPEG, PNG, JPG, atau PDF.');
                        this.value = '';
                        return;
                    }
                }
            });
        });
    });
</script>
@endpush