@extends('layouts.nav-spmb')

@section('title', 'Daftar Peserta Lulus SPMB - TK Ceria Bangsa')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">Daftar Peserta Lulus SPMB</h2>
                        <p class="opacity-90 mt-1">Tahun Ajaran 2026/2027 - TK Ceria Bangsa</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="px-4 py-2 bg-green-500 bg-opacity-30 rounded-lg">
                            <p class="text-sm">
                                <i class="fas fa-calendar-check mr-2"></i>
                                {{ now()->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <!-- Info Box -->
                <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-6 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-green-600 text-2xl mr-4"></i>
                        <div>
                            <h4 class="font-bold text-green-800 text-lg">Selamat Kepada Peserta yang Lulus!</h4>
                            <p class="text-green-700">Berikut adalah daftar peserta yang lulus melalui SPMB TK Ceria Bangsa Tahun Ajaran 2026/2027</p>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-blue-700 mb-2">{{ $pesertaLulus->count() }}</div>
                        <div class="text-sm text-blue-600">Total Peserta Lulus</div>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-green-700 mb-2">{{ $setting->kuota_zonasi ?? 50 }}%</div>
                        <div class="text-sm text-green-600">Kuota Zonasi</div>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 text-center">
                        <div class="text-3xl font-bold text-purple-700 mb-2">{{ $setting->tahun_ajaran ?? '2026/2027' }}</div>
                        <div class="text-sm text-purple-600">Tahun Ajaran</div>
                    </div>
                </div>
                
                <!-- Participant List -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-900">Daftar Peserta yang Lulus</h3>
                        <p class="text-sm text-gray-600">Diurutkan berdasarkan No. Pendaftaran</p>
                    </div>
                    
                    @if($pesertaLulus->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pendaftaran</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Calon Siswa</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pesertaLulus as $index => $peserta)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $peserta->no_pendaftaran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $peserta->nama_calon_siswa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($peserta->jalur_pendaftaran)
                                                @case('zonasi')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Zonasi</span>
                                                    @break
                                                @case('afirmasi')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Afirmasi</span>
                                                    @break
                                                @case('prestasi')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Prestasi</span>
                                                    @break
                                                @case('mutasi')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Mutasi</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Lulus
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination if needed -->
                        @if($pesertaLulus->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $pesertaLulus->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Peserta yang Lulus</h4>
                            <p class="text-gray-600">Data peserta yang lulus akan ditampilkan di sini setelah proses seleksi selesai.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Important Information -->
                <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3"></i>
                        <h4 class="font-bold text-yellow-800">Informasi Penting</h4>
                    </div>
                    <ul class="text-yellow-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-circle text-yellow-500 text-xs mt-2 mr-2"></i>
                            <span>Peserta yang namanya tercantum di atas diharapkan melakukan daftar ulang sesuai jadwal yang telah ditentukan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-circle text-yellow-500 text-xs mt-2 mr-2"></i>
                            <span>Bawa dokumen asli untuk verifikasi saat daftar ulang</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-circle text-yellow-500 text-xs mt-2 mr-2"></i>
                            <span>Keputusan panitia bersifat final dan tidak dapat diganggu gugat</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('spmb.pengumuman') }}" 
                       class="flex-1 border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-medium py-3 px-6 rounded-lg text-center transition duration-300 flex items-center justify-center">
                        <i class="fas fa-search mr-3"></i>
                        Cek Hasil Individu
                    </a>
                    
                    <button onclick="window.print()" 
                            class="flex-1 border-2 border-gray-600 text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-print mr-3"></i>
                        Cetak Daftar
                    </button>
                    
                    <a href="{{ route('spmb.index') }}" 
                       class="flex-1 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-6 rounded-lg text-center transition duration-300 flex items-center justify-center">
                        <i class="fas fa-home mr-3"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    .bg-gradient-to-b {
        background: white !important;
    }
    
    .shadow-xl {
        box-shadow: none !important;
    }
    
    .rounded-2xl {
        border-radius: 0 !important;
    }
    
    button {
        display: none !important;
    }
    
    .bg-gradient-to-r {
        background: #f0f0f0 !important;
    }
    
    .text-white {
        color: black !important;
    }
}
</style>
@endsection