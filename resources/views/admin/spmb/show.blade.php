{{-- resources/views/admin/spmb/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Data SPMB')

@section('content')
<div class="p-4 sm:p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt mr-2"></i>Detail Data SPMB
                </h1>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mt-2">
                    <span class="text-sm sm:text-base text-gray-600">No. Pendaftaran:</span>
                    <span class="font-mono bg-gray-100 px-3 py-1 rounded-lg text-sm sm:text-base">
                        {{ $spmb->no_pendaftaran }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.spmb.index') }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-arrow-left text-xs sm:text-sm"></i> 
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Back</span>
                </a>
                
                <!-- Link ke data siswa jika sudah dikonversi -->
                @if($spmb->siswa)
                <a href="{{ route('admin.siswa.siswa-aktif.show', $spmb->siswa) }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-user-graduate text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Lihat Data Siswa</span>
                    <span class="sm:hidden">Siswa</span>
                </a>
                @endif
                
                <a href="{{ route('admin.spmb.edit', $spmb) }}" 
                   class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm sm:text-base">
                    <i class="fas fa-edit text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Edit</span>
                    <span class="sm:hidden">Edit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========== TOMBOL NAVIGASI DOKUMEN & BUKTI TRANSFER ========== -->
    @php
        $dokumenCount = $spmb->dokumen->count();
        $buktiTransferCount = $spmb->buktiTransfer->count();
        $pendingTransferCount = $spmb->buktiTransfer->where('status_verifikasi', 'Menunggu')->count();
    @endphp
    
    <div class="mb-6 flex flex-wrap gap-3">
        <!-- Tombol Dokumen -->
        <a href="{{ route('admin.spmb.dokumen.index', $spmb) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
            <i class="fas fa-file-alt text-lg"></i>
            <div class="flex flex-col items-start">
                <span class="text-sm font-semibold">Kelola Dokumen</span>
                <span class="text-xs opacity-90">{{ $dokumenCount }} file terupload</span>
            </div>
            @if($dokumenCount > 0)
            <span class="ml-2 bg-white text-blue-700 text-xs font-bold px-2 py-1 rounded-full">{{ $dokumenCount }}</span>
            @endif
        </a>

        <!-- Tombol Bukti Transfer (dengan badge status) -->
        <a href="{{ route('admin.spmb.bukti-transfer.index') }}?search={{ urlencode($spmb->nama_lengkap_anak) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md relative">
            <i class="fas fa-money-bill-wave text-lg"></i>
            <div class="flex flex-col items-start">
                <span class="text-sm font-semibold">Bukti Transfer</span>
                <span class="text-xs opacity-90">{{ $buktiTransferCount }} transaksi</span>
            </div>
            @if($pendingTransferCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center border-2 border-white font-bold animate-pulse shadow-lg">
                    {{ $pendingTransferCount }}
                </span>
            @endif
        </a>

        <!-- Tombol Riwayat Status -->
        <a href="#riwayat-status" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
            <i class="fas fa-history text-lg"></i>
            <div class="flex flex-col items-start">
                <span class="text-sm font-semibold">Riwayat Status</span>
                <span class="text-xs opacity-90">{{ $spmb->riwayatStatus->count() }} perubahan</span>
            </div>
        </a>
    </div>

    <!-- ========== INFO CEPAT (STATUS CARD) ========== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Status Dokumen -->
        @php
            $progress = $spmb->progress_verifikasi ?? ['persentase' => 0, 'terverifikasi' => 0, 'total' => 4];
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $spmb->dokumen_lengkap ? 'border-green-500' : 'border-yellow-500' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Verifikasi Dokumen</p>
                    <p class="text-2xl font-bold mt-1">{{ $progress['persentase'] ?? 0 }}%</p>
                </div>
                <div class="w-12 h-12 rounded-full {{ $spmb->dokumen_lengkap ? 'bg-green-100' : 'bg-yellow-100' }} flex items-center justify-center">
                    <i class="fas fa-file-alt {{ $spmb->dokumen_lengkap ? 'text-green-600' : 'text-yellow-600' }} text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-xs">
                <span class="text-gray-600">{{ $progress['terverifikasi'] ?? 0 }}/{{ $progress['total'] ?? 4 }} dokumen terverifikasi</span>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $spmb->verifikasi_bukti_transfer ? 'border-green-500' : 'border-gray-300' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Verifikasi Transfer</p>
                    <p class="text-2xl font-bold mt-1 {{ $spmb->verifikasi_bukti_transfer ? 'text-green-600' : 'text-gray-500' }}">{{ $spmb->verifikasi_bukti_transfer ? 'LUNAS' : 'BELUM' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full {{ $spmb->verifikasi_bukti_transfer ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas fa-money-bill-wave {{ $spmb->verifikasi_bukti_transfer ? 'text-green-600' : 'text-gray-600' }} text-xl"></i>
                </div>
            </div>
            @if($buktiTransferCount > 0)
                <div class="mt-2 text-xs">
                    <span class="text-gray-600">{{ $buktiTransferCount }} bukti transfer</span>
                    @if($pendingTransferCount > 0)
                        <span class="ml-2 text-red-600 font-medium">{{ $pendingTransferCount }} pending</span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Status Persetujuan Kepsek -->
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $spmb->approved_by_kepsek ? 'border-green-500' : 'border-gray-300' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Approval Kepsek</p>
                    <p class="text-2xl font-bold mt-1 {{ $spmb->approved_by_kepsek ? 'text-green-600' : 'text-gray-500' }}">{{ $spmb->approved_by_kepsek ? 'DISETUJUI' : 'MENUNGGU' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full {{ $spmb->approved_by_kepsek ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas fa-user-tie {{ $spmb->approved_by_kepsek ? 'text-green-600' : 'text-gray-600' }} text-xl"></i>
                </div>
            </div>
            @if($spmb->tanggal_approval)
                <div class="mt-2 text-xs">
                    <span class="text-gray-600">{{ $spmb->tanggal_approval->format('d/m/Y H:i') }}</span>
                </div>
            @endif
        </div>

        <!-- Status Kelas -->
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 {{ $spmb->kelas ? 'border-blue-500' : 'border-gray-300' }} hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold">Penempatan Kelas</p>
                    <p class="text-2xl font-bold mt-1 {{ $spmb->kelas ? 'text-blue-600' : 'text-gray-500' }}">{{ $spmb->kelas ?: 'BELUM' }}</p>
                </div>
                <div class="w-12 h-12 rounded-full {{ $spmb->kelas ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas fa-users {{ $spmb->kelas ? 'text-blue-600' : 'text-gray-600' }} text-xl"></i>
                </div>
            </div>
            @if($spmb->guru_kelas)
                <div class="mt-2 text-xs">
                    <span class="text-gray-600">Wali Kelas: {{ $spmb->guru_kelas }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Banner -->
    <div class="mb-6 sm:mb-8">
        @php
            $statusColors = [
                'Diterima' => 'bg-green-100 border-green-300 text-green-800',
                'Menunggu Verifikasi' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                'Mundur' => 'bg-red-100 border-red-300 text-red-800',
            ];
            
            $statusIcons = [
                'Diterima' => 'fa-check-circle',
                'Menunggu Verifikasi' => 'fa-clock',
                'Mundur' => 'fa-times-circle',
            ];
        @endphp
        
        <div class="p-4 border rounded-xl {{ $statusColors[$spmb->status_pendaftaran] ?? 'bg-gray-100 border-gray-300' }}">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <i class="fas {{ $statusIcons[$spmb->status_pendaftaran] ?? 'fa-info-circle' }} text-xl"></i>
                        <h3 class="font-bold text-lg">Status Pendaftaran: 
                            <span class="uppercase">{{ $spmb->status_pendaftaran }}</span>
                        </h3>
                    </div>
                    <p class="text-sm mt-2 text-gray-600">
                        <i class="far fa-calendar-alt mr-2"></i>
                        Tanggal Pendaftaran: {{ $spmb->created_at->translatedFormat('d F Y H:i') }}
                    </p>
                </div>
                
                <!-- Verifikasi Dokumen -->
                <div class="flex items-center gap-2">
                    @if($spmb->verifikasi_akte && $spmb->verifikasi_kk && $spmb->verifikasi_ktp)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Dokumen Lengkap
                        </span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Dokumen Belum Lengkap
                        </span>
                    @endif
                    
                    @if($spmb->is_aktif)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Siswa Aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Kolom Kiri: Data Calon Siswa -->
        <div class="space-y-6">
            <!-- Data Calon Siswa Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-blue-50 border-b border-blue-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-child mr-3 text-blue-600"></i>
                        Data Calon Siswa
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <!-- Nama Lengkap & Panggilan -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-sm sm:text-base font-medium text-gray-900">{{ $spmb->nama_lengkap_anak }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Panggilan</label>
                            <p class="text-sm sm:text-base text-gray-700">{{ $spmb->nama_panggilan_anak ?: '-' }}</p>
                        </div>
                    </div>
                    
                    <!-- NIK & Jenis Kelamin -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                            <p class="text-sm sm:text-base font-mono text-gray-900">{{ $spmb->nik_anak }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                            <p class="mt-1">
                                @if($spmb->jenis_kelamin == 'Laki-laki')
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
                    </div>
                    
                    <!-- Tempat & Tanggal Lahir -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                            <p class="text-sm sm:text-base text-gray-900">{{ $spmb->tempat_lahir_anak }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                            <p class="text-sm sm:text-base text-gray-900">
                                {{ $spmb->tanggal_lahir_anak->translatedFormat('d F Y') }}
                                <span class="text-gray-500 ml-2 text-sm">
                                    ({{ $spmb->usia_label }})
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Agama & Anak Ke -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Agama</label>
                            <p class="text-sm sm:text-base">{{ $spmb->agama }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Anak Ke</label>
                            <p class="text-sm sm:text-base">{{ $spmb->anak_ke }}</p>
                        </div>
                    </div>
                    
                    <!-- Tinggal Bersama -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tinggal Bersama</label>
                        <p class="text-sm sm:text-base">{{ $spmb->tinggal_bersama }}</p>
                    </div>
                    
                    <!-- Status Tempat Tinggal -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status Tempat Tinggal</label>
                        <p class="text-sm sm:text-base">{{ $spmb->status_tempat_tinggal }}</p>
                    </div>
                    
                    <!-- Bahasa Sehari-hari -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Bahasa Sehari-hari</label>
                        <p class="text-sm sm:text-base">{{ $spmb->bahasa_sehari_hari }}</p>
                    </div>
                    
                    <!-- Jarak & Waktu Tempuh -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jarak ke Sekolah</label>
                            <p class="text-sm sm:text-base">{{ $spmb->jarak_rumah_ke_sekolah ? $spmb->jarak_rumah_ke_sekolah . ' meter' : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Waktu Tempuh</label>
                            <p class="text-sm sm:text-base">{{ $spmb->waktu_tempuh_ke_sekolah ? $spmb->waktu_tempuh_ke_sekolah . ' menit' : '-' }}</p>
                        </div>
                    </div>
                    
                    <!-- Data Kesehatan -->
                    @if($spmb->berat_badan || $spmb->tinggi_badan || $spmb->golongan_darah)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Data Kesehatan</h4>
                        <div class="grid grid-cols-3 gap-4">
                            @if($spmb->berat_badan)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Berat Badan</label>
                                <p class="text-sm">{{ $spmb->berat_badan }} kg</p>
                            </div>
                            @endif
                            @if($spmb->tinggi_badan)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tinggi Badan</label>
                                <p class="text-sm">{{ $spmb->tinggi_badan }} cm</p>
                            </div>
                            @endif
                            @if($spmb->golongan_darah)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Golongan Darah</label>
                                <p class="text-sm">{{ $spmb->golongan_darah }}</p>
                            </div>
                            @endif
                        </div>
                        
                        @if($spmb->penyakit_pernah_diderita)
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Penyakit Pernah Diderita</label>
                            <p class="text-sm">{{ $spmb->penyakit_pernah_diderita }}</p>
                        </div>
                        @endif
                        
                        @if($spmb->imunisasi_pernah_diterima)
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Imunisasi</label>
                            <p class="text-sm">{{ $spmb->imunisasi_pernah_diterima }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Alamat Lengkap Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-indigo-50 border-b border-indigo-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-indigo-600"></i>
                        Alamat Lengkap
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Provinsi</label>
                            <p class="text-sm sm:text-base">{{ $spmb->provinsi_rumah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kota/Kabupaten</label>
                            <p class="text-sm sm:text-base">{{ $spmb->kota_kabupaten_rumah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kecamatan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->kecamatan_rumah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kelurahan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->kelurahan_rumah }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Jalan</label>
                        <p class="text-sm sm:text-base">{{ $spmb->nama_jalan_rumah }}</p>
                    </div>
                    
                    @if(!$spmb->alamat_kk_sama)
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Alamat di Kartu Keluarga (Berbeda)</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Provinsi KK</label>
                                <p class="text-sm">{{ $spmb->provinsi_kk ?: '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Kota/Kabupaten KK</label>
                                <p class="text-sm">{{ $spmb->kota_kabupaten_kk ?: '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Kecamatan KK</label>
                                <p class="text-sm">{{ $spmb->kecamatan_kk ?: '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Kelurahan KK</label>
                                <p class="text-sm">{{ $spmb->kelurahan_kk ?: '-' }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama Jalan KK</label>
                            <p class="text-sm">{{ $spmb->nama_jalan_kk ?: '-' }}</p>
                        </div>
                        @if($spmb->alamat_kk)
                        <div class="mt-3">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Alamat KK Lengkap</label>
                            <p class="text-sm">{{ $spmb->alamat_kk }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Data Orang Tua & Pendaftaran -->
        <div class="space-y-6">
            <!-- Data Ayah Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-green-50 border-b border-green-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-male mr-3 text-green-600"></i>
                        Data Ayah
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-sm sm:text-base">{{ $spmb->nama_lengkap_ayah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                            <p class="text-sm sm:text-base font-mono">{{ $spmb->nik_ayah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                            <p class="text-sm sm:text-base">{{ $spmb->tempat_lahir_ayah }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                            <p class="text-sm sm:text-base">{{ $spmb->tanggal_lahir_ayah->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pendidikan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->pendidikan_ayah ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pekerjaan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->pekerjaan_ayah ?: '-' }}</p>
                        </div>
                    </div>
                    
                    @if($spmb->bidang_pekerjaan_ayah)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Bidang Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $spmb->bidang_pekerjaan_ayah }}</p>
                    </div>
                    @endif
                    
                    @if($spmb->penghasilan_per_bulan_ayah)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penghasilan per Bulan</label>
                        <p class="text-sm sm:text-base">{{ $spmb->penghasilan_per_bulan_ayah }}</p>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Telepon</label>
                            <p class="text-sm sm:text-base">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $spmb->nomor_telepon_ayah) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-800 inline-flex items-center">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    {{ $spmb->nomor_telepon_ayah }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                            <p class="text-sm sm:text-base">
                                @if($spmb->email_ayah)
                                <a href="mailto:{{ $spmb->email_ayah }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $spmb->email_ayah }}
                                </a>
                                @else
                                -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Ibu Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-pink-50 border-b border-pink-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-female mr-3 text-pink-600"></i>
                        Data Ibu
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-sm sm:text-base">{{ $spmb->nama_lengkap_ibu }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                            <p class="text-sm sm:text-base font-mono">{{ $spmb->nik_ibu }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                            <p class="text-sm sm:text-base">{{ $spmb->tempat_lahir_ibu }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                            <p class="text-sm sm:text-base">{{ $spmb->tanggal_lahir_ibu->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pendidikan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->pendidikan_ibu ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pekerjaan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->pekerjaan_ibu ?: '-' }}</p>
                        </div>
                    </div>
                    
                    @if($spmb->bidang_pekerjaan_ibu)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Bidang Pekerjaan</label>
                        <p class="text-sm sm:text-base">{{ $spmb->bidang_pekerjaan_ibu }}</p>
                    </div>
                    @endif
                    
                    @if($spmb->penghasilan_per_bulan_ibu)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penghasilan per Bulan</label>
                        <p class="text-sm sm:text-base">{{ $spmb->penghasilan_per_bulan_ibu }}</p>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Telepon</label>
                            <p class="text-sm sm:text-base">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $spmb->nomor_telepon_ibu) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-800 inline-flex items-center">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    {{ $spmb->nomor_telepon_ibu }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                            <p class="text-sm sm:text-base">
                                @if($spmb->email_ibu)
                                <a href="mailto:{{ $spmb->email_ibu }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $spmb->email_ibu }}
                                </a>
                                @else
                                -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Wali Card (Jika Ada) -->
            @if($spmb->punya_wali && $spmb->nama_lengkap_wali)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-purple-50 border-b border-purple-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-user-shield mr-3 text-purple-600"></i>
                        Data Wali
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-sm sm:text-base">{{ $spmb->nama_lengkap_wali }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Hubungan</label>
                            <p class="text-sm sm:text-base">{{ $spmb->hubungan_dengan_anak }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                            <p class="text-sm sm:text-base font-mono">{{ $spmb->nik_wali ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Telepon</label>
                            <p class="text-sm sm:text-base">{{ $spmb->nomor_telepon_wali ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Data Pendaftaran Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-purple-50 border-b border-purple-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-graduation-cap mr-3 text-purple-600"></i>
                        Data Pendaftaran
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tahun Ajaran</label>
                            <p class="text-sm sm:text-base">{{ $spmb->tahunAjaran->tahun_ajaran ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jenis Daftar</label>
                            <p class="text-sm sm:text-base">{{ $spmb->jenis_daftar }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Sumber Informasi</label>
                        <p class="text-sm sm:text-base">{{ $spmb->sumber_informasi_ppdb ?: '-' }}</p>
                    </div>
                    
                    <div class="flex items-center">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 mr-4">Punya Saudara di TK Ini?</label>
                        <span class="px-2 py-1 text-xs rounded-full {{ $spmb->punya_saudara_sekolah_tk == 'Ya' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $spmb->punya_saudara_sekolah_tk ?: 'Tidak' }}
                        </span>
                    </div>
                    
                    @if($spmb->catatan_khusus)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan Khusus</label>
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800 whitespace-pre-line">{{ $spmb->catatan_khusus }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Verifikasi Dokumen Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-orange-50 border-b border-orange-100">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-orange-600"></i>
                        Verifikasi Dokumen
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="space-y-3">
                        <!-- Akta Kelahiran -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Akta Kelahiran</span>
                            @if($spmb->verifikasi_akte)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Belum
                                </span>
                            @endif
                        </div>
                        
                        <!-- Kartu Keluarga -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Kartu Keluarga</span>
                            @if($spmb->verifikasi_kk)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Belum
                                </span>
                            @endif
                        </div>
                        
                        <!-- KTP Orang Tua -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">KTP Orang Tua</span>
                            @if($spmb->verifikasi_ktp)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Belum
                                </span>
                            @endif
                        </div>
                        
                        <!-- Bukti Transfer -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Bukti Transfer</span>
                            @if($spmb->verifikasi_bukti_transfer)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Belum
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Progress Verifikasi -->
                    @php
                        $totalDokumen = 4; // Akte, KK, KTP, Bukti Transfer
                        $terverifikasi = ($spmb->verifikasi_akte ? 1 : 0) + 
                                        ($spmb->verifikasi_kk ? 1 : 0) + 
                                        ($spmb->verifikasi_ktp ? 1 : 0) + 
                                        ($spmb->verifikasi_bukti_transfer ? 1 : 0);
                        $progress = round(($terverifikasi / $totalDokumen) * 100);
                    @endphp
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium">Progress Verifikasi</span>
                            <span class="text-gray-600">{{ $terverifikasi }}/{{ $totalDokumen }} ({{ $progress }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    
                    @if($spmb->diverifikasi_oleh)
                    <div class="text-xs text-gray-500 mt-3">
                        <i class="far fa-clock mr-1"></i>
                        Diverifikasi oleh: {{ $spmb->verifikator?->name ?? 'System' }}
                        @if($spmb->tanggal_verifikasi_akte)
                            <br>Akta: {{ $spmb->tanggal_verifikasi_akte->format('d/m/Y H:i') }}
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Dokumen yang Diupload -->
            @if($spmb->dokumen && $spmb->dokumen->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-gray-600"></i>
                        Dokumen Pendukung
                    </h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-3">
                        @foreach($spmb->dokumen as $dokumen)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                @if(str_contains($dokumen->mime_type, 'pdf'))
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                @elseif(str_contains($dokumen->mime_type, 'image'))
                                    <i class="fas fa-file-image text-blue-500 text-xl mr-3"></i>
                                @else
                                    <i class="fas fa-file text-gray-500 text-xl mr-3"></i>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $dokumen->nama_file }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $dokumen->jenis_label }} • {{ $dokumen->ukuran_formatted }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ $dokumen->url }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Informasi Sistem Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-gray-600"></i>
                        Informasi Sistem
                    </h3>
                </div>
                <div class="p-4 sm:p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dibuat Pada</label>
                            <p class="text-sm sm:text-base">
                                {{ $spmb->created_at->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $spmb->created_at->format('H:i') }} WIB
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Terakhir Diupdate</label>
                            <p class="text-sm sm:text-base">
                                {{ $spmb->updated_at->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $spmb->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    
                    @if($spmb->approved_by_kepsek)
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span class="text-sm font-medium">Telah disetujui Kepala Sekolah</span>
                        </div>
                        @if($spmb->tanggal_approval)
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $spmb->tanggal_approval->translatedFormat('d F Y H:i') }}
                        </p>
                        @endif
                    </div>
                    @endif
                    
                    @if($spmb->kelas)
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <i class="fas fa-door-open text-blue-500 mr-2"></i>
                            <span class="text-sm font-medium">Kelas: {{ $spmb->kelas }}</span>
                            @if($spmb->guru_kelas)
                            <span class="text-xs text-gray-500 ml-2">(Guru: {{ $spmb->guru_kelas }})</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    @if($spmb->nomor_induk_siswa)
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-purple-500 mr-2"></i>
                            <span class="text-sm font-medium">Nomor Induk Siswa: {{ $spmb->nomor_induk_siswa }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($spmb->catatan_admin)
                    <div class="pt-4 border-t border-gray-200">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Catatan Admin</label>
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $spmb->catatan_admin }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION RIWAYAT STATUS -->
    <div id="riwayat-status" class="bg-white rounded-xl shadow-md overflow-hidden mt-8">
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                <i class="fas fa-history mr-3 text-gray-600"></i>
                Riwayat Perubahan Status
            </h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($spmb->riwayatStatus->isEmpty())
                <p class="text-gray-500 text-center py-4">Belum ada riwayat perubahan status.</p>
            @else
                <div class="space-y-4">
                    @foreach($spmb->riwayatStatus as $riwayat)
                    <div class="flex items-start gap-4 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exchange-alt text-blue-600 text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $riwayat->status_sebelumnya_badge ?? 'bg-gray-100' }}">
                                    {{ $riwayat->status_sebelumnya ?? 'Pendaftaran Baru' }}
                                </span>
                                <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                <span class="px-2 py-1 text-xs rounded-full {{ $riwayat->status_baru_badge ?? 'bg-gray-100' }}">
                                    {{ $riwayat->status_baru }}
                                </span>
                                <span class="text-xs text-gray-500 ml-auto">{{ $riwayat->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($riwayat->keterangan)
                                <p class="text-sm text-gray-600 mt-2">{{ $riwayat->keterangan }}</p>
                            @endif
                            @if($riwayat->user)
                                <p class="text-xs text-gray-500 mt-1">Oleh: {{ $riwayat->user->name }} ({{ $riwayat->role_pengubah }})</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-wrap gap-3 justify-end border-t border-gray-200 pt-6">
        <!-- Tombol Verifikasi Dokumen -->
        @if(!$spmb->verifikasi_akte || !$spmb->verifikasi_kk || !$spmb->verifikasi_ktp)
        <button type="button" 
                onclick="showVerifikasiModal()"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
            <i class="fas fa-check-circle mr-2"></i> Verifikasi Dokumen
        </button>
        @endif
        
        <!-- Tombol Update Status -->
        <button type="button" 
                onclick="showStatusModal()"
                class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
            <i class="fas fa-sync-alt mr-2"></i> Update Status
        </button>
        
        <!-- Tombol Approve Kepsek (jika belum) -->
        @if(!$spmb->approved_by_kepsek && $spmb->verifikasi_akte && $spmb->verifikasi_kk && $spmb->verifikasi_ktp)
        <button type="button" 
                onclick="approveKepsek({{ $spmb->id }})"
                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
            <i class="fas fa-user-check mr-2"></i> Approve Kepala Sekolah
        </button>
        @endif
        
        <!-- Tombol Assign Kelas (jika sudah diterima) -->
        @if($spmb->status_pendaftaran == 'Diterima' && !$spmb->kelas)
        <button type="button" 
                onclick="showAssignKelasModal()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
            <i class="fas fa-door-open mr-2"></i> Assign Kelas
        </button>
        @endif
        
        <!-- Tombol Konversi ke Siswa (jika diterima dan belum dikonversi) -->
        @if($spmb->status_pendaftaran == 'Diterima' && !$spmb->siswa)
        <button type="button" 
                onclick="konversiKeSiswa({{ $spmb->id }}, '{{ $spmb->nama_lengkap_anak }}')"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
            <i class="fas fa-user-graduate mr-2"></i> Konversi ke Siswa
        </button>
        @endif
        
        <!-- Tombol Hapus -->
        <button type="button" 
                onclick="confirmDelete({{ $spmb->id }}, '{{ $spmb->nama_lengkap_anak }}')"
                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow-sm hover:shadow-md">
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
                    Update Status Pendaftaran
                </h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                ID: <span class="font-mono font-medium">#{{ $spmb->id }}</span> • 
                <span class="font-medium">{{ $spmb->nama_lengkap_anak }}</span>
            </p>
        </div>
        
        <div class="px-5 py-4">
            <form id="statusForm" method="POST" action="{{ route('admin.spmb.updateStatus', $spmb) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-flag text-gray-400 mr-1.5 text-xs"></i>
                        Status Baru
                    </label>
                    <div class="space-y-2">
                        <label class="relative flex items-center p-3 border rounded-lg cursor-pointer transition-all has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                            <input type="radio" name="status" value="Menunggu Verifikasi" class="mr-3" {{ $spmb->status_pendaftaran == 'Menunggu Verifikasi' ? 'checked' : '' }}>
                            <span class="text-sm flex items-center">
                                <i class="fas fa-clock text-yellow-600 mr-2"></i> Menunggu Verifikasi
                            </span>
                        </label>
                        <label class="relative flex items-center p-3 border rounded-lg cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="status" value="Diterima" class="mr-3" {{ $spmb->status_pendaftaran == 'Diterima' ? 'checked' : '' }}>
                            <span class="text-sm flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i> Diterima
                            </span>
                        </label>
                        <label class="relative flex items-center p-3 border rounded-lg cursor-pointer transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="status" value="Mundur" class="mr-3" {{ $spmb->status_pendaftaran == 'Mundur' ? 'checked' : '' }}>
                            <span class="text-sm flex items-center">
                                <i class="fas fa-times-circle text-red-600 mr-2"></i> Mundur
                            </span>
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
                        <i class="fas fa-sticky-note text-gray-400 mr-1.5 text-xs"></i>
                        Catatan (Opsional)
                    </label>
                    <textarea name="catatan" rows="3" 
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500"
                              placeholder="Tambahkan catatan jika diperlukan..."></textarea>
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

<!-- Verifikasi Dokumen Modal -->
<div id="verifikasiModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="verifikasiModalContent">
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    Verifikasi Dokumen
                </h3>
                <button onclick="closeVerifikasiModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">{{ $spmb->nama_lengkap_anak }}</p>
        </div>
        
        <div class="px-5 py-4">
            <form id="verifikasiForm" method="POST" action="{{ route('admin.spmb.verifikasiDokumen', $spmb) }}">
                @csrf
                
                <div class="space-y-3 mb-5">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Akta Kelahiran</span>
                        <button type="button" 
                                onclick="verifikasiDokumen('akte')"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg {{ $spmb->verifikasi_akte ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                            <i class="fas {{ $spmb->verifikasi_akte ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                            {{ $spmb->verifikasi_akte ? 'Terverifikasi' : 'Verifikasi Sekarang' }}
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Kartu Keluarga</span>
                        <button type="button" 
                                onclick="verifikasiDokumen('kk')"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg {{ $spmb->verifikasi_kk ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                            <i class="fas {{ $spmb->verifikasi_kk ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                            {{ $spmb->verifikasi_kk ? 'Terverifikasi' : 'Verifikasi Sekarang' }}
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">KTP Orang Tua</span>
                        <button type="button" 
                                onclick="verifikasiDokumen('ktp')"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg {{ $spmb->verifikasi_ktp ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                            <i class="fas {{ $spmb->verifikasi_ktp ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                            {{ $spmb->verifikasi_ktp ? 'Terverifikasi' : 'Verifikasi Sekarang' }}
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">Bukti Transfer</span>
                        <button type="button" 
                                onclick="verifikasiDokumen('bukti_transfer')"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg {{ $spmb->verifikasi_bukti_transfer ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                            <i class="fas {{ $spmb->verifikasi_bukti_transfer ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                            {{ $spmb->verifikasi_bukti_transfer ? 'Terverifikasi' : 'Verifikasi Sekarang' }}
                        </button>
                    </div>
                </div>
                
                <!-- Progress -->
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-medium">Progress</span>
                        <span class="text-gray-600">
                            @php
                                $terverifikasi = ($spmb->verifikasi_akte ? 1 : 0) + 
                                                ($spmb->verifikasi_kk ? 1 : 0) + 
                                                ($spmb->verifikasi_ktp ? 1 : 0) + 
                                                ($spmb->verifikasi_bukti_transfer ? 1 : 0);
                            @endphp
                            {{ $terverifikasi }}/4
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($terverifikasi/4)*100 }}%"></div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end">
            <button type="button" onclick="closeVerifikasiModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Assign Kelas Modal -->
<div id="assignKelasModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="assignKelasModalContent">
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-door-open text-blue-500 mr-2"></i>
                    Assign Kelas
                </h3>
                <button onclick="closeAssignKelasModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">{{ $spmb->nama_lengkap_anak }}</p>
        </div>
        
        <div class="px-5 py-4">
            <form id="assignKelasForm" method="POST" action="{{ route('admin.spmb.assignKelas', $spmb) }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Kelas
                    </label>
                    <select name="kelas" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="Kelompok A">Kelompok A</option>
                        <option value="Kelompok B">Kelompok B</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Guru Kelas
                    </label>
                    <input type="text" name="guru_kelas" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nama guru kelas">
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeAssignKelasModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan
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

<!-- Form Konversi (Hidden) -->
<form id="konversiForm" method="POST" style="display: none;">
    @csrf
</form>

<!-- CSRF Token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Fungsi untuk membuka/tutup modal
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

function showVerifikasiModal() {
    document.getElementById('verifikasiModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('verifikasiModalContent').style.opacity = '1';
        document.getElementById('verifikasiModalContent').style.transform = 'scale(1)';
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeVerifikasiModal() {
    document.getElementById('verifikasiModalContent').style.opacity = '0';
    document.getElementById('verifikasiModalContent').style.transform = 'scale(0.95)';
    setTimeout(() => {
        document.getElementById('verifikasiModal').classList.add('hidden');
        document.body.style.overflow = '';
    }, 200);
}

function showAssignKelasModal() {
    document.getElementById('assignKelasModal').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('assignKelasModalContent').style.opacity = '1';
        document.getElementById('assignKelasModalContent').style.transform = 'scale(1)';
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeAssignKelasModal() {
    document.getElementById('assignKelasModalContent').style.opacity = '0';
    document.getElementById('assignKelasModalContent').style.transform = 'scale(0.95)';
    setTimeout(() => {
        document.getElementById('assignKelasModal').classList.add('hidden');
        document.body.style.overflow = '';
    }, 200);
}

// Fungsi verifikasi dokumen via AJAX
function verifikasiDokumen(jenis) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    fetch('{{ route("admin.spmb.verifikasiDokumen", $spmb) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ jenis: jenis })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Dokumen berhasil diverifikasi!', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Gagal verifikasi: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan koneksi', 'error');
    });
}

// Fungsi approve kepala sekolah
function approveKepsek(id) {
    if (confirm('Setujui pendaftaran ini sebagai Kepala Sekolah?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        fetch('/admin/spmb/' + id + '/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Persetujuan berhasil!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Gagal: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan koneksi', 'error');
        });
    }
}

// Fungsi konversi ke siswa
function konversiKeSiswa(id, name) {
    if (confirm('Konversi "' + name + '" menjadi data siswa?')) {
        const form = document.getElementById('konversiForm');
        form.action = '/admin/spmb/' + id + '/konversi';
        form.submit();
    }
}

// Fungsi hapus
function confirmDelete(id, name) {
    if (confirm('Apakah Anda yakin ingin menghapus pendaftaran "' + name + '"?\nData yang dihapus tidak dapat dikembalikan.')) {
        const form = document.getElementById('deleteForm');
        form.action = '/admin/spmb/' + id;
        form.submit();
    }
}

// Fungsi notifikasi
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-0 ${
        type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 
        type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
        'bg-blue-50 border border-blue-200 text-blue-800'
    }`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 
                 type === 'error' ? 'fa-exclamation-circle' : 
                 'fa-info-circle';
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Tutup modal saat klik di luar
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) closeStatusModal();
});

document.getElementById('verifikasiModal').addEventListener('click', function(e) {
    if (e.target === this) closeVerifikasiModal();
});

document.getElementById('assignKelasModal').addEventListener('click', function(e) {
    if (e.target === this) closeAssignKelasModal();
});

// ESC key handler
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('statusModal').classList.contains('hidden')) {
            closeStatusModal();
        }
        if (!document.getElementById('verifikasiModal').classList.contains('hidden')) {
            closeVerifikasiModal();
        }
        if (!document.getElementById('assignKelasModal').classList.contains('hidden')) {
            closeAssignKelasModal();
        }
    }
});
</script>

<style>
/* Animasi untuk badge notifikasi */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}
.animate-pulse {
    animation: pulse 1.5s infinite;
}

/* Modal styles */
.modal-container {
    transform: scale(0.95);
    opacity: 0;
    transition: all 0.2s ease-out;
}

.modal-container.show {
    transform: scale(1);
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .grid {
        gap: 1rem;
    }
    
    .info-label {
        font-size: 0.7rem;
    }
    
    .info-value {
        font-size: 0.85rem;
    }
}
</style>
@endsection