@extends('layouts.admin')

@section('title', 'Detail Bukti Transfer')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-money-bill-wave mr-2"></i>Detail Bukti Transfer
                </h1>
                <p class="text-gray-600 mt-2">Verifikasi bukti transfer pembayaran pendaftaran</p>
            </div>
            <a href="{{ route('admin.spmb.bukti-transfer.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informasi Transfer -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-bold text-white">Informasi Transfer</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Nama Pengirim</p>
                            <p class="font-medium">{{ $buktiTransfer->nama_pengirim }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Bank Pengirim</p>
                            <p class="font-medium">{{ $buktiTransfer->bank_pengirim }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">No. Rekening</p>
                            <p class="font-medium">{{ $buktiTransfer->nomor_rekening_pengirim }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jumlah Transfer</p>
                            <p class="font-medium text-lg text-green-600">{{ $buktiTransfer->jumlah_formatted }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Transfer</p>
                            <p class="font-medium">{{ $buktiTransfer->tanggal_transfer_formatted }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Status</p>
                            <span class="px-3 py-1 text-sm rounded-full {{ $buktiTransfer->status_badge }}">
                                <i class="fas {{ $buktiTransfer->status_icon }} mr-1"></i>
                                {{ $buktiTransfer->status_label }}
                            </span>
                        </div>

                        @if($buktiTransfer->tanggal_verifikasi)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Verifikasi</p>
                            <p class="font-medium">{{ $buktiTransfer->tanggal_verifikasi_formatted }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Diverifikasi Oleh</p>
                            <p class="font-medium">{{ $buktiTransfer->verifikator->name ?? '-' }}</p>
                        </div>

                        @if($buktiTransfer->catatan_verifikasi)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Catatan</p>
                            <p class="text-sm bg-gray-50 p-3 rounded">{{ $buktiTransfer->catatan_verifikasi }}</p>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Pendaftar -->
            @if($buktiTransfer->spmb)
            <div class="bg-white rounded-xl shadow-md overflow-hidden mt-6">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                    <h3 class="text-lg font-bold text-white">Informasi Pendaftar</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="font-medium">{{ $buktiTransfer->spmb->nama_lengkap_anak }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">No. Pendaftaran</p>
                            <p class="font-medium">{{ $buktiTransfer->spmb->no_pendaftaran }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Status Pendaftaran</p>
                            <span class="px-3 py-1 text-sm rounded-full {{ $buktiTransfer->spmb->status_pendaftaran_color }}">
                                {{ $buktiTransfer->spmb->status_pendaftaran_label }}
                            </span>
                        </div>

                        <div class="pt-4 border-t">
                            <a href="{{ route('admin.spmb.show', $buktiTransfer->spmb) }}" 
                               class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                <i class="fas fa-eye mr-2"></i>Lihat Detail Pendaftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- File Bukti Transfer -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="text-lg font-bold text-white">File Bukti Transfer</h3>
                </div>
                <div class="p-6">
                    <div class="border rounded-lg p-4 bg-gray-50 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">
                                <i class="{{ $buktiTransfer->file_icon }}"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $buktiTransfer->nama_file }}</h4>
                                <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                    <span>Diupload: {{ $buktiTransfer->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('admin.spmb.bukti-transfer.download', $buktiTransfer) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview untuk gambar -->
                    @if(str_contains($buktiTransfer->mime_type, 'image'))
                    <div class="mt-4">
                        <h4 class="font-medium text-gray-900 mb-3">Preview:</h4>
                        <img src="{{ $buktiTransfer->url }}" alt="Bukti Transfer" class="max-w-full rounded-lg border">
                    </div>
                    @endif

                    <!-- Form Verifikasi (hanya untuk status Menunggu) -->
                    @if($buktiTransfer->status_verifikasi == 'Menunggu')
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-medium text-gray-900 mb-4">Verifikasi Bukti Transfer</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form action="{{ route('admin.spmb.bukti-transfer.verifikasi', $buktiTransfer) }}" method="POST" class="col-span-1">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="catatan" placeholder="Catatan (opsional)" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                              rows="2"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition">
                                    <i class="fas fa-check-circle mr-2"></i> Verifikasi & Terima
                                </button>
                            </form>

                            <form action="{{ route('admin.spmb.bukti-transfer.tolak', $buktiTransfer) }}" method="POST" class="col-span-1">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="catatan" placeholder="Alasan penolakan *" required
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                              rows="2"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition">
                                    <i class="fas fa-times-circle mr-2"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection