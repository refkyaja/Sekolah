@extends('layouts.admin')

@section('title', 'Buku Tamu - TK Harapan Bangsa 1')
@section('breadcrumb', 'Data Buku Tamu')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Kelola Buku Tamu</h2>
                <p class="text-sm text-gray-600 mt-1">Data kunjungan tamu ke TK Harapan Bangsa 1</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.bukutamu.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Tambah Tamu
                </a>
                <button onclick="exportData()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-file-export mr-2"></i> Export
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="p-6 border-b border-gray-200">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Tamu</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-day text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['today'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Menunggu</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Terverifikasi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['verified'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter -->
    <div class="p-6 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.bukutamu.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama/instansi..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                
                <div>
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                
                <div>
                    <input type="date" 
                           name="tanggal" 
                           value="{{ request('tanggal') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                
                <div>
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Tamu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                        Instansi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jadwal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                        Verifikasi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bukutamu as $tamu)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-green-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">
                                    {{ $tamu->nama }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $tamu->jabatan ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-400 md:hidden mt-1">
                                    {{ $tamu->instansi }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden md:table-cell">
                        {{ $tamu->instansi }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">
                                {{ $tamu->tanggal_kunjungan->format('d/m/Y') }}
                            </div>
                            <div class="text-gray-500">
                                {{ $tamu->jam_kunjungan }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($tamu->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($tamu->status == 'approved') bg-blue-100 text-blue-800
                            @elseif($tamu->status == 'rejected') bg-red-100 text-red-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ $tamu->status_text }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        @if($tamu->is_verified)
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i> Terverifikasi
                        </span>
                        @else
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                            Belum Diverifikasi
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.bukutamu.show', $tamu) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.bukutamu.edit', $tamu) }}" 
                               class="text-green-600 hover:text-green-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$tamu->is_verified)
                            <form action="{{ route('admin.bukutamu.verify', $tamu) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-purple-600 hover:text-purple-900" 
                                        title="Verifikasi"
                                        onclick="return confirm('Verifikasi data tamu ini?')">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.bukutamu.destroy', $tamu) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Hapus data tamu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900" 
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-book text-4xl text-gray-300 mb-3"></i>
                        <p>Belum ada data buku tamu</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($bukutamu->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $bukutamu->onEachSide(1)->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function exportData() {
        Swal.fire({
            title: 'Export Data Buku Tamu',
            html: `
                <form id="exportForm">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Export Excel',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('exportForm');
                const params = new URLSearchParams(new FormData(form)).toString();
                window.location.href = '{{ route("admin.bukutamu.export") }}?' + params;
            }
        });
    }
</script>
@endpush