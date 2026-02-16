@extends('layouts.admin')

@section('title', 'Data Siswa Aktif')
@section('breadcrumb', 'Siswa Aktif')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <div class="max-w-full mx-auto">
        
        <!-- Quick Stats -->
        <div id="stats-container" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-5 card-hover">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-full mr-3 sm:mr-4">
                        <i class="fas fa-users text-blue-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm text-gray-500 truncate">Total Aktif</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-5 card-hover">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-green-100 rounded-full mr-3 sm:mr-4">
                        <i class="fas fa-child text-green-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm text-gray-500 truncate">Kelompok A</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['kelompok_a'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-5 card-hover">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-yellow-100 rounded-full mr-3 sm:mr-4">
                        <i class="fas fa-child text-yellow-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm text-gray-500 truncate">Kelompok B</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $stats['kelompok_b'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Card -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow overflow-hidden">
            <!-- Header dengan tombol navigasi -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                       class="text-gray-500 hover:text-gray-700 transition-colors duration-150 p-2 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-arrow-left text-sm sm:text-base"></i>
                    </a>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate">Daftar Siswa Aktif</h2>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">
                            <span id="total-siswa">{{ $siswas->total() ?? 0 }}</span> siswa aktif
                            <span id="filtered-count" class="hidden">
                                (<span id="filtered-number">0</span> hasil filter)
                            </span>
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.siswa.siswa-aktif.create') }}" 
                       class="flex-1 sm:flex-none bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 shadow-sm hover:shadow">
                        <i class="fas fa-plus mr-2 text-xs sm:text-sm"></i> 
                        <span class="truncate">Tambah Siswa</span>
                    </a>
                    <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                       class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150">
                        <i class="fas fa-sync-alt mr-2 text-xs sm:text-sm"></i>
                        <span class="truncate">Refresh</span>
                    </a>
                </div>
            </div>
            
            <!-- Filter & Search Section -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b">
                <!-- Search Input -->
                <div class="mb-3 sm:mb-4">
                    <div class="relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Cari nama siswa, NIK, NIS..." 
                               class="w-full px-4 py-2 pl-10 pr-10 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150"
                               autocomplete="off"
                               value="{{ request('search', '') }}">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <div id="search-clear" 
                             class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer hidden hover:scale-110 transition-transform"
                             title="Clear search">
                            <i class="fas fa-times text-gray-400 hover:text-gray-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Group -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <!-- Kelompok Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Kelompok</label>
                        <select id="filter-kelompok" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Kelompok</option>
                            <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                            <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                        </select>
                    </div>
                    
                    <!-- Tahun Ajaran Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Tahun Ajaran</label>
                        <select id="filter-tahun-ajaran" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Tahun Ajaran</option>
                            @if(isset($tahunAjarans) && $tahunAjarans->count() > 0)
                                @foreach($tahunAjarans as $ta)
                                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- Reset Button -->
                    <div class="flex-1 sm:flex-none">
                        <button id="reset-filters" 
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 flex items-center justify-center whitespace-nowrap transition-colors duration-150 mt-2 sm:mt-0">
                            <i class="fas fa-redo mr-1 text-xs"></i> 
                            <span>Reset Filter</span>
                        </button>
                    </div>
                </div>
                
                <!-- Search Info -->
                <div id="search-info" class="mt-3 text-xs sm:text-sm text-gray-600 hidden">
                    <div class="flex items-center flex-wrap gap-1 sm:gap-2 bg-blue-50 p-2 rounded-lg">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        <span>Menampilkan hasil untuk: <span id="search-term" class="font-medium"></span></span>
                        <button id="clear-search-info" class="ml-auto text-blue-600 hover:text-blue-800 text-xs transition-colors duration-150 whitespace-nowrap bg-white px-2 py-1 rounded border border-blue-200">
                            <i class="fas fa-times mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Loading Overlay -->
            <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-30 z-50 hidden backdrop-blur-sm flex items-center justify-center">
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl flex items-center">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-xl sm:text-2xl mr-3"></i>
                    <span class="text-gray-700 text-sm sm:text-base">Memuat data siswa aktif...</span>
                </div>
            </div>
            
            <!-- Tabel Container -->
            <div id="siswa-table-container" class="p-4 sm:p-6">
                @if($siswas->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Foto</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">NIS</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider hidden md:table-cell">Orang Tua</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kelompok</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($siswas as $siswa)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Foto -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @if($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                                        <img src="{{ asset('storage/' . $siswa->foto) }}" 
                                             alt="{{ $siswa->nama_lengkap }}" 
                                             class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover border-2 border-gray-200 shadow-sm">
                                    @else
                                        <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center border-2 border-gray-200">
                                            <i class="fas fa-user text-blue-400 text-xs sm:text-sm"></i>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- NIS -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-mono font-medium text-gray-900">
                                        {{ $siswa->nis ?? 'NIS-' . str_pad($siswa->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                    @if($siswa->nisn)
                                    <div class="text-xs text-gray-400 mt-1">
                                        NISN: {{ $siswa->nisn }}
                                    </div>
                                    @endif
                                </td>
                                
                                <!-- Nama Siswa -->
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm sm:text-base font-medium text-gray-900">
                                                @if(request('search'))
                                                    {!! str_ireplace(request('search'), '<span class="bg-yellow-200 px-1 rounded">' . request('search') . '</span>', $siswa->nama_lengkap) !!}
                                                @else
                                                    {{ $siswa->nama_lengkap }}
                                                @endif
                                            </div>
                                            <div class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center">
                                                <i class="fas {{ $siswa->jenis_kelamin == 'L' ? 'fa-mars text-blue-500' : 'fa-venus text-pink-500' }} mr-1"></i>
                                                {{ $siswa->jenis_kelamin_lengkap }}
                                            </div>
                                            @if($siswa->nama_panggilan)
                                            <div class="text-xs text-gray-400 mt-1">
                                                <span class="font-medium">Panggilan:</span> {{ $siswa->nama_panggilan }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Orang Tua (hidden di mobile) -->
                                <td class="px-4 sm:px-6 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">
                                        @php
                                            $namaAyah = $siswa->nama_ayah;
                                            $namaIbu = $siswa->nama_ibu;
                                            $displayNama = $namaAyah ?: $namaIbu ?: '-';
                                        @endphp
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<span class="bg-yellow-200 px-1 rounded">' . request('search') . '</span>', $displayNama) !!}
                                        @else
                                            {{ $displayNama }}
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="fab fa-whatsapp text-green-500 mr-1"></i>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siswa->no_hp_ortu) }}" 
                                           target="_blank"
                                           class="hover:text-green-600 transition-colors duration-150">
                                            {{ $siswa->no_hp_ortu }}
                                        </a>
                                    </div>
                                    @if($siswa->email_ortu)
                                    <div class="text-xs text-gray-400 mt-1 truncate max-w-[180px]" title="{{ $siswa->email_ortu }}">
                                        <i class="far fa-envelope mr-1"></i>
                                        {{ $siswa->email_ortu }}
                                    </div>
                                    @endif
                                </td>
                                
                                <!-- Kelompok -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium shadow-sm
                                        {{ $siswa->kelompok == 'A' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                                           'bg-green-100 text-green-800 border border-green-200' }}">
                                        <i class="fas {{ $siswa->kelompok == 'A' ? 'fa-star' : 'fa-star-half-alt' }} mr-1"></i>
                                        Kelompok {{ $siswa->kelompok }}
                                    </span>
                                </td>
                                
                                <!-- Status -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'aktif' => 'bg-green-100 text-green-800 border-green-200',
                                            'lulus' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'pindah' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'cuti' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        ];
                                        $statusIcons = [
                                            'aktif' => 'fa-check-circle',
                                            'lulus' => 'fa-graduation-cap',
                                            'pindah' => 'fa-exchange-alt',
                                            'cuti' => 'fa-clock',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium border shadow-sm {{ $statusColors[$siswa->status_siswa] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                        <i class="fas {{ $statusIcons[$siswa->status_siswa] ?? 'fa-info-circle' }} mr-1"></i>
                                        {{ ucfirst($siswa->status_siswa) }}
                                    </span>
                                    
                                    <!-- Tahun Ajaran (hidden di mobile, ditampilkan di desktop) -->
                                    <div class="hidden lg:block text-xs text-gray-400 mt-2">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $siswa->tahunAjaran->tahun_ajaran ?? $siswa->tahun_ajaran }}
                                    </div>
                                </td>
                                
                                <!-- Aksi -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <a href="{{ route('admin.siswa.siswa-aktif.show', $siswa) }}" 
                                           class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-all duration-150 hover:scale-110" 
                                           title="Detail">
                                            <i class="fas fa-eye text-sm sm:text-base"></i>
                                        </a>
                                        <a href="{{ route('admin.siswa.siswa-aktif.edit', $siswa) }}" 
                                           class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition-all duration-150 hover:scale-110" 
                                           title="Edit">
                                            <i class="fas fa-edit text-sm sm:text-base"></i>
                                        </a>
                                        
                                        <!-- Tombol Update Status -->
                                        <button type="button" 
                                                onclick="showStatusModal({{ $siswa->id }}, '{{ $siswa->nama_lengkap }}', '{{ $siswa->status_siswa }}')"
                                                class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded-lg transition-all duration-150 hover:scale-110" 
                                                title="Update Status">
                                            <i class="fas fa-sync-alt text-sm sm:text-base"></i>
                                        </button>
                                        
                                        @if($siswa->spmb_id)
                                        <a href="{{ route('admin.spmb.show', $siswa->spmb_id) }}" 
                                           class="text-purple-600 hover:text-purple-900 p-2 hover:bg-purple-50 rounded-lg transition-all duration-150 hover:scale-110 hidden lg:inline-flex" 
                                           title="Lihat Data SPMB">
                                            <i class="fas fa-file-alt text-sm sm:text-base"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="py-12 text-center text-gray-500 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4 shadow-inner">
                        <i class="fas fa-user-graduate text-gray-400 text-xl sm:text-2xl"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-700 mb-2">Tidak ada data ditemukan</p>
                    <p class="text-sm sm:text-base text-gray-600 mb-6 max-w-md mx-auto px-4">
                        @if(request()->has('search') || request()->has('kelompok') || request()->has('tahun_ajaran_id'))
                            Tidak ada siswa aktif yang cocok dengan kriteria pencarian Anda.
                        @else
                            Belum ada data siswa aktif. Mulai tambahkan siswa pertama Anda.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center px-4">
                        <a href="{{ route('admin.siswa.siswa-aktif.create') }}" 
                           class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <i class="fas fa-plus mr-2"></i> Tambah Siswa
                        </a>
                        @if(request()->hasAny(['search', 'kelompok', 'tahun_ajaran_id']))
                        <a href="{{ route('admin.siswa.siswa-aktif.index') }}" 
                           class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-150">
                            <i class="fas fa-redo mr-2"></i> Reset Filter
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Pagination Container -->
            @if($siswas->hasPages())
            <div id="pagination-container" class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50">
                <div class="overflow-x-auto">
                    <div class="flex justify-center">
                        {{ $siswas->onEachSide(1)->appends(request()->query())->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="statusModalContent">
        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sync-alt text-yellow-500 mr-2"></i>
                    Update Status Siswa
                </h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center transition-colors duration-150">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1" id="modalStudentInfo"></p>
        </div>
        
        <div class="px-5 py-4">
            <form id="statusForm" method="POST" action="">
                @csrf
                @method('PATCH')
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select name="status_siswa" id="status_select" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors duration-150" onchange="toggleTanggalKeluar()">
                        <option value="aktif">Aktif</option>
                        <option value="lulus">Lulus</option>
                        <option value="pindah">Pindah</option>
                        <option value="cuti">Cuti</option>
                    </select>
                </div>
                
                <div id="tanggalKeluarField" class="mb-5 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors duration-150">
                    <p class="text-xs text-gray-500 mt-1">Wajib diisi jika status Lulus atau Pindah</p>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3" 
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-colors duration-150"
                              placeholder="Tambahkan catatan..."></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeStatusModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-150 shadow-md hover:shadow-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Card hover effects */
    .card-hover {
        transition: all 0.3s ease;
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Custom scrollbar untuk tabel */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f1f5f9;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
        border: 2px solid #f1f5f9;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Responsive table hints */
    @media (max-width: 768px) {
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
        
        .overflow-x-auto::after {
            content: "← Geser untuk melihat lebih banyak →";
            display: block;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            padding: 8px 0;
            background: linear-gradient(90deg, transparent, #f9fafb, transparent);
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
    }
    
    /* Pagination styling */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
    }
    
    .pagination > li {
        margin: 0 2px;
    }
    
    .pagination > li > a,
    .pagination > li > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        font-size: 14px;
        border-radius: 8px;
        transition: all 0.15s ease;
    }
    
    /* Loading overlay animation */
    #loading-overlay {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Modal animation */
    #statusModal.show {
        opacity: 1;
        pointer-events: auto;
    }
    
    /* Touch-friendly buttons */
    @media (max-width: 640px) {
        button, a {
            min-height: 44px;
        }
        
        .p-2 {
            padding: 0.75rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === FILTER FUNCTIONALITY ===
        const searchInput = document.getElementById('search-input');
        const filterKelompok = document.getElementById('filter-kelompok');
        const filterTahunAjaran = document.getElementById('filter-tahun-ajaran');
        const resetBtn = document.getElementById('reset-filters');
        const searchClear = document.getElementById('search-clear');
        const clearSearchInfo = document.getElementById('clear-search-info');
        const searchInfo = document.getElementById('search-info');
        const searchTerm = document.getElementById('search-term');
        const loadingOverlay = document.getElementById('loading-overlay');
        
        // Function to apply filters
        function applyFilters() {
            const params = new URLSearchParams(window.location.search);
            
            // Get current values
            const search = searchInput.value.trim();
            const kelompok = filterKelompok.value;
            const tahunAjaran = filterTahunAjaran.value;
            
            // Set or delete params
            if (search) {
                params.set('search', search);
            } else {
                params.delete('search');
            }
            
            if (kelompok) {
                params.set('kelompok', kelompok);
            } else {
                params.delete('kelompok');
            }
            
            if (tahunAjaran) {
                params.set('tahun_ajaran_id', tahunAjaran);
            } else {
                params.delete('tahun_ajaran_id');
            }
            
            // Reset to first page
            params.set('page', '1');
            
            // Show loading overlay
            if (loadingOverlay) loadingOverlay.classList.remove('hidden');
            
            // Redirect with new params
            window.location.href = window.location.pathname + '?' + params.toString();
        }
        
        // Event listeners for filter changes
        if (filterKelompok) {
            filterKelompok.addEventListener('change', applyFilters);
        }
        
        if (filterTahunAjaran) {
            filterTahunAjaran.addEventListener('change', applyFilters);
        }
        
        // Search with debounce
        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                // Show/hide clear button
                if (this.value.length > 0) {
                    searchClear?.classList.remove('hidden');
                } else {
                    searchClear?.classList.add('hidden');
                }
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyFilters();
                }
            });
            
            // Debounced search after user stops typing
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        applyFilters();
                    }
                }, 800);
            });
        }
        
        // Clear search button
        if (searchClear) {
            searchClear.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    this.classList.add('hidden');
                    applyFilters();
                }
            });
        }
        
        // Reset all filters
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                if (window.innerWidth < 640) {
                    if (confirm('Reset semua filter?')) {
                        window.location.href = window.location.pathname;
                    }
                } else {
                    window.location.href = window.location.pathname;
                }
            });
        }
        
        // Clear search info
        if (clearSearchInfo) {
            clearSearchInfo.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    if (searchClear) searchClear.classList.add('hidden');
                    applyFilters();
                }
            });
        }
        
        // Show/hide clear button on page load
        if (searchInput && searchInput.value.length > 0) {
            if (searchClear) searchClear.classList.remove('hidden');
        }
        
        // Show search info if there's a search query
        @if(request('search'))
            if (searchInfo) searchInfo.classList.remove('hidden');
            if (searchTerm) searchTerm.textContent = '{{ request('search') }}';
        @endif
        
        // Show filtered count if there are filters
        @if(request()->hasAny(['search', 'kelompok', 'tahun_ajaran_id']))
            document.getElementById('filtered-count')?.classList.remove('hidden');
            document.getElementById('filtered-number').textContent = '{{ $siswas->total() ?? 0 }}';
        @endif
        
        // Handle pagination links to show loading
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth < 768) {
                    if (loadingOverlay) loadingOverlay.classList.remove('hidden');
                }
            });
        });
        
        // Hide loading overlay when page loads
        window.addEventListener('load', function() {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
        });
        
        // Add smooth scroll to top when pagination clicked
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    });
    
    // Modal functions
    function showStatusModal(siswaId, siswaName, currentStatus) {
        const modal = document.getElementById('statusModal');
        const modalContent = document.getElementById('statusModalContent');
        const form = document.getElementById('statusForm');
        const nameSpan = document.getElementById('modalStudentInfo');
        
        form.action = '{{ url("admin/siswa") }}/' + siswaId + '/status';
        nameSpan.innerHTML = '<i class="fas fa-user mr-1"></i>' + siswaName;
        
        // Set selected status
        const statusSelect = document.getElementById('status_select');
        statusSelect.value = currentStatus;
        
        // Toggle tanggal keluar field
        toggleTanggalKeluar();
        
        // Tampilkan modal dengan animasi
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }, 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        const modalContent = document.getElementById('statusModalContent');
        
        modalContent.style.opacity = '0';
        modalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            document.getElementById('statusForm').reset();
        }, 200);
    }
    
    function toggleTanggalKeluar() {
        const status = document.getElementById('status_select').value;
        const tanggalField = document.getElementById('tanggalKeluarField');
        
        if (status === 'lulus' || status === 'pindah') {
            tanggalField.classList.remove('hidden');
        } else {
            tanggalField.classList.add('hidden');
        }
    }
    
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
    
    // Touch-friendly untuk mobile
    if ('ontouchstart' in window) {
        document.querySelectorAll('button, a').forEach(el => {
            el.addEventListener('touchstart', function() {
                // Add touch feedback
                this.style.opacity = '0.7';
            });
            el.addEventListener('touchend', function() {
                this.style.opacity = '1';
            });
        });
    }
</script>
@endpush