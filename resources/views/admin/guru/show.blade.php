{{-- resources/views/admin/guru/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Guru')
@section('breadcrumb', 'Detail Guru')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Card Detail -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Foto -->
                    <div class="h-20 w-20 rounded-full bg-white p-1">
                        @if($guru->foto)
                            <img src="{{ asset('storage/' . $guru->foto) }}" 
                                 alt="{{ $guru->nama }}"
                                 class="h-full w-full rounded-full object-cover">
                        @else
                            <div class="h-full w-full rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-blue-500 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Info Dasar -->
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $guru->nama }}</h1>
                        <div class="flex items-center space-x-3 mt-2">
                            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-user mr-1"></i>
                                {{ $guru->jenis_kelamin_lengkap }}
                            </span>
                            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-birthday-cake mr-1"></i>
                                {{ $guru->usia }} tahun
                            </span>
                            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-user-tie mr-1"></i>
                                {{ $guru->jabatan_formatted }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Jabatan Badge -->
                <div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        {{ $guru->jabatan == 'guru' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $guru->jabatan_formatted }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1 -->
                <div class="space-y-6">
                    <!-- Data Pribadi -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-2"></i> Data Pribadi
                        </h3>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="w-40 text-gray-600">Nama Lengkap</span>
                                <span class="flex-1 font-medium">{{ $guru->nama }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">NIP</span>
                                <span class="flex-1 font-medium">{{ $guru->nip ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">Jenis Kelamin</span>
                                <span class="flex-1 font-medium">
                                    {{ $guru->jenis_kelamin_lengkap }}
                                </span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">Tempat Lahir</span>
                                <span class="flex-1 font-medium">{{ $guru->tempat_lahir ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">Tanggal Lahir</span>
                                <span class="flex-1 font-medium">
                                    {{ $guru->tanggal_lahir_formatted }}
                                    ({{ $guru->usia }} tahun)
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Kontak -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-address-book text-green-500 mr-2"></i> Data Kontak
                        </h3>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="w-40 text-gray-600">Email</span>
                                <span class="flex-1 font-medium">{{ $guru->email }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">No. HP</span>
                                <span class="flex-1 font-medium">{{ $guru->no_hp }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom 2 -->
                <div class="space-y-6">
                    <!-- Jabatan & Pendidikan -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-tie text-purple-500 mr-2"></i> Jabatan & Pendidikan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="w-40 text-gray-600">Jabatan</span>
                                <span class="flex-1 font-medium">
                                    <span class="px-2 py-1 rounded text-sm
                                        {{ $guru->jabatan == 'guru' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $guru->jabatan_formatted }}
                                    </span>
                                </span>
                            </div>
                            @if($guru->jabatan == 'guru')
                            <div class="flex">
                                <span class="w-40 text-gray-600">Kelompok</span>
                                <span class="flex-1 font-medium">
                                    @if($guru->kelompok)
                                        <span class="px-2 py-1 rounded text-sm bg-purple-100 text-purple-800">
                                            {{ $guru->kelompok_formatted }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            @endif
                            <div class="flex">
                                <span class="w-40 text-gray-600">Pendidikan Terakhir</span>
                                <span class="flex-1 font-medium">{{ $guru->pendidikan_terakhir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-home text-yellow-500 mr-2"></i> Alamat
                        </h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $guru->alamat }}</p>
                    </div>
                    
                    <!-- Informasi Sistem -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-red-500 mr-2"></i> Informasi Sistem
                        </h3>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="w-40 text-gray-600">Tanggal Daftar</span>
                                <span class="flex-1 font-medium">
                                    {{ $guru->created_at->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div class="flex">
                                <span class="w-40 text-gray-600">Terakhir Update</span>
                                <span class="flex-1 font-medium">
                                    {{ $guru->updated_at->translatedFormat('d F Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Aksi -->
                    <div class="bg-gray-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('admin.guru.edit', $guru) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fas fa-edit mr-2"></i> Edit Data
                            </a>
                            <form action="{{ route('admin.guru.destroy', $guru) }}" 
                                  method="POST" class="flex-1"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('admin.guru.index') }}" 
                               class="flex-1 border border-gray-300 text-gray-700 px-4 py-3 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Tambahan untuk Guru -->
    @if($guru->jabatan == 'guru' && $guru->kelompok)
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-chalkboard-teacher text-purple-500 mr-2"></i> Informasi Mengajar
            </h3>
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                {{ $guru->kelompok_formatted }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Wali Kelompok</p>
                        <p class="font-semibold">{{ $guru->kelompok_formatted }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Guru bertanggung jawab sebagai wali kelas untuk kelompok ini
                </p>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                        <i class="fas fa-graduation-cap text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status Mengajar</p>
                        <p class="font-semibold">Aktif Mengajar</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Sedang aktif mengajar siswa di {{ $guru->kelompok_formatted }}
                </p>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <a href="{{ route('admin.siswa.index', ['kelompok' => $guru->kelompok]) }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-list mr-2"></i> Lihat Siswa di {{ $guru->kelompok_formatted }}
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .whitespace-pre-line {
        white-space: pre-line;
    }
</style>
@endpush