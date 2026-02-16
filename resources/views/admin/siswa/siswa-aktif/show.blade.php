{{-- resources/views/admin/siswa/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="p-4 sm:p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    @if($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                             alt="{{ $siswa->nama_lengkap }}" 
                             class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center border-2 border-gray-200">
                            <i class="fas fa-user-graduate text-blue-400 text-xl sm:text-2xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">
                            {{ $siswa->nama_lengkap }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 mt-1">
                            <span class="text-xs sm:text-sm text-gray-500">NIS:</span>
                            <span class="font-mono bg-gray-100 px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm">
                                {{ $siswa->nis ?? 'NIS-' . str_pad($siswa->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($siswa->nisn)
                            <span class="text-xs sm:text-sm text-gray-500 ml-2">NISN:</span>
                            <span class="font-mono bg-gray-100 px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm">
                                {{ $siswa->nisn }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-arrow-left text-xs sm:text-sm"></i> 
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Back</span>
                </a>
                
                @if($siswa->spmb_id)
                <a href="{{ route('admin.spmb.show', $siswa->spmb_id) }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-exchange-alt text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Lihat Data SPMB</span>
                    <span class="sm:hidden">SPMB</span>
                </a>
                @endif
                
                <a href="{{ route('admin.siswa.siswa-aktif.edit', $siswa) }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-edit text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Edit</span>
                    <span class="sm:hidden">Edit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="mb-6 sm:mb-8">
        @php
            $statusColors = [
                'aktif' => 'bg-green-100 border-green-300 text-green-800',
                'lulus' => 'bg-blue-100 border-blue-300 text-blue-800',
                'pindah' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                'cuti' => 'bg-purple-100 border-purple-300 text-purple-800',
            ];
            
            $statusIcons = [
                'aktif' => 'fa-check-circle',
                'lulus' => 'fa-graduation-cap',
                'pindah' => 'fa-exchange-alt',
                'cuti' => 'fa-clock',
            ];
        @endphp
        
        <div class="p-4 border rounded-xl {{ $statusColors[$siswa->status_siswa] ?? 'bg-gray-100 border-gray-300' }}">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <i class="fas {{ $statusIcons[$siswa->status_siswa] ?? 'fa-info-circle' }} text-xl"></i>
                    <div>
                        <h3 class="font-bold text-lg">Status Siswa: 
                            <span class="uppercase">{{ $siswa->status_siswa }}</span>
                        </h3>
                        <p class="text-sm mt-1 text-gray-600">
                            <i class="far fa-calendar-alt mr-2"></i>
                            Tanggal Masuk: {{ $siswa->tanggal_masuk->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
                
                @if($siswa->spmb_id)
                <div class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                    <i class="fas fa-user-check mr-2"></i> Dari SPMB
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200 overflow-x-auto">
        <ul class="flex flex-nowrap sm:flex-wrap -mb-px text-sm font-medium text-center" id="tabMenu" role="tablist">
            <li class="mr-2 flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 rounded-t-lg active-tab" id="profile-tab" type="button" role="tab" onclick="showTab('profile')">Data Pribadi</button>
            </li>
            <li class="mr-2 flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="address-tab" type="button" role="tab" onclick="showTab('address')">Alamat & Kesehatan</button>
            </li>
            <li class="mr-2 flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="father-tab" type="button" role="tab" onclick="showTab('father')">Data Ayah</button>
            </li>
            <li class="mr-2 flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="mother-tab" type="button" role="tab" onclick="showTab('mother')">Data Ibu</button>
            </li>
            <li class="mr-2 flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="guardian-tab" type="button" role="tab" onclick="showTab('guardian')">Data Wali</button>
            </li>
            <li class="flex-shrink-0" role="presentation">
                <button class="inline-block p-3 sm:p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300" id="academic-tab" type="button" role="tab" onclick="showTab('academic')">Akademik</button>
            </li>
        </ul>
    </div>

    <!-- Tab: Data Pribadi -->
    <div id="profile" class="tab-content">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-blue-50 border-b border-blue-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-child mr-3 text-blue-600"></i>
                    Data Pribadi
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-sm sm:text-base font-mono">{{ $siswa->nik }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIS</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nis ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NISN</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <p class="text-sm sm:text-base font-medium">{{ $siswa->nama_lengkap }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Panggilan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nama_panggilan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tempat_lahir }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                        <p class="text-sm sm:text-base">
                            {{ $siswa->tanggal_lahir->translatedFormat('d F Y') }}
                            <span class="text-gray-500 ml-2 text-xs sm:text-sm">
                                ({{ $siswa->usia_label }})
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                        <p class="mt-1">
                            @if($siswa->jenis_kelamin == 'L')
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-mars mr-1"></i> Laki-laki
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                <i class="fas fa-venus mr-1"></i> Perempuan
                            </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Agama</label>
                        <p class="text-sm sm:text-base">{{ $siswa->agama ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Alamat & Kesehatan -->
    <div id="address" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-indigo-50 border-b border-indigo-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-map-marker-alt mr-3 text-indigo-600"></i>
                    Alamat & Kesehatan
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Alamat Lengkap</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Provinsi</label>
                        <p class="text-sm sm:text-base">{{ $siswa->provinsi ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kota/Kabupaten</label>
                        <p class="text-sm sm:text-base">{{ $siswa->kota_kabupaten ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kecamatan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->kecamatan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kelurahan/Desa</label>
                        <p class="text-sm sm:text-base">{{ $siswa->kelurahan ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Jalan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nama_jalan ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                        <p class="text-sm sm:text-base whitespace-pre-line">{{ $siswa->alamat }}</p>
                    </div>
                </div>

                <h4 class="text-sm font-medium text-gray-700 mb-3 pt-4 border-t border-gray-200">Data Kesehatan</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Berat Badan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->berat_badan ? $siswa->berat_badan . ' kg' : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tinggi Badan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tinggi_badan ? $siswa->tinggi_badan . ' cm' : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Golongan Darah</label>
                        <p class="text-sm sm:text-base">{{ $siswa->golongan_darah ?? '-' }}</p>
                    </div>
                </div>
                
                @if($siswa->penyakit_pernah_diderita)
                <div class="mt-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penyakit Pernah Diderita</label>
                    <p class="text-sm sm:text-base">{{ $siswa->penyakit_pernah_diderita }}</p>
                </div>
                @endif
                
                @if($siswa->imunisasi)
                <div class="mt-4">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Imunisasi</label>
                    <p class="text-sm sm:text-base">{{ $siswa->imunisasi }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab: Data Ayah -->
    <div id="father" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-blue-50 border-b border-blue-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-male mr-3 text-blue-600"></i>
                    Data Ayah
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nama_ayah }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-sm sm:text-base font-mono">{{ $siswa->nik_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tempat_lahir_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tanggal_lahir_ayah ? $siswa->tanggal_lahir_ayah->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pendidikan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->pendidikan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->pekerjaan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Bidang Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->bidang_pekerjaan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penghasilan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->penghasilan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. HP/WA</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->no_hp_ayah)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_hp_ayah) }}" 
                               target="_blank"
                               class="text-green-600 hover:text-green-800 inline-flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                {{ $siswa->no_hp_ayah }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->email_ayah)
                            <a href="mailto:{{ $siswa->email_ayah }}" class="text-blue-600 hover:text-blue-800">
                                {{ $siswa->email_ayah }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Data Ibu -->
    <div id="mother" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-pink-50 border-b border-pink-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-female mr-3 text-pink-600"></i>
                    Data Ibu
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nama_ibu }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-sm sm:text-base font-mono">{{ $siswa->nik_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tempat_lahir_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tanggal_lahir_ibu ? $siswa->tanggal_lahir_ibu->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pendidikan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->pendidikan_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->pekerjaan_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Bidang Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->bidang_pekerjaan_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penghasilan</label>
                        <p class="text-sm sm:text-base">{{ $siswa->penghasilan_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. HP/WA</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->no_hp_ibu)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_hp_ibu) }}" 
                               target="_blank"
                               class="text-green-600 hover:text-green-800 inline-flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                {{ $siswa->no_hp_ibu }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->email_ibu)
                            <a href="mailto:{{ $siswa->email_ibu }}" class="text-blue-600 hover:text-blue-800">
                                {{ $siswa->email_ibu }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Data Wali -->
    <div id="guardian" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-purple-50 border-b border-purple-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-user-shield mr-3 text-purple-600"></i>
                    Data Wali
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                @if($siswa->punya_wali && $siswa->nama_wali)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap Wali</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nama_wali }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Hubungan dengan Anak</label>
                        <p class="text-sm sm:text-base">{{ $siswa->hubungan_wali ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK Wali</label>
                        <p class="text-sm sm:text-base font-mono">{{ $siswa->nik_wali ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pekerjaan Wali</label>
                        <p class="text-sm sm:text-base">{{ $siswa->pekerjaan_wali ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Telepon Wali</label>
                        <p class="text-sm sm:text-base">{{ $siswa->nomor_telepon_wali ?? '-' }}</p>
                    </div>
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-user-slash text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">Tidak ada data wali</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab: Akademik -->
    <div id="academic" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-green-50 border-b border-green-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-graduation-cap mr-3 text-green-600"></i>
                    Informasi Akademik
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kelompok</label>
                        <p class="text-sm sm:text-base">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Kelompok {{ $siswa->kelompok }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tahun Ajaran</label>
                        <p class="text-sm sm:text-base">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $siswa->tahunAjaran->tahun_ajaran ?? $siswa->tahun_ajaran }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status</label>
                        <p class="text-sm sm:text-base">
                            <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $statusColors[$siswa->status_siswa] }}">
                                {{ ucfirst($siswa->status_siswa) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Masuk</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tanggal_masuk->translatedFormat('d F Y') }}</p>
                    </div>
                    
                    @if($siswa->tanggal_keluar)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Keluar</label>
                        <p class="text-sm sm:text-base">{{ $siswa->tanggal_keluar->translatedFormat('d F Y') }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jalur Masuk</label>
                        <p class="text-sm sm:text-base">{{ $siswa->jalur_masuk ? ucfirst($siswa->jalur_masuk) : '-' }}</p>
                    </div>
                    
                    @if($siswa->kelas)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kelas</label>
                        <p class="text-sm sm:text-base">{{ $siswa->kelas }}</p>
                    </div>
                    @endif
                    
                    @if($siswa->guru_kelas)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Guru Kelas</label>
                        <p class="text-sm sm:text-base">{{ $siswa->guru_kelas }}</p>
                    </div>
                    @endif
                    
                    @if($siswa->catatan)
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan</label>
                        <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $siswa->catatan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak Utama & Informasi Sistem (di luar tab) -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kontak Utama -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-yellow-50 border-b border-yellow-100">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-phone mr-3 text-yellow-600"></i>
                    Kontak Utama
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. HP/WA Utama</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->no_hp_ortu)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_hp_ortu) }}" 
                               target="_blank"
                               class="text-green-600 hover:text-green-800 inline-flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                {{ $siswa->no_hp_ortu }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email Utama</label>
                        <p class="text-sm sm:text-base">
                            @if($siswa->email_ortu)
                            <a href="mailto:{{ $siswa->email_ortu }}" class="text-blue-600 hover:text-blue-800">
                                {{ $siswa->email_ortu }}
                            </a>
                            @else
                            -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Sistem -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-gray-600"></i>
                    Informasi Sistem
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dibuat Pada</label>
                        <p class="text-sm sm:text-base">
                            {{ $siswa->created_at->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $siswa->created_at->format('H:i') }} WIB
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Terakhir Diupdate</label>
                        <p class="text-sm sm:text-base">
                            {{ $siswa->updated_at->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $siswa->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                
                @if($siswa->spmb_id)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center text-blue-600">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        <span class="text-sm font-medium">Dikonversi dari data SPMB</span>
                    </div>
                    <a href="{{ route('admin.spmb.show', $siswa->spmb_id) }}" 
                       class="text-sm text-blue-600 hover:text-blue-800 mt-1 inline-block">
                        Lihat data SPMB asli →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-wrap gap-3 justify-end border-t border-gray-200 pt-6">
        <!-- Tombol Update Status -->
        <button type="button" 
                onclick="showStatusModal()"
                class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition text-sm sm:text-base">
            <i class="fas fa-sync-alt mr-2"></i> Update Status
        </button>
        
        <!-- Tombol Edit -->
        <a href="{{ route('admin.siswa.siswa-aktif.edit', $siswa) }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm sm:text-base">
            <i class="fas fa-edit mr-2"></i> Edit Data
        </a>
        
        <!-- Tombol Hapus -->
        <button type="button" 
                onclick="confirmDelete({{ $siswa->id }}, '{{ $siswa->nama_lengkap }}')"
                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm sm:text-base">
            <i class="fas fa-trash mr-2"></i> Hapus
        </button>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="statusModalContent">
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sync-alt text-yellow-500 mr-2"></i>
                    Update Status Siswa
                </h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                {{ $siswa->nama_lengkap }} • NIS: {{ $siswa->nis ?? 'NIS-' . str_pad($siswa->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        
        <div class="px-5 py-4">
            <form id="statusForm" method="POST" action="{{ route('admin.siswa.siswa-aktif.updateStatus', $siswa) }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select name="status_siswa" id="status_select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" onchange="toggleTanggalKeluar()">
                        <option value="aktif" {{ $siswa->status_siswa == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="lulus" {{ $siswa->status_siswa == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="pindah" {{ $siswa->status_siswa == 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="cuti" {{ $siswa->status_siswa == 'cuti' ? 'selected' : '' }}>Cuti</option>
                    </select>
                </div>
                
                <div id="tanggalKeluarField" class="mb-5 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3" 
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500"
                              placeholder="Tambahkan catatan..."></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeStatusModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg hover:from-yellow-600 hover:to-yellow-700 flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form Hapus (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- CSRF Token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
    if (activeBtn) {
        activeBtn.classList.add('active-tab', 'border-blue-500', 'text-blue-600');
        activeBtn.classList.remove('border-transparent');
    }
}

// Fungsi untuk modal status
function showStatusModal() {
    document.getElementById('statusModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('statusModalContent').style.opacity = '1';
        document.getElementById('statusModalContent').style.transform = 'scale(1)';
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeStatusModal() {
    document.getElementById('statusModalContent').style.opacity = '0';
    document.getElementById('statusModalContent').style.transform = 'scale(0.95)';
    setTimeout(() => {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = '';
    }, 200);
}

// Toggle tanggal keluar berdasarkan status
function toggleTanggalKeluar() {
    const status = document.getElementById('status_select').value;
    const tanggalField = document.getElementById('tanggalKeluarField');
    
    if (status === 'lulus' || status === 'pindah' || status === 'cuti') {
        tanggalField.classList.remove('hidden');
    } else {
        tanggalField.classList.add('hidden');
    }
}

// Fungsi hapus
function confirmDelete(id, name) {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa "' + name + '"?\nData yang dihapus tidak dapat dikembalikan.')) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/siswa/' + id;
        form.submit();
    }
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    // Tampilkan tab pertama
    showTab('profile');
    
    // Inisialisasi toggle tanggal keluar
    toggleTanggalKeluar();
});

// Tutup modal saat klik di luar
document.getElementById('statusModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeStatusModal();
});

// ESC key handler
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('statusModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeStatusModal();
        }
    }
});
</script>

<style>
.active-tab {
    border-bottom-color: #3b82f6;
    color: #2563eb;
}

/* Modal styles */
#statusModalContent {
    transition: all 0.2s ease-out;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .tab-content {
        padding: 0;
    }
    
    .grid {
        gap: 1rem;
    }
}
</style>
@endsection