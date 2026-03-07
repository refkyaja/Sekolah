{{-- resources/views/ppdb/index.blade.php --}}
@extends('layouts.ppdb')

@section('title', 'Pendaftaran PPDB - TK Ceria Bangsa')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-12 p-8 bg-white border border-stone-100 rounded-[2rem] shadow-xl">
            <div class="flex items-center gap-6">
                <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-widest text-brand-dark">{{ session('success') }}</p>
                    @if(session('no_pendaftaran'))
                    <p class="text-[10px] font-bold text-stone-400 mt-2 uppercase tracking-tight">
                        Simpan nomor pendaftaran: {{ session('no_pendaftaran') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-12 p-8 bg-white border border-stone-100 rounded-[2rem] shadow-xl">
            <div class="flex items-center gap-6 mb-4">
                <div class="w-12 h-12 bg-rose-500 text-white rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation"></i>
                </div>
                <h4 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark">Terjadi kesalahan:</h4>
            </div>
            <ul class="text-[10px] font-bold text-rose-500 uppercase tracking-tight list-none ml-18">
                @foreach($errors->all() as $error)
                <li>— {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Page Header -->
        <div class="text-center mb-16">
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4 block">Pendaftaran Siswa Baru</span>
            <h1 class="text-5xl font-extrabold tracking-tight text-brand-dark mb-4">FORMULIR ONLINE</h1>
            <p class="text-stone-400 font-medium text-sm">Harapan Bangsa 1 — Tahun Ajaran 2026/2027</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200 overflow-hidden mb-12 border border-stone-50">
            <!-- Progress Bar -->
            <div class="p-12 pb-0">
                <div class="mb-4 flex justify-between items-end">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400">Langkah 1 dari 3</span>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-primary">Data Calon Siswa</span>
                </div>
                <div class="w-full bg-stone-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-brand-primary h-full rounded-full transition-all duration-1000" style="width: 33%"></div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-12">
                <form action="{{ route('spmb.store') }}" method="POST" class="space-y-12" id="ppdbForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- SECTION 1: Data Calon Siswa -->
                    <div class="space-y-12">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center font-extrabold text-lg">
                                01
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark">Data Calon Siswa</h3>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight mt-1">Informasi pribadi calon peserta didik</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-10">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Nama Lengkap <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nama_calon_siswa" required 
                                       value="{{ old('nama_calon_siswa') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="Nama Sesuai Akta Kelahiran">
                            </div>
                            
                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Jenis Kelamin <span class="text-brand-primary">*</span>
                                </label>
                                <select name="jenis_kelamin" required 
                                        class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all appearance-none">
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            
                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Tempat Lahir <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="tempat_lahir" required 
                                       value="{{ old('tempat_lahir') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="Contoh: Bandung">
                            </div>
                            
                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Tanggal Lahir <span class="text-brand-primary">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" required 
                                       id="tanggal_lahir_public"
                                       value="{{ old('tanggal_lahir') }}"
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all">
                                <div id="ageDisplayPublic" class="mt-4 text-[10px] font-bold uppercase tracking-tight text-stone-400">
                                    @if(old('tanggal_lahir'))
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                hitungUsiaDanSaranKelompokPublic('{{ old('tanggal_lahir') }}');
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>

                            <!-- Agama -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Agama <span class="text-brand-primary">*</span>
                                </label>
                                <select name="agama" required
                                        class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all appearance-none">
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
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    NIK Calon Siswa <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nik" required 
                                       value="{{ old('nik') }}"
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="16 Digit NIK">
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                Alamat Lengkap <span class="text-brand-primary">*</span>
                            </label>
                            <textarea name="alamat" rows="4" required 
                                      class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                      placeholder="Tulis alamat lengkap beserta RT/RW, Kelurahan, Kecamatan, dan Kode Pos">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Dokumen Upload -->
                        <div class="grid md:grid-cols-2 gap-10">
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">Akta Kelahiran (PDF/IMG)</label>
                                <input type="file" name="akta_kelahiran" 
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-6 py-4 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-[10px] font-bold uppercase tracking-widest file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-brand-soft file:text-brand-primary hover:file:bg-brand-primary hover:file:text-white file:transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">Kartu Keluarga (PDF/IMG)</label>
                                <input type="file" name="kartu_keluarga" 
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-6 py-4 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-[10px] font-bold uppercase tracking-widest file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-brand-soft file:text-brand-primary hover:file:bg-brand-primary hover:file:text-white file:transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: Data Orang Tua -->
                    <div class="space-y-12">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center font-extrabold text-lg">
                                02
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark">Data Orang Tua</h3>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight mt-1">Informasi ayah dan ibu kandung</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-10">
                            <!-- Nama Ayah -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Nama Ayah <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nama_ayah" required 
                                       value="{{ old('nama_ayah') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="Nama Lengkap Ayah">
                            </div>
                            
                            <!-- NIK Ayah -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    NIK Ayah <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nik_ayah" required 
                                       value="{{ old('nik_ayah') }}"
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="16 Digit NIK Ayah">
                            </div>
                            
                            <!-- Nama Ibu -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Nama Ibu <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nama_ibu" required 
                                       value="{{ old('nama_ibu') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="Nama Lengkap Ibu">
                            </div>
                            
                            <!-- No HP -->
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Nomor WhatsApp <span class="text-brand-primary">*</span>
                                </label>
                                <input type="tel" name="no_hp_ortu" required 
                                       pattern="[0-9]{10,15}"
                                       placeholder="081234567890"
                                       value="{{ old('no_hp_ortu') }}"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary text-sm font-medium outline-none transition-all">
                            </div>
                        </div>
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

                    <!-- Submit Buttons -->
                    <div class="bg-stone-50 -mx-12 -mb-12 p-12 mt-12 flex flex-col sm:flex-row gap-6">
                        <button type="submit" 
                                class="flex-1 bg-brand-dark text-white font-extrabold py-6 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-2xl">
                            Kirim Pendaftaran
                        </button>
                        
                        <button type="button" id="resetButton"
                                class="flex-1 border-2 border-stone-200 text-brand-dark font-extrabold py-6 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-stone-100">
                            Reset Formulir
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Info -->
        <div class="text-center">
            <p class="text-stone-400 text-[10px] font-bold uppercase tracking-widest leading-loose">
                Butuh Bantuan? Hubungi kami di <a href="#" class="text-brand-dark hover:text-brand-primary transition-colors">info@harapanbangsa.sch.id</a><br>
                Senin - Jumat: 08:00 — 15:00
            </p>
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