{{-- resources/views/admin/ppdb/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Data PPDB')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-edit mr-2"></i>Edit Data PPDB
                </h1>
                <p class="text-gray-600 mt-2">Edit data pendaftaran No: {{ $ppdb->no_pendaftaran ?? '-' }}</p>
            </div>
            <a href="{{ route('admin.ppdb.show', $ppdb) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Formulir Edit Pendaftaran</h3>
            <p class="text-sm text-gray-600">Edit data calon siswa dan orang tua</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.ppdb.update', $ppdb) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

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
                                Nama Lengkap Calon Peserta Didik Baru *
                            </label>
                            <input type="text" 
                                   id="nama_calon_siswa"
                                   name="nama_calon_siswa" 
                                   value="{{ old('nama_calon_siswa', $ppdb->nama_calon_siswa) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_calon_siswa') border-red-500 @enderror">
                            @error('nama_calon_siswa')
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
                                   value="{{ old('tempat_lahir', $ppdb->tempat_lahir) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tanggal Lahir - FIXED VERSION -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir *
                            </label>
                            <input type="date" 
                                   id="tanggal_lahir"
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir', $ppdb->tanggal_lahir) }}" <!-- PAKAI VERSI AMAN -->
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div id="ageDisplay" class="mt-1 text-sm text-gray-600">
                                @if($ppdb->tanggal_lahir)
                                    @php
                                        try {
                                            $age = \Carbon\Carbon::parse($ppdb->tanggal_lahir)->age;
                                            echo "Usia: {$age} tahun";
                                            if($age < 3 || $age > 6) {
                                                echo ' <span class="text-red-500">(Di luar rentang usia TK: 3-6 tahun)</span>';
                                            } elseif($age >= 3 && $age <= 4) {
                                                echo ' <span class="text-green-500">(Usia cocok untuk Kelompok A)</span>';
                                            } elseif($age >= 5 && $age <= 6) {
                                                echo ' <span class="text-blue-500">(Usia cocok untuk Kelompok B)</span>';
                                            }
                                        } catch (\Exception $e) {
                                            echo '<span class="text-yellow-600">Format tanggal tidak valid</span>';
                                        }
                                    @endphp
                                @endif
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin *
                            </label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="jenis_kelamin" 
                                           value="L" 
                                           class="h-4 w-4 text-blue-600 border-gray-300"
                                           {{ old('jenis_kelamin', $ppdb->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                           required>
                                    <span class="ml-2">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="jenis_kelamin" 
                                           value="P" 
                                           class="h-4 w-4 text-blue-600 border-gray-300"
                                           {{ old('jenis_kelamin', $ppdb->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                           required>
                                    <span class="ml-2">Perempuan</span>
                                </label>
                            </div>
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
                                <option value="Islam" {{ old('agama', $ppdb->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $ppdb->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama', $ppdb->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $ppdb->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $ppdb->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $ppdb->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
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
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $ppdb->alamat) }}</textarea>
                        @error('alamat')
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
                                   value="{{ old('nama_ayah', $ppdb->nama_ayah) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                <option value="Wiraswasta" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="PNS" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="Karyawan Swasta" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                <option value="Petani" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                <option value="Nelayan" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                <option value="Buruh" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                <option value="Dokter" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                                <option value="Guru" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Lainnya" {{ old('pekerjaan_ayah', $ppdb->pekerjaan_ayah) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                   value="{{ old('nama_ibu', $ppdb->nama_ibu) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                                <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                <option value="Wiraswasta" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="PNS" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="Karyawan Swasta" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                <option value="Guru" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Perawat" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                                <option value="Lainnya" {{ old('pekerjaan_ibu', $ppdb->pekerjaan_ibu) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- No HP Orang Tua -->
                        <div>
                            <label for="no_hp_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP/WhatsApp Orang Tua *
                            </label>
                            <input type="tel" 
                                   id="no_hp_ortu"
                                   name="no_hp_ortu" 
                                   value="{{ old('no_hp_ortu', $ppdb->no_hp_ortu) }}"
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Email Orang Tua -->
                        <div>
                            <label for="email_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Orang Tua
                            </label>
                            <input type="email" 
                                   id="email_ortu"
                                   name="email_ortu" 
                                   value="{{ old('email_ortu', $ppdb->email_ortu) }}"
                                   placeholder="orangtua@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Pilihan Program -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Pilihan Program</h4>
                            <p class="text-sm text-gray-600">Program dan jalur pendaftaran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pilihan Kelompok -->
                        <div>
                            <label for="pilihan_kelompok" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilihan Kelompok *
                            </label>
                            <select id="pilihan_kelompok" 
                                    name="pilihan_kelompok" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kelompok</option>
                                <option value="A" {{ old('pilihan_kelompok', $ppdb->pilihan_kelompok) == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                <option value="B" {{ old('pilihan_kelompok', $ppdb->pilihan_kelompok) == 'B' ? 'selected' : '' }}>Kelompok B</option>
                            </select>
                        </div>

                        <!-- Jalur Pendaftaran -->
                        <div>
                            <label for="jalur_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Jalur Pendaftaran *
                            </label>
                            <select id="jalur_pendaftaran" 
                                    name="jalur_pendaftaran" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jalur</option>
                                <option value="reguler" {{ old('jalur_pendaftaran', $ppdb->jalur_pendaftaran) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="prestasi" {{ old('jalur_pendaftaran', $ppdb->jalur_pendaftaran) == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="afirmasi" {{ old('jalur_pendaftaran', $ppdb->jalur_pendaftaran) == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                            </select>
                        </div>

                        <!-- Status Pendaftaran -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Pendaftaran *
                            </label>
                            <select id="status" 
                                    name="status" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="menunggu" {{ old('status', $ppdb->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="diproses" {{ old('status', $ppdb->status) == 'diproses' ? 'selected' : '' }}>Dokumen Verified</option>
                                <option value="diterima" {{ old('status', $ppdb->status) == 'diterima' ? 'selected' : '' }}>Lulus</option>
                                <option value="ditolak" {{ old('status', $ppdb->status) == 'ditolak' ? 'selected' : '' }}>Tidak Lulus</option>
                                <option value="cadangan" {{ old('status', $ppdb->status) == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                            </select>
                        </div>

                        <!-- Status Pembayaran -->
                        <div>
                            <label for="status_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Pembayaran *
                            </label>
                            <select id="status_pembayaran" 
                                    name="status_pembayaran" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="belum" {{ old('status_pembayaran', $ppdb->status_pembayaran) == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                                <option value="pending" {{ old('status_pembayaran', $ppdb->status_pembayaran) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="lunas" {{ old('status_pembayaran', $ppdb->status_pembayaran) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                        </div>
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
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan_khusus', $ppdb->catatan_khusus) }}</textarea>
                    </div>

                    <!-- Catatan Admin -->
                    <div>
                        <label for="catatan_admin" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Admin (Opsional)
                        </label>
                        <textarea id="catatan_admin" 
                                  name="catatan_admin" 
                                  rows="2"
                                  placeholder="Catatan internal untuk admin"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan_admin', $ppdb->catatan_admin) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Catatan ini hanya bisa dilihat oleh admin</p>
                    </div>

                    <!-- Upload Files Section with PREVIEW -->
                    <div class="space-y-4">
                        <h5 class="font-medium text-gray-800">File Upload</h5>
                        <p class="text-sm text-gray-600 mb-3">Unggah file baru untuk mengganti file yang ada</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Foto Calon Siswa -->
                            <div>
                                <label for="foto_calon_siswa" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Calon Siswa
                                </label>
                                <input type="file" 
                                       id="foto_calon_siswa"
                                       name="foto_calon_siswa" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @if($ppdb->foto_calon_siswa)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600 mb-1">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            File sudah diupload: {{ basename($ppdb->foto_calon_siswa) }}
                                        </p>
                                        <!-- PREVIEW FOTO -->
                                        <img src="{{ asset('storage/' . $ppdb->foto_calon_siswa) }}"
                                             class="h-32 w-32 object-cover rounded-lg border border-gray-300 mt-2"
                                             alt="Foto Calon Siswa"
                                             onerror="this.style.display='none'">
                                    </div>
                                @endif
                            </div>

                            <!-- Foto KK -->
                            <div>
                                <label for="foto_kk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Kartu Keluarga
                                </label>
                                <input type="file" 
                                       id="foto_kk"
                                       name="foto_kk" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @if($ppdb->foto_kk)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            File sudah diupload: {{ basename($ppdb->foto_kk) }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Foto Akta Lahir -->
                            <div>
                                <label for="foto_akta_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Akta Lahir
                                </label>
                                <input type="file" 
                                       id="foto_akta_lahir"
                                       name="foto_akta_lahir" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @if($ppdb->foto_akta_lahir)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            File sudah diupload: {{ basename($ppdb->foto_akta_lahir) }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div>
                                <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bukti Pembayaran
                                </label>
                                <input type="file" 
                                       id="bukti_pembayaran"
                                       name="bukti_pembayaran" 
                                       accept="image/*"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @if($ppdb->bukti_pembayaran)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            File sudah diupload: {{ basename($ppdb->bukti_pembayaran) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
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
                        
                        <a href="{{ route('admin.ppdb.show', $ppdb) }}" 
                           class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-4 px-6 rounded-lg text-center transition duration-300">
                            Batal
                        </a>
                    </div>
                    
                    <!-- Warning jika sudah ada siswa -->
                    @php
                        $existingSiswa = $ppdb->siswa ?? null;
                    @endphp
                    @if($existingSiswa)
                    <div id="existingSiswaWarning" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-medium text-yellow-800">Perhatian!</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Data ini sudah dikonversi menjadi data siswa. 
                                    <a href="{{ route('admin.siswa.show', $existingSiswa) }}" class="font-medium underline hover:text-yellow-900">
                                        Lihat data siswa
                                    </a>
                                </p>
                                <p class="text-sm text-yellow-700 mt-2">
                                    Perubahan pada data PPDB tidak akan otomatis mengupdate data siswa.
                                    Anda perlu mengedit data siswa secara terpisah.
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
    // Hitung dan tampilkan usia saat tanggal berubah
    document.getElementById('tanggal_lahir').addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        
        // Validasi: tanggal tidak boleh lebih dari hari ini
        if (birthDate > today) {
            alert('Tanggal lahir tidak boleh lebih dari hari ini');
            this.value = '';
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
            ageDisplay.textContent = `Usia: ${age} tahun`;
            
            // Peringatan jika usia tidak sesuai untuk TK
            if (age < 3 || age > 6) {
                ageDisplay.className = 'mt-1 text-sm text-red-600 font-medium';
                ageDisplay.innerHTML += ' <span class="text-red-500">(Di luar rentang usia TK: 3-6 tahun)</span>';
            } else if (age >= 3 && age <= 4) {
                ageDisplay.className = 'mt-1 text-sm text-green-600 font-medium';
                ageDisplay.innerHTML += ' <span class="text-green-500">(Usia cocok untuk Kelompok A)</span>';
            } else if (age >= 5 && age <= 6) {
                ageDisplay.className = 'mt-1 text-sm text-blue-600 font-medium';
                ageDisplay.innerHTML += ' <span class="text-blue-500">(Usia cocok untuk Kelompok B)</span>';
            }
        } else {
            ageDisplay.textContent = '';
        }
    });
    
    // Validasi nomor telepon
    document.getElementById('no_hp_ortu').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Set tanggal maksimal hari ini untuk tanggal lahir
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const tanggalLahirInput = document.getElementById('tanggal_lahir');
        tanggalLahirInput.max = today;
        
        // Trigger perhitungan usia jika tanggal lahir sudah ada
        if (tanggalLahirInput.value) {
            tanggalLahirInput.dispatchEvent(new Event('change'));
        }
        
        // File size validation (2MB)
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
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak valid. Hanya boleh JPEG, PNG, JPG, atau GIF.');
                        this.value = '';
                        return;
                    }
                    
                    // Preview untuk foto calon siswa
                    if (this.id === 'foto_calon_siswa') {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Tampilkan preview baru
                            const previewContainer = document.createElement('div');
                            previewContainer.className = 'mt-2';
                            previewContainer.innerHTML = `
                                <p class="text-sm text-blue-600 mb-1">
                                    <i class="fas fa-eye mr-1"></i>Preview:
                                </p>
                                <img src="${e.target.result}" 
                                     class="h-32 w-32 object-cover rounded-lg border border-gray-300"
                                     alt="Preview Foto Baru">
                            `;
                            
                            // Hapus preview lama jika ada
                            const oldPreview = input.parentNode.querySelector('.preview-container');
                            if (oldPreview) oldPreview.remove();
                            
                            previewContainer.className = 'preview-container mt-2';
                            input.parentNode.appendChild(previewContainer);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    });
</script>
@endpush