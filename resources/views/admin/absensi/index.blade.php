@extends('layouts.admin')

@section('title', 'Absensi Siswa')
@section('breadcrumb', 'Data Absensi Siswa')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Rekap Absensi Siswa</h1>
                    <p class="text-gray-600 text-sm mt-1">Kelola dan pantau kehadiran siswa</p>
                </div>
                <div class="flex gap-2 mt-3 sm:mt-0">
                    <a href="{{ route('admin.absensi.fill') }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i> Isi Absensi
                    </a>
                    <a href="{{ route('admin.absensi.export') }}" 
                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm flex items-center">
                        <i class="fas fa-file-excel mr-2"></i> Export
                    </a>
                </div>
            </div>
        </div>

        <!-- FILTER SEDERHANA & JELAS -->
        <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
            <form method="GET" action="{{ route('admin.absensi.index') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filter Kelompok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelompok</label>
                        <select name="kelompok" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="">Semua Kelompok</option>
                            <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A (4-5 Tahun)</option>
                            <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B (5-6 Tahun)</option>
                        </select>
                    </div>
                    
                    <!-- Filter Tanggal - Mode Pilihan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                        <select id="tanggal_mode" name="tanggal_mode" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-2" onchange="toggleTanggalMode()">
                            <option value="">Semua Tanggal</option>
                            <option value="specific" {{ request('tanggal') ? 'selected' : '' }}>Tanggal Tertentu</option>
                            <option value="bulan" {{ request('bulan') ? 'selected' : '' }}>Per Bulan</option>
                        </select>
                        
                        <div id="tanggal_specific_container" style="{{ request('tanggal') ? '' : 'display: none;' }}">
                            <input type="date" name="tanggal" id="filter_tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        
                        <div id="bulan_container" style="{{ request('bulan') ? '' : 'display: none;' }}">
                            <input type="month" name="bulan" id="filter_bulan" value="{{ request('bulan', date('Y-m')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                    
                    <!-- Tombol Filter -->
                    <div class="flex items-end gap-2 md:col-span-2">
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.absensi.index') }}" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
            
            <!-- Info Filter Aktif -->
            @if(request()->anyFilled(['kelompok', 'tanggal', 'bulan']))
            <div class="mt-4 p-3 bg-blue-50 rounded-lg text-sm text-blue-700 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                <span>
                    Menampilkan: 
                    <strong>{{ request('kelompok') ? 'Kelompok '.request('kelompok') : 'Semua Kelompok' }}</strong>
                    
                    @if(request('tanggal'))
                        , Tanggal: <strong>{{ Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}</strong>
                    @elseif(request('bulan'))
                        , Bulan: <strong>{{ Carbon\Carbon::parse(request('bulan'))->format('F Y') }}</strong>
                    @else
                        , <strong>Semua Tanggal</strong>
                    @endif
                    
                    ({{ $absensi->total() }} data)
                </span>
            </div>
            @endif
        </div>

        <!-- STATISTIK UMUM -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Absensi</p>
                        <p class="text-xl font-bold text-gray-800">{{ $total_absensi }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Hadir</p>
                        <p class="text-xl font-bold text-gray-800">{{ $total_hadir }}</p>
                        <p class="text-xs text-gray-400">{{ $persen_hadir }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Izin/Sakit</p>
                        <p class="text-xl font-bold text-gray-800">{{ $total_izin_sakit }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tidak Hadir</p>
                        <p class="text-xl font-bold text-gray-800">{{ $total_tidak_hadir }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATISTIK TANGGAL TERTENTU (JIKA ADA FILTER) -->
        @if($statistik_tanggal)
        <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
            <h3 class="font-medium text-gray-800 mb-3 flex items-center">
                <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                Statistik Tanggal {{ Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded p-3">
                    <span class="text-xs text-gray-500">Hadir</span>
                    <span class="text-lg font-bold text-green-600 block">{{ $statistik_tanggal['hadir'] }}</span>
                </div>
                <div class="bg-white rounded p-3">
                    <span class="text-xs text-gray-500">Izin</span>
                    <span class="text-lg font-bold text-yellow-600 block">{{ $statistik_tanggal['izin'] }}</span>
                </div>
                <div class="bg-white rounded p-3">
                    <span class="text-xs text-gray-500">Sakit</span>
                    <span class="text-lg font-bold text-orange-600 block">{{ $statistik_tanggal['sakit'] }}</span>
                </div>
                <div class="bg-white rounded p-3">
                    <span class="text-xs text-gray-500">Tidak Hadir</span>
                    <span class="text-lg font-bold text-red-600 block">{{ $statistik_tanggal['tidak_hadir'] }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- INFO GURU PER KELOMPOK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Guru Kelompok A</p>
                        <p class="font-medium text-gray-800">{{ $guru_kelompok_a->nama ?? 'Belum ditentukan' }}</p>
                        @if($guru_kelompok_a)
                        <span class="text-xs text-gray-500">NIP: {{ $guru_kelompok_a->nip ?? '-' }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-chalkboard-teacher text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Guru Kelompok B</p>
                        <p class="font-medium text-gray-800">{{ $guru_kelompok_b->nama ?? 'Belum ditentukan' }}</p>
                        @if($guru_kelompok_b)
                        <span class="text-xs text-gray-500">NIP: {{ $guru_kelompok_b->nip ?? '-' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL ABSENSI -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200">
                <h2 class="font-semibold text-gray-800">Daftar Absensi Siswa</h2>
            </div>
            
            @if($absensi->isEmpty())
            <div class="p-8 text-center">
                <div class="text-gray-400 mb-3">
                    <i class="fas fa-clipboard-list text-5xl"></i>
                </div>
                <h3 class="text-gray-700 font-medium mb-2">Belum Ada Data Absensi</h3>
                <p class="text-gray-500 text-sm mb-4">
                    @if(request()->anyFilled(['kelompok', 'tanggal', 'bulan']))
                        Tidak ada data untuk filter yang dipilih
                    @else
                        Silakan isi absensi untuk mencatat kehadiran siswa
                    @endif
                </p>
                <a href="{{ route('admin.absensi.fill') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Isi Absensi Sekarang
                </a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($absensi as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 whitespace-nowrap text-sm">{{ $index + 1 + (($absensi->currentPage() - 1) * $absensi->perPage()) }}</td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">{{ $item->siswa->nis ?? '-' }}</td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->siswa->nama_lengkap ?? $item->siswa->nama }}</div>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $item->siswa->kelompok == 'A' ? 'bg-blue-100 text-blue-800' : 
                                       ($item->siswa->kelompok == 'B' ? 'bg-green-100 text-green-800' : 
                                       'bg-purple-100 text-purple-800') }}">
                                    Kel. {{ $item->siswa->kelompok }}
                                </span>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                {{ Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                @if($item->status == 'hadir')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Hadir
                                    </span>
                                @elseif($item->status == 'izin')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Izin
                                    </span>
                                @elseif($item->status == 'sakit')
                                    <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-thermometer mr-1"></i> Sakit
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i> Tidak Hadir
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                @if($item->guru)
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-800">{{ $item->guru->nama }}</span>
                                        <span class="ml-1 text-xs text-gray-500">({{ $item->guru->kelompok }})</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button onclick="editAbsensi({{ $item->id }})" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($absensi->hasPages())
            <div class="px-5 py-3 border-t border-gray-200">
                {{ $absensi->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit (sesuaikan dengan guru_list dari controller) -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div class="p-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Edit Absensi</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                        <input type="text" id="edit-siswa-nama" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="text" name="tanggal" id="edit-tanggal" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" readonly>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="edit-status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    
                    <div id="edit-guru-container" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Guru</label>
                        <select name="guru_id" id="edit-guru" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" id="edit-keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm">
        <div class="p-5">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-600 text-center mb-5">Apakah Anda yakin ingin menghapus data absensi ini?</p>
            
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle Tanggal Mode
    function toggleTanggalMode() {
        const mode = document.getElementById('tanggal_mode').value;
        const specificContainer = document.getElementById('tanggal_specific_container');
        const bulanContainer = document.getElementById('bulan_container');
        
        specificContainer.style.display = 'none';
        bulanContainer.style.display = 'none';
        
        if (mode === 'specific') {
            specificContainer.style.display = 'block';
        } else if (mode === 'bulan') {
            bulanContainer.style.display = 'block';
        }
    }

    // Edit Absensi
    function editAbsensi(id) {
        fetch(`/admin/absensi/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('edit-siswa-nama').value = data.siswa_nama;
                    document.getElementById('edit-tanggal').value = data.tanggal;
                    document.getElementById('edit-status').value = data.status;
                    document.getElementById('edit-keterangan').value = data.keterangan || '';
                    
                    // Handle guru dropdown
                    const guruContainer = document.getElementById('edit-guru-container');
                    const guruSelect = document.getElementById('edit-guru');
                    
                    if (data.guru_list && data.guru_list.length > 0) {
                        guruSelect.innerHTML = '<option value="">Pilih Guru</option>';
                        data.guru_list.forEach(guru => {
                            const selected = (guru.id == data.guru_id) ? 'selected' : '';
                            guruSelect.innerHTML += `<option value="${guru.id}" ${selected}>${guru.nama} (${guru.nip || '-'})</option>`;
                        });
                        guruContainer.style.display = 'block';
                    } else {
                        guruContainer.style.display = 'none';
                    }
                    
                    document.getElementById('editForm').action = `/admin/absensi/${id}`;
                    document.getElementById('editModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data');
            });
    }

    // Delete Absensi
    function deleteAbsensi(id) {
        document.getElementById('deleteForm').action = `/admin/absensi/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleTanggalMode();
        
        // Charts
        @if(!$absensi->isEmpty() && !request('tanggal') && !request('bulan'))
            // Attendance Chart
            const ctx1 = document.getElementById('attendanceChart');
            if (ctx1) {
                new Chart(ctx1.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($chart_7_hari->pluck('tanggal')),
                        datasets: [{
                            label: 'Hadir',
                            data: @json($chart_7_hari->pluck('hadir')),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Tidak Hadir',
                            data: @json($chart_7_hari->pluck('tidak_hadir')),
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }

            // Status Chart
            const ctx2 = document.getElementById('statusChart');
            if (ctx2) {
                new Chart(ctx2.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'],
                        datasets: [{
                            data: @json($status_distribution),
                            backgroundColor: ['#10B981', '#F59E0B', '#F97316', '#EF4444']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        @endif
    });
</script>
@endpush