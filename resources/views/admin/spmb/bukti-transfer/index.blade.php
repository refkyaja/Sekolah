@extends('layouts.admin')

@section('title', 'Verifikasi Bukti Transfer')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-money-bill-wave mr-2"></i>Verifikasi Bukti Transfer
                </h1>
                <p class="text-gray-600 mt-2">Kelola dan verifikasi bukti transfer pembayaran pendaftaran</p>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total</p>
                    <p class="text-2xl font-bold">{{ $statistik['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $statistik['menunggu'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Terverifikasi</p>
                    <p class="text-2xl font-bold text-green-600">{{ $statistik['terverifikasi'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $statistik['ditolak'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" placeholder="Cari nama/bank..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diverifikasi" {{ request('status') == 'Diverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
            <div>
                <a href="{{ route('admin.spmb.bukti-transfer.index') }}" class="w-full block text-center border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg transition">
                    <i class="fas fa-sync-alt mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Transfer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($buktiTransfers as $index => $bt)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $buktiTransfers->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $bt->nama_pengirim }}</div>
                            <div class="text-sm text-gray-500">{{ $bt->spmb->nama_lengkap_anak ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ $bt->bank_pengirim }}</div>
                            <div class="text-sm text-gray-500">{{ $bt->nomor_rekening_pengirim }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $bt->jumlah_formatted }}</td>
                        <td class="px-6 py-4">{{ $bt->tanggal_transfer_formatted }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $bt->status_badge }}">
                                <i class="fas {{ $bt->status_icon }} mr-1"></i>
                                {{ $bt->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.spmb.bukti-transfer.show', $bt) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.spmb.bukti-transfer.download', $bt) }}" 
                                   class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-file-invoice text-5xl mb-4"></i>
                            <p>Tidak ada data bukti transfer</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($buktiTransfers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $buktiTransfers->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection