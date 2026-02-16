@extends('layouts.nav-spmb')

@section('title', 'SPMB Jabar 2026/2027 - TK Ceria Bangsa')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12 sm:py-16">
        <div class="absolute inset-0 opacity-10 overflow-hidden">
            <div class="absolute top-5 left-5 w-20 h-20 sm:w-40 sm:h-40 bg-white rounded-full"></div>
            <div class="absolute bottom-5 right-5 w-30 h-30 sm:w-60 sm:h-60 bg-white rounded-full"></div>
        </div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <div class="inline-flex items-center justify-center p-3 sm:p-4 bg-white bg-opacity-20 rounded-full mb-4 sm:mb-6">
                    <i class="fas fa-university text-white text-2xl sm:text-3xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-4">
                    SPMB Jabar 2026/2027
                </h1>
                <p class="text-lg sm:text-xl text-blue-100 mb-4 sm:mb-6">
                    Sistem Penerimaan Peserta Didik Baru
                </p>
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                    <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white bg-opacity-20 rounded-full text-xs sm:text-sm">
                        <i class="fas fa-school mr-1 sm:mr-2 text-xs sm:text-sm"></i> TK Ceria Bangsa
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white bg-opacity-20 rounded-full text-xs sm:text-sm">
                        <i class="fas fa-calendar-alt mr-1 sm:mr-2 text-xs sm:text-sm"></i> Tahun Ajaran 2026/2027
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white bg-opacity-20 rounded-full text-xs sm:text-sm">
                        <i class="fas fa-map-marker-alt mr-1 sm:mr-2 text-xs sm:text-sm"></i> Provinsi Jawa Barat
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">
        @php
            $setting = App\Models\SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
            $now = now();

            // Cek pendaftaran: pastikan setting ada DAN tanggal tidak null
            $isPendaftaranOpen = $setting && 
                                $setting->pendaftaran_mulai && 
                                $setting->pendaftaran_selesai && 
                                $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);

            // Cek pengumuman: pastikan setting ada DAN tanggal tidak null (Ini yang bikin error tadi)
            $isPengumumanOpen = $setting && 
                                $setting->pengumuman_mulai && 
                                $setting->pengumuman_selesai && 
                                $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);

            $isPublished = $setting && $setting->is_published;
            
            $settingData = $setting ? [
                'pendaftaran_mulai' => $setting->pendaftaran_mulai,
                'pendaftaran_selesai' => $setting->pendaftaran_selesai,
                'pengumuman_mulai' => $setting->pengumuman_mulai,
                'pengumuman_selesai' => $setting->pengumuman_selesai,
                'is_published' => (bool) $setting->is_published,
            ] : null;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8 sm:mb-10">
            <!-- Status Pendaftaran -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg p-4 sm:p-6 border-l-4 {{ $isPendaftaranOpen ? 'border-green-500' : 'border-gray-300' }}">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 {{ $isPendaftaranOpen ? 'bg-green-100' : 'bg-gray-100' }} rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                        <i class="fas {{ $isPendaftaranOpen ? 'fa-door-open text-green-600' : 'fa-door-closed text-gray-600' }} text-lg sm:text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base">Pendaftaran</h3>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">
                            @if($isPendaftaranOpen)
                                <span class="text-green-600 font-medium">Buka</span>
                            @elseif($setting && $now->lt($setting->pendaftaran_mulai))
                                <span class="text-yellow-600 font-medium">Belum Dibuka</span>
                            @else
                                <span class="text-red-600 font-medium">Tutup</span>
                            @endif
                        </p>
                        @if($setting)
                        <p class="text-gray-500 text-xs mt-1 truncate">
                            {{ $setting->pendaftaran_mulai->translatedFormat('d M Y') }} - {{ $setting->pendaftaran_selesai->translatedFormat('d M Y') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Pengumuman -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg p-4 sm:p-6 border-l-4 {{ $isPengumumanOpen && $isPublished ? 'border-blue-500' : 'border-gray-300' }}">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 {{ $isPengumumanOpen && $isPublished ? 'bg-blue-100' : 'bg-gray-100' }} rounded-lg mr-3 sm:mr-4 flex-shrink-0">
                        <i class="fas {{ $isPengumumanOpen && $isPublished ? 'fa-bullhorn text-blue-600' : 'fa-volume-mute text-gray-600' }} text-lg sm:text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-900 text-sm sm:text-base">Pengumuman</h3>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">
                            @if($isPengumumanOpen && $isPublished)
                                <span class="text-blue-600 font-medium">Dibuka</span>
                            @elseif($isPengumumanOpen && !$isPublished)
                                <span class="text-yellow-600 font-medium">Menunggu Publikasi</span>
                            @else
                                <span class="text-gray-600 font-medium">Belum Waktunya</span>
                            @endif
                        </p>
                        @if($setting && $setting->pengumuman_mulai)
                            <p class="text-gray-500 text-xs mt-1 truncate">
                                {{ $setting->pengumuman_mulai?->translatedFormat('d M Y, H:i') }} - {{ $setting->pengumuman_selesai?->translatedFormat('d M Y, H:i') }}
                            </p>
                        @else
                            <p class="text-gray-400 text-xs mt-1 italic">
                                Jadwal pengumuman belum tersedia.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8 sm:mb-12">
            <!-- Card Pendaftaran -->
            <div class="bg-gradient-to-br from-white to-blue-50 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl overflow-hidden border border-blue-100">
                <div class="p-4 sm:p-6 md:p-8">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 md:h-14 md:w-14 bg-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center mr-3 sm:mr-5 flex-shrink-0">
                            <i class="fas fa-file-signature text-blue-600 text-lg sm:text-xl md:text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Pendaftaran</h3>
                            <p class="text-gray-600 text-sm">Daftarkan calon siswa Anda</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Siapkan dokumen lengkap (KK, Akta Kelahiran)</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Pilih jalur sesuai ketentuan SPMB</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Isi formulir dengan data yang benar</p>
                        </div>
                    </div>
                    
                    @if($isPendaftaranOpen)
                        <a href="{{ route('spmb.pendaftaran') }}" 
                           class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 sm:py-4 px-4 sm:px-6 rounded-lg text-center transition duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <i class="fas fa-pen-alt mr-2 sm:mr-3"></i> Daftar Sekarang
                        </a>
                        <p class="text-center text-gray-600 text-xs sm:text-sm mt-2 sm:mt-3">
                            Periode: {{ $setting->pendaftaran_mulai->translatedFormat('d M Y') }} - {{ $setting->pendaftaran_selesai->translatedFormat('d M Y') }}
                        </p>
                    @elseif($setting && $now->lt($setting->pendaftaran_mulai))
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4 text-center">
                            <i class="fas fa-clock text-yellow-600 text-xl sm:text-2xl mb-1 sm:mb-2"></i>
                            <p class="text-yellow-800 font-medium text-sm sm:text-base">Pendaftaran akan dibuka pada</p>
                            <p class="text-yellow-900 font-bold text-base sm:text-lg mt-1">
                                {{ $setting->pendaftaran_mulai->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    @else
                        <div class="bg-gray-100 border border-gray-300 rounded-lg p-3 sm:p-4 text-center">
                            <i class="fas fa-calendar-times text-gray-600 text-xl sm:text-2xl mb-1 sm:mb-2"></i>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">Pendaftaran telah ditutup</p>
                            <p class="text-gray-600 text-xs sm:text-sm mt-2">
                                {{ $setting ? 'Periode pendaftaran telah berakhir' : 'Tunggu pengumuman berikutnya' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Pengumuman -->
            <div class="bg-gradient-to-br from-white to-green-50 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl overflow-hidden border border-green-100">
                <div class="p-4 sm:p-6 md:p-8">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 md:h-14 md:w-14 bg-green-100 rounded-lg sm:rounded-xl flex items-center justify-center mr-3 sm:mr-5 flex-shrink-0">
                            <i class="fas fa-bullhorn text-green-600 text-lg sm:text-xl md:text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">Pengumuman</h3>
                            <p class="text-gray-600 text-sm">Cek hasil seleksi</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Hasil seleksi diumumkan sesuai jadwal</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Cek dengan No. Pendaftaran & NIK</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5 sm:mt-1 mr-2 sm:mr-3 text-xs sm:text-sm"></i>
                            <p class="text-gray-700 text-xs sm:text-sm">Hasil bersifat final dan tidak dapat diganggu gugat</p>
                        </div>
                    </div>
                    
                    @if($isPengumumanOpen && $isPublished)
                        <a href="{{ route('spmb.pengumuman') }}" 
                           class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 sm:py-4 px-4 sm:px-6 rounded-lg text-center transition duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <i class="fas fa-search mr-2 sm:mr-3"></i> Cek Hasil Seleksi
                        </a>
                        <p class="text-center text-gray-600 text-xs sm:text-sm mt-2 sm:mt-3">
                            Pengumuman sampai: {{ $setting->pengumuman_selesai->translatedFormat('d M Y') }}
                        </p>
                    @elseif($isPengumumanOpen && !$isPublished)
                        <!-- COUNTDOWN BUTTON -->
                        <a href="{{ route('spmb.countdown') }}" 
                           class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 sm:py-4 px-4 sm:px-6 rounded-lg text-center transition duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base mb-3 sm:mb-4">
                            <i class="fas fa-clock mr-2 sm:mr-3"></i> Lihat Countdown Pengumuman
                        </a>
                        
                        <!-- INLINE COUNTDOWN SECTION -->
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-lg sm:rounded-xl p-4 sm:p-6 text-center">
                            <div class="flex items-center justify-center mb-3 sm:mb-4">
                                <div class="p-2 sm:p-3 bg-purple-100 rounded-full mr-2 sm:mr-3">
                                    <i class="fas fa-clock text-purple-600 text-lg sm:text-xl"></i>
                                </div>
                                <h4 class="text-base sm:text-lg font-bold text-purple-800 truncate">Pengumuman Segera Dirilis</h4>
                            </div>
                            
                            <div id="countdownContainer" class="mb-3 sm:mb-4">
                                <div class="text-purple-900 font-bold text-base sm:text-lg mb-1 sm:mb-2" id="countdownMessage">Menunggu Waktu Pengumuman</div>
                                <div class="flex justify-center gap-2 sm:gap-3" id="countdownTimer">
                                    <!-- Countdown akan ditampilkan di sini -->
                                </div>
                            </div>
                            
                            <p class="text-purple-700 text-xs sm:text-sm">Panitia sedang mempersiapkan pengumuman</p>
                        </div>
                    @else
                        <div class="bg-gray-100 border border-gray-300 rounded-lg p-3 sm:p-4 text-center">
                            <i class="fas fa-clock text-gray-600 text-xl sm:text-2xl mb-1 sm:mb-2"></i>
                            <p class="text-gray-800 font-medium text-sm sm:text-base">Belum Waktu Pengumuman</p>
                            <p class="text-gray-600 text-xs sm:text-sm mt-2">
                                @if($setting && $setting->pengumuman_mulai)
                                    Pengumuman dimulai: {{ $setting->pengumuman_mulai->translatedFormat('d M Y, H:i') }}
                                @else
                                    Jadwal akan diumumkan kemudian
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Jalur -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 mb-8 sm:mb-12">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 text-center">Jalur Pendaftaran SPMB 2026/2027</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg sm:rounded-xl p-4 sm:p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-3 sm:mb-4">
                        <div class="p-2 sm:p-3 bg-blue-600 rounded-lg mr-2 sm:mr-4 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-sm sm:text-base"></i>
                        </div>
                        <h4 class="font-bold text-blue-800 text-sm sm:text-base">Zonasi</h4>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-sm mb-2 sm:mb-3">Berdasarkan domisili sesuai zona sekolah</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium px-2 py-1 bg-blue-200 text-blue-800 rounded">Kuota 50%</span>
                        <span class="text-xs text-gray-500">Minimal</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg sm:rounded-xl p-4 sm:p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-3 sm:mb-4">
                        <div class="p-2 sm:p-3 bg-green-600 rounded-lg mr-2 sm:mr-4 flex-shrink-0">
                            <i class="fas fa-hands-helping text-white text-sm sm:text-base"></i>
                        </div>
                        <h4 class="font-bold text-green-800 text-sm sm:text-base">Afirmasi</h4>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-sm mb-2 sm:mb-3">Keluarga kurang mampu dengan bukti valid</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium px-2 py-1 bg-green-200 text-green-800 rounded">Kuota 15%</span>
                        <span class="text-xs text-gray-500">Minimal</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-lg sm:rounded-xl p-4 sm:p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-3 sm:mb-4">
                        <div class="p-2 sm:p-3 bg-purple-600 rounded-lg mr-2 sm:mr-4 flex-shrink-0">
                            <i class="fas fa-trophy text-white text-sm sm:text-base"></i>
                        </div>
                        <h4 class="font-bold text-purple-800 text-sm sm:text-base">Prestasi</h4>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-sm mb-2 sm:mb-3">Prestasi akademik/non-akademik</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium px-2 py-1 bg-purple-200 text-purple-800 rounded">Kuota 30%</span>
                        <span class="text-xs text-gray-500">Maksimal</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 rounded-lg sm:rounded-xl p-4 sm:p-6 hover:shadow-lg transition">
                    <div class="flex items-center mb-3 sm:mb-4">
                        <div class="p-2 sm:p-3 bg-orange-600 rounded-lg mr-2 sm:mr-4 flex-shrink-0">
                            <i class="fas fa-exchange-alt text-white text-sm sm:text-base"></i>
                        </div>
                        <h4 class="font-bold text-orange-800 text-sm sm:text-base">Mutasi</h4>
                    </div>
                    <p class="text-gray-700 text-xs sm:text-sm mb-2 sm:mb-3">Orang tua siswa pindah tugas</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium px-2 py-1 bg-orange-200 text-orange-800 rounded">Kuota 5%</span>
                        <span class="text-xs text-gray-500">Maksimal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Pendaftaran -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 mb-8 sm:mb-12">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 sm:mb-8 text-center">Alur Pendaftaran</h3>
            <div class="relative">
                <!-- Timeline Line untuk Desktop -->
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-blue-200 hidden md:block"></div>
                
                <div class="space-y-8 md:space-y-0">
                    <!-- Step 1 - Mobile/Desktop -->
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 md:pr-8 lg:pr-12 md:text-right mb-4 md:mb-0">
                            <div class="bg-gradient-to-r from-blue-100 to-blue-50 p-4 sm:p-6 rounded-lg sm:rounded-xl border border-blue-200">
                                <div class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-blue-600 text-white rounded-full mb-3 sm:mb-4">
                                    <span class="font-bold text-sm sm:text-base">1</span>
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm sm:text-base md:text-lg mb-2">Persiapan Dokumen</h4>
                                <p class="text-gray-700 text-xs sm:text-sm">Siapkan dokumen lengkap: Kartu Keluarga, Akta Kelahiran, dan dokumen pendukung sesuai jalur.</p>
                            </div>
                        </div>
                        <div class="md:w-4 md:mx-4 flex justify-center my-4 md:my-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="md:w-1/2 md:pl-8 lg:pl-12"></div>
                    </div>

                    <!-- Step 2 - Mobile/Desktop -->
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 md:pr-8 lg:pr-12"></div>
                        <div class="md:w-4 md:mx-4 flex justify-center my-4 md:my-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="md:w-1/2 md:pl-8 lg:pl-12">
                            <div class="bg-gradient-to-r from-green-100 to-green-50 p-4 sm:p-6 rounded-lg sm:rounded-xl border border-green-200">
                                <div class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-green-600 text-white rounded-full mb-3 sm:mb-4">
                                    <span class="font-bold text-sm sm:text-base">2</span>
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm sm:text-base md:text-lg mb-2">Isi Formulir Online</h4>
                                <p class="text-gray-700 text-xs sm:text-sm">Akses formulir pendaftaran selama periode dibuka, isi data dengan benar dan lengkap.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 - Mobile/Desktop -->
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 md:pr-8 lg:pr-12 md:text-right">
                            <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-4 sm:p-6 rounded-lg sm:rounded-xl border border-purple-200">
                                <div class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-purple-600 text-white rounded-full mb-3 sm:mb-4">
                                    <span class="font-bold text-sm sm:text-base">3</span>
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm sm:text-base md:text-lg mb-2">Verifikasi Admin</h4>
                                <p class="text-gray-700 text-xs sm:text-sm">Tim admin akan memverifikasi data dan dokumen yang telah diunggah.</p>
                            </div>
                        </div>
                        <div class="md:w-4 md:mx-4 flex justify-center my-4 md:my-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="md:w-1/2 md:pl-8 lg:pl-12"></div>
                    </div>

                    <!-- Step 4 - Mobile/Desktop -->
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2 md:pr-8 lg:pr-12"></div>
                        <div class="md:w-4 md:mx-4 flex justify-center my-4 md:my-0">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                            </div>
                        </div>
                        <div class="md:w-1/2 md:pl-8 lg:pl-12">
                            <div class="bg-gradient-to-r from-orange-100 to-orange-50 p-4 sm:p-6 rounded-lg sm:rounded-xl border border-orange-200">
                                <div class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-orange-600 text-white rounded-full mb-3 sm:mb-4">
                                    <span class="font-bold text-sm sm:text-base">4</span>
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm sm:text-base md:text-lg mb-2">Cek Hasil Seleksi</h4>
                                <p class="text-gray-700 text-xs sm:text-sm">Hasil seleksi dapat dicek sesuai jadwal pengumuman yang telah ditentukan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 sm:mb-8 text-center">Pertanyaan yang Sering Diajukan</h3>
            <div class="space-y-3 sm:space-y-4">
                <div class="border border-gray-200 rounded-lg">
                    <button class="faq-question w-full px-4 sm:px-6 py-3 sm:py-4 text-left font-medium text-gray-900 hover:bg-gray-50 rounded-lg transition text-sm sm:text-base">
                        <div class="flex items-center justify-between">
                            <span>Kapan pendaftaran dibuka?</span>
                            <i class="fas fa-chevron-down transition-transform text-xs sm:text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer px-4 sm:px-6 py-3 sm:py-4 text-gray-700 border-t border-gray-200 hidden text-xs sm:text-sm">
                        <p>Pendaftaran dibuka sesuai jadwal yang ditentukan pada bagian Status Pendaftaran di atas. Pastikan untuk memeriksa secara berkala.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <button class="faq-question w-full px-4 sm:px-6 py-3 sm:py-4 text-left font-medium text-gray-900 hover:bg-gray-50 rounded-lg transition text-sm sm:text-base">
                        <div class="flex items-center justify-between">
                            <span>Apa saja dokumen yang diperlukan?</span>
                            <i class="fas fa-chevron-down transition-transform text-xs sm:text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer px-4 sm:px-6 py-3 sm:py-4 text-gray-700 border-t border-gray-200 hidden text-xs sm:text-sm">
                        <p>Dokumen wajib: Kartu Keluarga, Akta Kelahiran, dan NIK. Dokumen tambahan disesuaikan dengan jalur pendaftaran yang dipilih.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <button class="faq-question w-full px-4 sm:px-6 py-3 sm:py-4 text-left font-medium text-gray-900 hover:bg-gray-50 rounded-lg transition text-sm sm:text-base">
                        <div class="flex items-center justify-between">
                            <span>Bagaimana cara cek pengumuman?</span>
                            <i class="fas fa-chevron-down transition-transform text-xs sm:text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer px-4 sm:px-6 py-3 sm:py-4 text-gray-700 border-t border-gray-200 hidden text-xs sm:text-sm">
                        <p>Pengumuman dapat dicek dengan memasukkan No. Pendaftaran dan NIK calon siswa pada halaman pengumuman yang tersedia.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg">
                    <button class="faq-question w-full px-4 sm:px-6 py-3 sm:py-4 text-left font-medium text-gray-900 hover:bg-gray-50 rounded-lg transition text-sm sm:text-base">
                        <div class="flex items-center justify-between">
                            <span>Apakah bisa mendaftar lebih dari satu jalur?</span>
                            <i class="fas fa-chevron-down transition-transform text-xs sm:text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-answer px-4 sm:px-6 py-3 sm:py-4 text-gray-700 border-t border-gray-200 hidden text-xs sm:text-sm">
                        <p>Tidak, setiap calon siswa hanya dapat mendaftar melalui satu jalur sesuai dengan ketentuan yang berlaku.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 mt-8 sm:mt-12 py-8 sm:py-12 text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-xl sm:text-2xl font-bold mb-3 sm:mb-4">Butuh Bantuan?</h3>
                <p class="text-blue-100 mb-6 sm:mb-8 text-sm sm:text-base">Hubungi tim SPMB kami untuk informasi lebih lanjut</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                    <div class="flex items-center justify-center sm:justify-start">
                        <i class="fas fa-phone-alt text-lg sm:text-xl mr-2 sm:mr-3"></i>
                        <div class="text-left">
                            <p class="text-xs sm:text-sm text-blue-200">Telepon</p>
                            <p class="font-bold text-sm sm:text-base">(022) 123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start">
                        <i class="fab fa-whatsapp text-lg sm:text-xl mr-2 sm:mr-3"></i>
                        <div class="text-left">
                            <p class="text-xs sm:text-sm text-blue-200">WhatsApp</p>
                            <p class="font-bold text-sm sm:text-base">0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center sm:justify-start">
                        <i class="fas fa-envelope text-lg sm:text-xl mr-2 sm:mr-3"></i>
                        <div class="text-left">
                            <p class="text-xs sm:text-sm text-blue-200">Email</p>
                            <p class="font-bold text-sm sm:text-base">spmb@tksceriabangsa.sch.id</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styles for responsive design */
    @media (max-width: 640px) {
        /* Timeline mobile adjustments */
        .md\\:hidden + .md\\:w-4 {
            margin: 16px 0;
        }
        
        /* Improve touch targets */
        button, a {
            min-height: 44px;
        }
        
        /* FAQ animation */
        .faq-answer {
            transition: all 0.3s ease;
        }
        
        /* Contact section stacking */
        .contact-item {
            width: 100%;
            margin-bottom: 16px;
        }
        
        /* Jalur cards */
        .grid-cols-1 > div {
            margin-bottom: 16px;
        }
    }
    
    @media (max-width: 768px) {
        /* Timeline vertical for mobile */
        .timeline-step {
            width: 100%;
            margin-bottom: 24px;
        }
        
        /* Action cards stacking */
        .lg\\:grid-cols-2 > div {
            margin-bottom: 24px;
        }
        
        /* Status cards stacking */
        .sm\\:grid-cols-2 > div {
            margin-bottom: 16px;
        }
    }
    
    /* Print styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .bg-gradient-to-b {
            background: white !important;
        }
        
        .shadow-lg, .shadow-xl, .shadow-md {
            box-shadow: none !important;
        }
        
        .border {
            border: 1px solid #ddd !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Data setting untuk countdown
const settingDataJson = {!! json_encode($settingData) !!};
const isPengumumanOpen = {{ json_encode($isPengumumanOpen) }};
const isPublished = {{ json_encode($isPublished) }};

document.addEventListener('DOMContentLoaded', function() {
    // FAQ Toggle
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            // Toggle answer visibility
            answer.classList.toggle('hidden');
            
            // Toggle icon
            if (icon.classList.contains('fa-chevron-down')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
            
            // Close other FAQ items on mobile
            if (window.innerWidth < 768) {
                document.querySelectorAll('.faq-question').forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherAnswer = otherButton.nextElementSibling;
                        const otherIcon = otherButton.querySelector('i');
                        otherAnswer.classList.add('hidden');
                        otherIcon.classList.remove('fa-chevron-up');
                        otherIcon.classList.add('fa-chevron-down');
                    }
                });
            }
        });
    });

    // Countdown untuk Pengumuman - FIXED VERSION
    if (isPengumumanOpen && !isPublished && settingDataJson && settingDataJson.pengumuman_mulai) {
        // Parse waktu dari server (UTC) dan konversi ke waktu lokal browser
        const pengumumanMulaiUTC = new Date(settingDataJson.pengumuman_mulai);
        const nowUTC = new Date();
        
        // Hitung waktu UTC untuk menghindari perbedaan zona waktu
        const targetTime = pengumumanMulaiUTC.getTime();
        const serverTime = nowUTC.getTime();
        
        function updatePengumumanCountdown() {
            const now = new Date().getTime();
            const serverNow = serverTime + (now - Date.now()); // Sync dengan waktu server
            const diff = targetTime - serverNow;
            
            // Jika countdown sudah berakhir
            if (diff <= 0) {
                const container = document.getElementById('countdownContainer');
                if (container) {
                    container.innerHTML = 
                        '<div class="text-center">' +
                        '<div class="text-green-600 font-bold text-base sm:text-lg mb-2">Waktu Pengumuman Telah Tiba!</div>' +
                        '<div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-green-600 mb-3"></div>' +
                        '<p class="text-gray-600 text-xs sm:text-sm">Mengarahkan ke halaman pengumuman...</p>' +
                        '</div>';
                }
                
                // Redirect ke halaman pengumuman setelah 3 detik
                setTimeout(() => {
                    window.location.href = "{{ route('spmb.pengumuman') }}?check=" + new Date().getTime();
                }, 3000);
                
                return;
            }
            
            // Hitung waktu tersisa
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            // Update UI
            const messageElement = document.getElementById('countdownMessage');
            if (messageElement) {
                messageElement.textContent = 'Pengumuman dimulai dalam:';
            }
            
            const timerElement = document.getElementById('countdownTimer');
            if (timerElement) {
                const isMobile = window.innerWidth < 640;
                const boxClass = isMobile ? 'px-2 py-1 text-base min-w-[40px]' : 'px-3 py-2 text-xl min-w-[50px]';
                const labelClass = isMobile ? 'text-xs' : 'text-xs sm:text-sm';
                
                timerElement.innerHTML = `
                    <div class="text-center">
                        <div class="bg-purple-600 text-white font-bold rounded-lg ${boxClass}">
                            ${String(days).padStart(2, '0')}
                        </div>
                        <div class="${labelClass} text-purple-700 mt-1 font-medium">Hari</div>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 text-white font-bold rounded-lg ${boxClass}">
                            ${String(hours).padStart(2, '0')}
                        </div>
                        <div class="${labelClass} text-purple-700 mt-1 font-medium">Jam</div>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 text-white font-bold rounded-lg ${boxClass}">
                            ${String(minutes).padStart(2, '0')}
                        </div>
                        <div class="${labelClass} text-purple-700 mt-1 font-medium">Menit</div>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 text-white font-bold rounded-lg ${boxClass}">
                            ${String(seconds).padStart(2, '0')}
                        </div>
                        <div class="${labelClass} text-purple-700 mt-1 font-medium">Detik</div>
                    </div>
                `;
            }
        }
        
        // Jalankan dan update setiap detik
        updatePengumumanCountdown();
        const countdownInterval = setInterval(updatePengumumanCountdown, 1000);
        
        // Cleanup interval on page unload
        window.addEventListener('beforeunload', () => {
            clearInterval(countdownInterval);
        });
    }
    
    // Mobile optimizations
    if (window.innerWidth < 768) {
        // Smooth scroll for FAQ
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                setTimeout(() => {
                    this.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            });
        });
        
        // Add scroll hint for timeline on mobile
        const timelineSection = document.querySelector('.relative');
        if (timelineSection && !timelineSection.querySelector('.scroll-hint')) {
            const hint = document.createElement('div');
            hint.className = 'text-center text-xs text-gray-500 py-2 bg-gray-50 rounded-lg mt-4';
            hint.innerHTML = '<i class="fas fa-arrows-alt-v mr-1"></i> Scroll untuk melihat alur lengkap';
            timelineSection.appendChild(hint);
        }
    }
    
    // Resize handler
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            @if($isPengumumanOpen && !$isPublished)
            updatePengumumanCountdown();
            @endif
        }, 250);
    });
});
</script>
@endpush