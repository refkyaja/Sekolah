@extends('layouts.siswa')

@section('title', 'Formulir Pendaftaran PPDB')

@push('styles')
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
        height: auto;
    }
    input:disabled, select:disabled, textarea:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background-color: rgba(241, 245, 249, 0.5) !important;
    }
</style>
@endpush

@section('content')
@php
    $isReadOnly = isset($readOnly) && $readOnly;
    $data = $spmb ?? null;
@endphp

<div class="p-4 lg:p-8 max-w-5xl mx-auto w-full">
    <div class="mb-10">
        <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white uppercase text-center md:text-left">
            {{ $isReadOnly ? 'Data Pendaftaran' : 'Formulir Pendaftaran' }}
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg text-center md:text-left">
            {{ $isReadOnly ? 'Berikut adalah data pendaftaran Anda yang telah tersimpan.' : 'Lengkapi data diri Anda dengan benar untuk proses registrasi siswa baru.' }}
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800">
            <div class="flex items-center gap-3 mb-4 text-red-600 dark:text-red-400">
                <span class="material-symbols-outlined">error</span>
                <h3 class="font-bold">Terjadi Kesalahan!</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10 pb-20">
        @csrf

        <!-- Section 1: Data Pribadi -->
        <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
            
            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4 relative z-10">
                <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined !text-2xl">person</span>
                </div>
                <div>
                    <h3 class="text-xl font-black tracking-tight uppercase">Identitas Calon Siswa</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Informasi Utama</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Anak *</label>
                    <input type="text" name="nama_lengkap_anak" value="{{ old('nama_lengkap_anak', $data->nama_lengkap_anak ?? $siswa->nama_lengkap ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           placeholder="Nama sesuai akta kelahiran"
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan_anak" value="{{ old('nama_panggilan_anak', $data->nama_panggilan_anak ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                           placeholder="Nama panggilan sehari-hari"
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">NIK Anak *</label>
                    <input type="text" id="nik_anak" name="nik_anak" value="{{ old('nik_anak', $data->nik_anak ?? $siswa->nik ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} maxlength="20"
                           placeholder="Masukkan NIK"
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tempat Lahir *</label>
                    <input type="text" name="tempat_lahir_anak" value="{{ old('tempat_lahir_anak', $data->tempat_lahir_anak ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           placeholder="Kota/kabupaten"
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Lahir *</label>
                    <div class="relative">
                        <input type="date" name="tanggal_lahir_anak" value="{{ old('tanggal_lahir_anak', $data->tanggal_lahir_anak ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium uppercase">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" {{ $isReadOnly ? 'disabled' : 'required' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $data->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Agama *</label>
                    <select name="agama" {{ $isReadOnly ? 'disabled' : 'required' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-medium">
                        <option value="">Pilih Agama</option>
                        @foreach(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agm)
                            <option value="{{ $agm }}" {{ old('agama', $data->agama ?? '') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Anak Ke *</label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke', $data->anak_ke ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} min="1"
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Gol. Darah</label>
                        <select name="golongan_darah" {{ $isReadOnly ? 'disabled' : '' }}
                                class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">-</option>
                            @foreach(['A', 'B', 'AB', 'O'] as $goldar)
                                <option value="{{ $goldar }}" {{ old('golongan_darah', $data->golongan_darah ?? '') == $goldar ? 'selected' : '' }}>{{ $goldar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tinggal Bersama *</label>
                    <select name="tinggal_bersama" {{ $isReadOnly ? 'disabled' : 'required' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <option value="">Pilih</option>
                        @foreach(['Ayah dan Ibu', 'Ayah', 'Ibu', 'Keluarga Ayah', 'Keluarga Ibu', 'Lainnya'] as $tb)
                            <option value="{{ $tb }}" {{ old('tinggal_bersama', $data->tinggal_bersama ?? '') == $tb ? 'selected' : '' }}>{{ $tb }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Tpt Tinggal *</label>
                    <select name="status_tempat_tinggal" {{ $isReadOnly ? 'disabled' : 'required' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <option value="">Pilih</option>
                        @foreach(['Milik Sendiri', 'Milik Keluarga', 'Kontrakan'] as $stt)
                            <option value="{{ $stt }}" {{ old('status_tempat_tinggal', $data->status_tempat_tinggal ?? '') == $stt ? 'selected' : '' }}>{{ $stt }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Berat (kg)</label>
                        <input type="number" name="berat_badan" value="{{ old('berat_badan', $data->berat_badan ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} step="0.1"
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tinggi (cm)</label>
                        <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $data->tinggi_badan ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} step="0.1"
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Bahasa Sehari-hari *</label>
                    <input type="text" name="bahasa_sehari_hari" value="{{ old('bahasa_sehari_hari', $data->bahasa_sehari_hari ?? 'Indonesia') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jarak (meter)</label>
                        <input type="number" name="jarak_rumah_ke_sekolah" value="{{ old('jarak_rumah_ke_sekolah', $data->jarak_rumah_ke_sekolah ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Waktu (menit)</label>
                        <input type="number" name="waktu_tempuh_ke_sekolah" value="{{ old('waktu_tempuh_ke_sekolah', $data->waktu_tempuh_ke_sekolah ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Penyakit Diderita</label>
                    <textarea name="penyakit_pernah_diderita" rows="2" {{ $isReadOnly ? 'disabled' : '' }}
                              class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">{{ old('penyakit_pernah_diderita', $data->penyakit_pernah_diderita ?? '') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Imunisasi Diterima</label>
                    <textarea name="imunisasi_pernah_diterima" rows="2" {{ $isReadOnly ? 'disabled' : '' }}
                              class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">{{ old('imunisasi_pernah_diterima', $data->imunisasi_pernah_diterima ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <!-- Section 2: Alamat Rumah -->
        <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 relative">
            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="size-11 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-600">
                    <span class="material-symbols-outlined !text-2xl">location_on</span>
                </div>
                <div>
                    <h3 class="text-xl font-black tracking-tight uppercase">Alamat Domisili</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Tempat Tinggal Saat Ini</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Provinsi *</label>
                    <input type="text" name="provinsi_rumah" value="{{ old('provinsi_rumah', $data->provinsi_rumah ?? 'Jawa Barat') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kota / Kabupaten *</label>
                    <input type="text" name="kota_kabupaten_rumah" value="{{ old('kota_kabupaten_rumah', $data->kota_kabupaten_rumah ?? 'Kota Bandung') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kecamatan *</label>
                    <input type="text" name="kecamatan_rumah" value="{{ old('kecamatan_rumah', $data->kecamatan_rumah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kelurahan *</label>
                    <input type="text" name="kelurahan_rumah" value="{{ old('kelurahan_rumah', $data->kelurahan_rumah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Detail Alamat *</label>
                    <textarea name="nama_jalan_rumah" rows="2" {{ $isReadOnly ? 'disabled' : 'required' }}
                              placeholder="Contoh: Jl. Terusan PSM No. 1A, RT 01 RW 02"
                              class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">{{ old('nama_jalan_rumah', $data->nama_jalan_rumah ?? '') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" id="alamat_kk_sama" name="alamat_kk_sama" value="1" {{ old('alamat_kk_sama', $data->alamat_kk_sama ?? true) ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}
                               class="size-5 text-primary border-slate-300 rounded-lg focus:ring-primary">
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-400">Alamat di Kartu Keluarga (KK) sama dengan alamat di atas</span>
                    </label>
                </div>
            </div>

            <!-- Alamat KK Container -->
            <div id="alamatKKContainer" class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10 {{ old('alamat_kk_sama', $data->alamat_kk_sama ?? true) ? 'hidden' : '' }}">
                <div class="md:col-span-2 border-t border-slate-100 dark:border-slate-800 pt-6">
                    <p class="text-xs font-black text-primary uppercase tracking-widest mb-4">Alamat Sesuai Kartu Keluarga (KK)</p>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Provinsi (KK)</label>
                    <input type="text" name="provinsi_kk" value="{{ old('provinsi_kk', $data->provinsi_kk ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kota / Kab (KK)</label>
                    <input type="text" name="kota_kabupaten_kk" value="{{ old('kota_kabupaten_kk', $data->kota_kabupaten_kk ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kecamatan (KK)</label>
                    <input type="text" name="kecamatan_kk" value="{{ old('kecamatan_kk', $data->kecamatan_kk ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kelurahan (KK)</label>
                    <input type="text" name="kelurahan_kk" value="{{ old('kelurahan_kk', $data->kelurahan_kk ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                           class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Detail Alamat (KK)</label>
                    <textarea name="nama_jalan_kk" rows="2" {{ $isReadOnly ? 'disabled' : '' }}
                              class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">{{ old('nama_jalan_kk', $data->nama_jalan_kk ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <!-- Section 3: Data Orang Tua -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Data Ayah -->
            <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="size-11 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-600">
                        <span class="material-symbols-outlined">man</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight uppercase">Data Ayah</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Informasi Ayah</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Nama Lengkap Ayah *</label>
                        <input type="text" name="nama_lengkap_ayah" value="{{ old('nama_lengkap_ayah', $data->nama_lengkap_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">NIK Ayah *</label>
                        <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $data->nik_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} maxlength="20" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Tpt Lahir *</label>
                            <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah', $data->tempat_lahir_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Tgl Lahir *</label>
                            <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah', $data->tanggal_lahir_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Pendidikan</label>
                        <select name="pendidikan_ayah" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $pdk)
                                <option value="{{ $pdk }}" {{ old('pendidikan_ayah', $data->pendidikan_ayah ?? '') == $pdk ? 'selected' : '' }}>{{ $pdk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Pekerjaan</label>
                        <select name="pekerjaan_ayah" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'] as $pkj)
                                <option value="{{ $pkj }}" {{ old('pekerjaan_ayah', $data->pekerjaan_ayah ?? '') == $pkj ? 'selected' : '' }}>{{ $pkj }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Penghasilan / Bulan</label>
                        <select name="penghasilan_per_bulan_ayah" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Penghasilan</option>
                            <option value="< 1 juta" {{ old('penghasilan_per_bulan_ayah', $data->penghasilan_per_bulan_ayah ?? '') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="1-3 juta" {{ old('penghasilan_per_bulan_ayah', $data->penghasilan_per_bulan_ayah ?? '') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                            <option value="3-5 juta" {{ old('penghasilan_per_bulan_ayah', $data->penghasilan_per_bulan_ayah ?? '') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                            <option value="5-10 juta" {{ old('penghasilan_per_bulan_ayah', $data->penghasilan_per_bulan_ayah ?? '') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                            <option value="> 10 juta" {{ old('penghasilan_per_bulan_ayah', $data->penghasilan_per_bulan_ayah ?? '') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">No. Telepon / WA *</label>
                        <input type="tel" name="nomor_telepon_ayah" value="{{ old('nomor_telepon_ayah', $data->nomor_telepon_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Email</label>
                        <input type="email" name="email_ayah" value="{{ old('email_ayah', $data->email_ayah ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} placeholder="ayah@email.com" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                </div>
            </section>

            <!-- Data Ibu -->
            <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="size-11 bg-pink-500/10 rounded-xl flex items-center justify-center text-pink-600">
                        <span class="material-symbols-outlined">woman</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight uppercase">Data Ibu</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Informasi Ibu</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Nama Lengkap Ibu *</label>
                        <input type="text" name="nama_lengkap_ibu" value="{{ old('nama_lengkap_ibu', $data->nama_lengkap_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">NIK Ibu *</label>
                        <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $data->nik_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} maxlength="20" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Tpt Lahir *</label>
                            <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu', $data->tempat_lahir_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Tgl Lahir *</label>
                            <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu', $data->tanggal_lahir_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Pendidikan</label>
                        <select name="pendidikan_ibu" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $pdk)
                                <option value="{{ $pdk }}" {{ old('pendidikan_ibu', $data->pendidikan_ibu ?? '') == $pdk ? 'selected' : '' }}>{{ $pdk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Pekerjaan</label>
                        <select name="pekerjaan_ibu" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['Ibu Rumah Tangga', 'Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'] as $pkj)
                                <option value="{{ $pkj }}" {{ old('pekerjaan_ibu', $data->pekerjaan_ibu ?? '') == $pkj ? 'selected' : '' }}>{{ $pkj }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Penghasilan / Bulan</label>
                        <select name="penghasilan_per_bulan_ibu" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Penghasilan</option>
                            <option value="< 1 juta" {{ old('penghasilan_per_bulan_ibu', $data->penghasilan_per_bulan_ibu ?? '') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="1-3 juta" {{ old('penghasilan_per_bulan_ibu', $data->penghasilan_per_bulan_ibu ?? '') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                            <option value="3-5 juta" {{ old('penghasilan_per_bulan_ibu', $data->penghasilan_per_bulan_ibu ?? '') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                            <option value="5-10 juta" {{ old('penghasilan_per_bulan_ibu', $data->penghasilan_per_bulan_ibu ?? '') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                            <option value="> 10 juta" {{ old('penghasilan_per_bulan_ibu', $data->penghasilan_per_bulan_ibu ?? '') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">No. Telepon / WA *</label>
                        <input type="tel" name="nomor_telepon_ibu" value="{{ old('nomor_telepon_ibu', $data->nomor_telepon_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : 'required' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-widest">Email</label>
                        <input type="email" name="email_ibu" value="{{ old('email_ibu', $data->email_ibu ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} placeholder="ibu@email.com" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                </div>
            </section>
        </div>

        <!-- Section 4: Data Wali -->
        <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 relative">
            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="size-11 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-600">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div>
                    <h3 class="text-xl font-black tracking-tight uppercase">Data Wali</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Optional - Jika Anak Tinggal Dengan Wali</p>
                </div>
            </div>

            <div class="relative z-10">
                <label class="flex items-center gap-3 cursor-pointer mb-8">
                    <input type="checkbox" id="punya_wali" name="punya_wali" value="1" {{ old('punya_wali', $data->punya_wali ?? false) ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}
                           class="size-5 text-primary border-slate-300 rounded-lg focus:ring-primary">
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest">Memiliki Wali Murid</span>
                </label>

                <div id="dataWaliContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ old('punya_wali', $data->punya_wali ?? false) ? '' : 'hidden' }}">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Wali</label>
                        <input type="text" name="nama_lengkap_wali" value="{{ old('nama_lengkap_wali', $data->nama_lengkap_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }}
                               class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Hubungan Dgn Anak</label>
                        <select name="hubungan_dengan_anak" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Hubungan</option>
                            @foreach(['Kakek', 'Nenek', 'Paman', 'Bibi', 'Kakak', 'Lainnya'] as $hub)
                                <option value="{{ $hub }}" {{ old('hubungan_dengan_anak', $data->hubungan_dengan_anak ?? '') == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">NIK Wali</label>
                        <input type="text" name="nik_wali" value="{{ old('nik_wali', $data->nik_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} maxlength="20" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tpt Lahir</label>
                            <input type="text" name="tempat_lahir_wali" value="{{ old('tempat_lahir_wali', $data->tempat_lahir_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tgl Lahir</label>
                            <input type="date" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali', $data->tanggal_lahir_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pendidikan</label>
                        <select name="pendidikan_wali" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $pdk)
                                <option value="{{ $pdk }}" {{ old('pendidikan_wali', $data->pendidikan_wali ?? '') == $pdk ? 'selected' : '' }}>{{ $pdk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pekerjaan</label>
                        <select name="pekerjaan_wali" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'] as $pkj)
                                <option value="{{ $pkj }}" {{ old('pekerjaan_wali', $data->pekerjaan_wali ?? '') == $pkj ? 'selected' : '' }}>{{ $pkj }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">No. Telp Wali</label>
                        <input type="tel" name="nomor_telepon_wali" value="{{ old('nomor_telepon_wali', $data->nomor_telepon_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl tel-input">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Email Wali</label>
                        <input type="email" name="email_wali" value="{{ old('email_wali', $data->email_wali ?? '') }}" {{ $isReadOnly ? 'disabled' : '' }} placeholder="wali@email.com" class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 5: Informasi Tambahan -->
        <section class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 relative transition-all">
            <div class="flex items-center gap-3 mb-8 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="size-11 bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined">info</span>
                </div>
                <div>
                    <h3 class="text-xl font-black tracking-tight uppercase">Informasi Tambahan</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Detail Pendaftaran</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tahun Ajaran *</label>
                    <input type="text" value="{{ $siswa->tahun_ajaran ?? '-' }}" disabled
                           class="w-full p-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-primary">
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $siswa->tahun_ajaran_id }}">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jenis Pendaftaran *</label>
                    <select name="jenis_daftar" {{ $isReadOnly ? 'disabled' : 'required' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <option value="">Pilih Jenis</option>
                        <option value="Siswa Baru" {{ old('jenis_daftar', $data->jenis_daftar ?? '') == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                        <option value="Pindahan" {{ old('jenis_daftar', $data->jenis_daftar ?? '') == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Sumber Informasi</label>
                    <select name="sumber_informasi_ppdb" {{ $isReadOnly ? 'disabled' : '' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <option value="">Pilih Sumber</option>
                        @foreach(['Media Sosial', 'Website Sekolah', 'Spanduk/Baliho', 'Teman/Keluarga', 'Guru', 'Lainnya'] as $src)
                            <option value="{{ $src }}" {{ old('sumber_informasi_ppdb', $data->sumber_informasi_ppdb ?? '') == $src ? 'selected' : '' }}>{{ $src }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Saudara di TK Ini?</label>
                    <select name="punya_saudara_sekolah_tk" {{ $isReadOnly ? 'disabled' : '' }}
                            class="w-full p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        <option value="Tidak" {{ old('punya_saudara_sekolah_tk', $data->punya_saudara_sekolah_tk ?? 'Tidak') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="Ya" {{ old('punya_saudara_sekolah_tk', $data->punya_saudara_sekolah_tk ?? '') == 'Ya' ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>
            </div>
        </section>
        </div>

        @if(!$isReadOnly)
        <!-- Final Confirmation -->
        <div class="bg-primary/10 p-8 rounded-3xl border border-primary/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 size-40 bg-primary/20 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            <label class="flex items-start gap-4 cursor-pointer relative z-10">
                <input type="checkbox" name="konfirmasi_data" value="1" required class="mt-1 size-6 text-primary bg-white border-primary/30 rounded-lg focus:ring-primary shadow-sm">
                <span class="text-sm text-primary font-bold leading-relaxed">
                    Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan sesuai dengan dokumen resmi. Saya bersedia mengikuti seluruh peraturan dan prosedur pendaftaran yang berlaku.
                </span>
            </label>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
            <p class="text-xs text-slate-400 font-medium italic">* Pastikan semua data bintang merah wajib diisi sebelum mengirim.</p>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('siswa.dashboard') }}" class="flex-1 md:flex-none px-10 py-4 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-slate-200 transition-all text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 md:flex-none px-12 py-4 bg-primary text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all text-center">
                    Kirim Pendaftaran
                </button>
            </div>
        </div>
        @else
        <div class="flex items-center justify-center pt-10">
            <a href="{{ route('siswa.success') }}" class="px-12 py-4 bg-primary text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all text-center">
                Lihat Status Pendaftaran
            </a>
        </div>
        @endif
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Toggle Alamat KK
    const alamatKKSama = document.getElementById('alamat_kk_sama');
    const alamatKKContainer = document.getElementById('alamatKKContainer');
    
    if(alamatKKSama) {
        alamatKKSama.addEventListener('change', function() {
            alamatKKContainer.classList.toggle('hidden', this.checked);
            alamatKKContainer.querySelectorAll('input, textarea').forEach(el => {
                if(!this.checked) el.setAttribute('required', 'required');
                else el.removeAttribute('required');
            });
        });
    }

    // Toggle Data Wali
    const punyaWali = document.getElementById('punya_wali');
    const dataWaliContainer = document.getElementById('dataWaliContainer');
    
    if(punyaWali) {
        punyaWali.addEventListener('change', function() {
            dataWaliContainer.classList.toggle('hidden', !this.checked);
            dataWaliContainer.querySelectorAll('input, select').forEach(el => {
                // We don't necessarily make wali required, but could if needed
            });
        });
    }

    // Input cleaning
    const cleanNumeric = (selector, maxLength) => {
        document.querySelectorAll(selector).forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (maxLength && this.value.length > maxLength) this.value = this.value.substring(0, maxLength);
            });
        });
    };

    cleanNumeric('.nik-input', 16);
    cleanNumeric('#nik_anak', 16);
    cleanNumeric('.tel-input', 15);
</script>
@endpush
