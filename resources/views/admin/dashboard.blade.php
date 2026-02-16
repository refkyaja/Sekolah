@extends('layouts.admin')

@section('title', 'Dashboard Admin - TK Harapan Bangsa 1')

@section('content')
<!-- Welcome Banner -->
<div class="mb-4 sm:mb-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-4 sm:p-6 text-white shadow-lg">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-1 sm:mb-2">Selamat Datang di Dashboard!</h2>
            <p class="text-indigo-100 text-sm sm:text-base">Semua aktivitas sekolah dapat Anda pantau dari sini</p>
        </div>
        <div class="hidden sm:block">
            <i class="fas fa-chart-line text-3xl sm:text-4xl opacity-50"></i>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Siswa Aktif Card - Link ke Siswa Aktif -->
    <a href="{{ route('admin.siswa.siswa-aktif.index') }}" class="block">
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg shadow">
                    <i class="fas fa-users text-white text-lg sm:text-xl md:text-2xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm text-gray-500">Siswa Aktif</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['siswa_aktif'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                    <i class="fas fa-arrow-right text-blue-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                    <span>Kelola siswa aktif</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Siswa Lulus Card - Link ke Siswa Lulus -->
    <a href="{{ route('admin.siswa.siswa-lulus.index') }}" class="block">
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg shadow">
                    <i class="fas fa-graduation-cap text-white text-lg sm:text-xl md:text-2xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm text-gray-500">Siswa Lulus</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['siswa_lulus'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                    <i class="fas fa-arrow-right text-green-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                    <span>Lihat alumni</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Total Siswa Card - Link ke Semua Siswa -->
    <a href="{{ route('admin.siswa.siswa-aktif.index') }}" class="block">
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow">
                    <i class="fas fa-address-book text-white text-lg sm:text-xl md:text-2xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm text-gray-500">Total Siswa</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total_siswa'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                    <i class="fas fa-arrow-right text-purple-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                    <span>Semua data siswa</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Guru Card -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg shadow">
                <i class="fas fa-chalkboard-teacher text-white text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Total Guru</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total_guru'] ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <i class="fas fa-user-check text-blue-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                <span>Pengajar aktif</span>
            </div>
        </div>
    </div>
</div>

<!-- Second Row Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- SPMB Card -->
    <a href="{{ route('admin.spmb.index') }}" class="block">
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg shadow">
                    <i class="fas fa-user-plus text-white text-lg sm:text-xl md:text-2xl"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm text-gray-500">Pendaftaran Baru</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['pendaftaran_baru'] ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                <div class="grid grid-cols-3 gap-1 sm:gap-2 text-xs">
                    <div class="text-center">
                        <div class="font-bold text-yellow-600">{{ $stats['spmb_menunggu'] ?? 0 }}</div>
                        <div class="text-gray-500 text-xs">Menunggu</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-green-600">{{ $stats['spmb_diterima'] ?? 0 }}</div>
                        <div class="text-gray-500 text-xs">Diterima</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-red-600">{{ $stats['spmb_mundur'] ?? 0 }}</div>
                        <div class="text-gray-500 text-xs">Mundur</div>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Admin Card -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow">
                <i class="fas fa-user-shield text-white text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Total Admin</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['total_admin'] ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <i class="fas fa-shield-alt text-purple-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                <span>Akses penuh sistem</span>
            </div>
        </div>
    </div>

    <!-- Kelompok A Card -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg shadow">
                <i class="fas fa-child text-white text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Kelompok A</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['kelompok_a'] ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <i class="fas fa-calendar-alt text-blue-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                <span>Usia 4-5 tahun</span>
            </div>
        </div>
    </div>

    <!-- Kelompok B Card -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md p-4 sm:p-6 card-hover border border-gray-100">
        <div class="flex items-center">
            <div class="p-2 sm:p-3 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg shadow">
                <i class="fas fa-child text-white text-lg sm:text-xl md:text-2xl"></i>
            </div>
            <div class="ml-3 sm:ml-4">
                <p class="text-xs sm:text-sm text-gray-500">Kelompok B</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['kelompok_b'] ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <i class="fas fa-calendar-alt text-green-500 mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                <span>Usia 5-6 tahun</span>
            </div>
        </div>
    </div>
</div>

<!-- Two Columns Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Recent Pendaftaran -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md border border-gray-100 overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Pendaftaran Terbaru</h2>
                <a href="{{ route('admin.spmb.index') }}" 
                   class="text-xs sm:text-sm text-indigo-600 hover:text-indigo-800 font-medium self-end sm:self-auto">
                    Lihat semua →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Calon Siswa
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Tanggal
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Status
                            </th>
                            <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(($recent_pendaftaran ?? []) as $pendaftaran)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-6 w-6 sm:h-8 sm:w-8 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold text-xs sm:text-sm">
                                            {{ strtoupper(substr($pendaftaran->nama_lengkap_anak ?? '', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="ml-2 sm:ml-3">
                                        <div class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-none">
                                            {{ $pendaftaran->nama_lengkap_anak ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="text-xs sm:text-sm text-gray-900">
                                    {{ isset($pendaftaran->created_at) ? $pendaftaran->created_at->format('d/m/Y') : '-' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ isset($pendaftaran->created_at) ? $pendaftaran->created_at->format('H:i') : '' }}
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                @if(isset($pendaftaran->status_pendaftaran))
                                    @if($pendaftaran->status_pendaftaran == 'Menunggu Verifikasi')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1 text-xs"></i> Menunggu
                                        </span>
                                    @elseif($pendaftaran->status_pendaftaran == 'Diterima')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1 text-xs"></i> Diterima
                                        </span>
                                    @elseif($pendaftaran->status_pendaftaran == 'Mundur')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1 text-xs"></i> Mundur
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $pendaftaran->status_pendaftaran }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <a href="{{ route('admin.spmb.show', $pendaftaran->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 sm:px-6 py-8 text-center">
                                <div class="text-gray-400 mb-2">
                                    <i class="fas fa-user-plus text-2xl sm:text-3xl"></i>
                                </div>
                                <p class="text-gray-500 text-sm">Belum ada pendaftaran</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Distribusi Siswa -->
    <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md border border-gray-100 overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Distribusi Siswa per Kelompok</h2>
        </div>
        <div class="p-4 sm:p-6">
            @if(($stats['kelompok_a'] ?? 0) > 0 || ($stats['kelompok_b'] ?? 0) > 0)
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4 md:space-x-8">
                <!-- Kelompok A -->
                <div class="text-center w-full sm:w-auto">
                    <div class="relative w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 mx-auto mb-3 sm:mb-4">
                        @php
                            $totalKelompok = ($stats['kelompok_a'] ?? 0) + ($stats['kelompok_b'] ?? 0);
                            $persenA = $totalKelompok > 0 ? round(($stats['kelompok_a'] ?? 0) / $totalKelompok * 100) : 0;
                        @endphp
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                            <circle cx="18" cy="18" r="15.9155" fill="none" 
                                    stroke="#3b82f6" stroke-width="3"
                                    stroke-dasharray="{{ $persenA }}, 100"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xl sm:text-2xl md:text-3xl font-bold text-blue-600">
                                {{ $stats['kelompok_a'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                    <h3 class="font-bold text-base sm:text-lg text-blue-700">
                        Kelompok A
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                        Usia 4-5 Tahun ({{ $persenA }}%)
                    </p>
                </div>

                <!-- Kelompok B -->
                <div class="text-center w-full sm:w-auto">
                    <div class="relative w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 mx-auto mb-3 sm:mb-4">
                        @php
                            $persenB = $totalKelompok > 0 ? round(($stats['kelompok_b'] ?? 0) / $totalKelompok * 100) : 0;
                        @endphp
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                            <circle cx="18" cy="18" r="15.9155" fill="none" 
                                    stroke="#10b981" stroke-width="3"
                                    stroke-dasharray="{{ $persenB }}, 100"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xl sm:text-2xl md:text-3xl font-bold text-green-600">
                                {{ $stats['kelompok_b'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                    <h3 class="font-bold text-base sm:text-lg text-green-700">
                        Kelompok B
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                        Usia 5-6 Tahun ({{ $persenB }}%)
                    </p>
                </div>
            </div>

            <!-- Gender Distribution -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-sm text-gray-600 mb-1">Laki-laki</div>
                        <div class="flex items-center justify-center">
                            <span class="text-xl font-bold text-blue-600">{{ $stats['laki_laki'] ?? 0 }}</span>
                            @php $totalGender = ($stats['laki_laki'] ?? 0) + ($stats['perempuan'] ?? 0); @endphp
                            <span class="text-xs text-gray-500 ml-2">
                                ({{ $totalGender > 0 ? round(($stats['laki_laki'] ?? 0) / $totalGender * 100) : 0 }}%)
                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-600 mb-1">Perempuan</div>
                        <div class="flex items-center justify-center">
                            <span class="text-xl font-bold text-pink-600">{{ $stats['perempuan'] ?? 0 }}</span>
                            <span class="text-xs text-gray-500 ml-2">
                                ({{ $totalGender > 0 ? round(($stats['perempuan'] ?? 0) / $totalGender * 100) : 0 }}%)
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="h-48 sm:h-64 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-users text-3xl sm:text-4xl text-gray-300 mb-2 sm:mb-3"></i>
                    <p class="text-gray-500 text-sm">Belum ada data siswa</p>
                    <p class="text-xs text-gray-400 mt-1">Data akan muncul setelah siswa terdaftar</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow-md border border-gray-100 p-4 sm:p-6 mb-6 sm:mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-2 sm:gap-0">
        <h2 class="text-base sm:text-lg font-semibold text-gray-900">Aksi Cepat</h2>
        <span class="text-xs sm:text-sm text-gray-500">Pintasan untuk tugas rutin</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <a href="{{ route('admin.siswa.siswa-aktif.create') }}" 
           class="group flex items-center p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border border-blue-200 rounded-lg sm:rounded-xl transition-all duration-300 hover:shadow-md">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-plus text-white text-base sm:text-xl"></i>
                </div>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="font-semibold text-gray-900 text-sm sm:text-base group-hover:text-blue-600 transition-colors duration-300">
                    Tambah Siswa Aktif
                </h3>
                <p class="text-xs sm:text-sm text-gray-600">Input data siswa baru</p>
            </div>
        </a>
        
        <a href="{{ route('admin.guru.create') }}" 
           class="group flex items-center p-3 sm:p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 border border-green-200 rounded-lg sm:rounded-xl transition-all duration-300 hover:shadow-md">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-tie text-white text-base sm:text-xl"></i>
                </div>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="font-semibold text-gray-900 text-sm sm:text-base group-hover:text-green-600 transition-colors duration-300">
                    Tambah Guru
                </h3>
                <p class="text-xs sm:text-sm text-gray-600">Tambah data pengajar</p>
            </div>
        </a>
        
        <a href="{{ route('admin.spmb.create') }}" 
           class="group flex items-center p-3 sm:p-4 bg-gradient-to-r from-amber-50 to-orange-100 hover:from-amber-100 hover:to-orange-200 border border-amber-200 rounded-lg sm:rounded-xl transition-all duration-300 hover:shadow-md">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-file-alt text-white text-base sm:text-xl"></i>
                </div>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="font-semibold text-gray-900 text-sm sm:text-base group-hover:text-amber-600 transition-colors duration-300">
                    Tambah SPMB
                </h3>
                <p class="text-xs sm:text-sm text-gray-600">Input pendaftaran manual</p>
            </div>
        </a>

        <a href="{{ route('admin.siswa.export') }}" 
           class="group flex items-center p-3 sm:p-4 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border border-purple-200 rounded-lg sm:rounded-xl transition-all duration-300 hover:shadow-md">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-download text-white text-base sm:text-xl"></i>
                </div>
            </div>
            <div class="ml-3 sm:ml-4">
                <h3 class="font-semibold text-gray-900 text-sm sm:text-base group-hover:text-purple-600 transition-colors duration-300">
                    Export Data
                </h3>
                <p class="text-xs sm:text-sm text-gray-600">Download laporan siswa</p>
            </div>
        </a>
    </div>
</div>

<!-- System Status -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg sm:rounded-xl p-4 sm:p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Status Sistem</h3>
            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                <i class="fas fa-circle text-xs mr-1"></i> Online
            </span>
        </div>
        <div class="space-y-2 sm:space-y-3">
            <div class="flex items-center justify-between text-xs sm:text-sm">
                <span class="text-gray-600">Database</span>
                <span class="font-medium text-green-600">✓ Aktif</span>
            </div>
            <div class="flex items-center justify-between text-xs sm:text-sm">
                <span class="text-gray-600">Server</span>
                <span class="font-medium text-green-600">✓ Normal</span>
            </div>
            <div class="flex items-center justify-between text-xs sm:text-sm">
                <span class="text-gray-600">Backup</span>
                <span class="font-medium text-blue-600">24 Jam</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg sm:rounded-xl p-4 sm:p-6 border border-gray-200">
        <h3 class="font-semibold text-gray-900 text-sm sm:text-base mb-3 sm:mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-2 sm:space-y-3">
            <div class="flex items-center text-xs sm:text-sm">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 sm:mr-3"></div>
                <span class="text-gray-600 flex-1 truncate">Login berhasil</span>
                <span class="ml-2 text-gray-500 text-xs">Baru saja</span>
            </div>
            <div class="flex items-center text-xs sm:text-sm">
                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2 sm:mr-3"></div>
                <span class="text-gray-600 flex-1 truncate">Dashboard diakses</span>
                <span class="ml-2 text-gray-500 text-xs">2 menit lalu</span>
            </div>
            @if(($stats['pendaftaran_baru'] ?? 0) > 0)
            <div class="flex items-center text-xs sm:text-sm">
                <div class="w-2 h-2 bg-amber-500 rounded-full mr-2 sm:mr-3"></div>
                <span class="text-gray-600 flex-1 truncate">{{ $stats['pendaftaran_baru'] }} pendaftaran baru</span>
                <span class="ml-2 text-gray-500 text-xs">Hari ini</span>
            </div>
            @endif
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg sm:rounded-xl p-4 sm:p-6 border border-gray-200 md:col-span-2 lg:col-span-1">
        <h3 class="font-semibold text-gray-900 text-sm sm:text-base mb-3 sm:mb-4">Panduan Cepat</h3>
        <div class="space-y-2 sm:space-y-3">
            <a href="#" class="flex items-center text-xs sm:text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-question-circle mr-2 text-xs sm:text-sm"></i>
                <span class="truncate">Cara verifikasi SPMB</span>
            </a>
            <a href="#" class="flex items-center text-xs sm:text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-question-circle mr-2 text-xs sm:text-sm"></i>
                <span class="truncate">Input data siswa baru</span>
            </a>
            <a href="#" class="flex items-center text-xs sm:text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-question-circle mr-2 text-xs sm:text-sm"></i>
                <span class="truncate">Export data siswa</span>
            </a>
            <a href="#" class="flex items-center text-xs sm:text-sm text-blue-600 hover:text-blue-800">
                <i class="fas fa-question-circle mr-2 text-xs sm:text-sm"></i>
                <span class="truncate">Manajemen status siswa</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Mobile responsiveness for tables */
    @media (max-width: 640px) {
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            margin-left: -1rem;
            margin-right: -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .overflow-x-auto > .min-w-full {
            min-width: 640px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to stats cards on hover
        document.querySelectorAll('.card-hover').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Quick action cards animation
        const quickActionCards = document.querySelectorAll('.group');
        quickActionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const iconDiv = this.querySelector('.flex-shrink-0 div');
                if (iconDiv) {
                    iconDiv.classList.add('scale-110');
                }
            });
            
            card.addEventListener('mouseleave', function() {
                const iconDiv = this.querySelector('.flex-shrink-0 div');
                if (iconDiv) {
                    iconDiv.classList.remove('scale-110');
                }
            });
        });

        // Dashboard chart animations
        function animateCharts() {
            const charts = document.querySelectorAll('svg circle[stroke-dasharray]');
            charts.forEach(chart => {
                const dashArray = chart.getAttribute('stroke-dasharray');
                if (dashArray && dashArray !== '0, 100') {
                    // Reset animation
                    chart.style.strokeDasharray = '0, 100';
                    chart.style.transition = 'stroke-dasharray 1.5s ease-out';
                    
                    // Animate after a short delay
                    setTimeout(() => {
                        chart.style.strokeDasharray = dashArray;
                    }, 300);
                }
            });
        }

        // Animate charts when they come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCharts();
                }
            });
        }, { threshold: 0.5 });

        // Observe all chart containers
        document.querySelectorAll('.relative.w-24.h-24, .relative.w-28.h-28, .relative.w-32.h-32').forEach(chart => {
            observer.observe(chart);
        });

        // Mobile table responsiveness
        function adjustTableResponsiveness() {
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                const parent = table.closest('.overflow-x-auto');
                if (parent && window.innerWidth < 640) {
                    parent.style.overflowX = 'auto';
                    parent.style.paddingBottom = '12px';
                    parent.style.WebkitOverflowScrolling = 'touch';
                    
                    // Add scroll indicator if not exists
                    if (!parent.querySelector('.scroll-indicator')) {
                        const indicator = document.createElement('div');
                        indicator.className = 'scroll-indicator text-center text-xs text-gray-500 mt-2';
                        indicator.innerHTML = '<i class="fas fa-arrows-alt-h mr-1"></i>Geser untuk melihat lebih banyak';
                        parent.appendChild(indicator);
                    }
                }
            });
        }
        
        window.addEventListener('resize', adjustTableResponsiveness);
        adjustTableResponsiveness();

        // Keyboard shortcuts for dashboard
        document.addEventListener('keydown', function(e) {
            // Ctrl + 1 for dashboard
            if (e.ctrlKey && e.key === '1') {
                e.preventDefault();
                window.location.href = "{{ route('admin.dashboard') }}";
            }
            
            // Ctrl + 2 for students active
            if (e.ctrlKey && e.key === '2') {
                e.preventDefault();
                window.location.href = "{{ route('admin.siswa.siswa-aktif.index') }}";
            }
            
            // Ctrl + 3 for students graduated
            if (e.ctrlKey && e.key === '3') {
                e.preventDefault();
                window.location.href = "{{ route('admin.siswa.siswa-lulus.index') }}";
            }
            
            // Ctrl + 4 for teachers
            if (e.ctrlKey && e.key === '4') {
                e.preventDefault();
                window.location.href = "{{ route('admin.guru.index') }}";
            }
            
            // Ctrl + 5 for SPMB
            if (e.ctrlKey && e.key === '5') {
                e.preventDefault();
                window.location.href = "{{ route('admin.spmb.index') }}";
            }
            
            // Ctrl + R to refresh dashboard
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                window.location.reload();
            }
        });

        // Auto-refresh data every 5 minutes (300000 ms)
        setInterval(() => {
            console.log('Auto-refresh dashboard data');
            // You can add AJAX call here to refresh data without page reload
        }, 300000);
    });
</script>
@endpush