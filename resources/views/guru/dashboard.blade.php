{{-- resources/views/guru/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Dashboard Guru</h2>
                
                <!-- Info Guru -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="Foto Profil" 
                                 class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md">
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->nama_lengkap }}</h3>
                            <p class="text-gray-600">
                                <i class="fas fa-envelope mr-2"></i>{{ auth()->user()->email }}
                            </p>
                            @if(auth()->user()->guru)
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                    <i class="fas fa-id-card mr-1"></i>{{ auth()->user()->guru->nip ?? 'N/A' }}
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                    <i class="fas fa-briefcase mr-1"></i>{{ auth()->user()->guru->jabatan_formatted }}
                                </span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                    <i class="fas fa-users mr-1"></i>{{ auth()->user()->guru->kelompok_formatted }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <a href="{{ route('guru.absensi.index') }}" 
                       class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fas fa-clipboard-check text-3xl mb-4"></i>
                                <h4 class="text-lg font-bold">Absensi Siswa</h4>
                                <p class="text-sm opacity-90">Isi absensi hari ini</p>
                            </div>
                            <i class="fas fa-arrow-right text-xl"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('guru.profile') }}" 
                       class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fas fa-user-edit text-3xl mb-4"></i>
                                <h4 class="text-lg font-bold">Profil Saya</h4>
                                <p class="text-sm opacity-90">Edit data pribadi</p>
                            </div>
                            <i class="fas fa-arrow-right text-xl"></i>
                        </div>
                    </a>
                    
                    <a href="#" 
                       class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg p-6 text-white shadow-lg hover:shadow-xl transition-shadow duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fas fa-calendar-alt text-3xl mb-4"></i>
                                <h4 class="text-lg font-bold">Jadwal</h4>
                                <p class="text-sm opacity-90">Lihat jadwal mengajar</p>
                            </div>
                            <i class="fas fa-arrow-right text-xl"></i>
                        </div>
                    </a>
                </div>

                <!-- Stats -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Statistik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-2xl font-bold text-blue-600">15</div>
                            <div class="text-sm text-gray-600">Siswa Aktif</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-2xl font-bold text-green-600">98%</div>
                            <div class="text-sm text-gray-600">Kehadiran</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-2xl font-bold text-yellow-600">24</div>
                            <div class="text-sm text-gray-600">Pelajaran/Bulan</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-2xl font-bold text-purple-600">5</div>
                            <div class="text-sm text-gray-600">Tugas Terbaru</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection