@extends('layouts.admin')

@section('title', 'Pengaturan SPMB')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-cogs mr-2"></i>Pengaturan SPMB
                </h1>
                <p class="text-gray-600 mt-2">Atur jadwal dan parameter SPMB {{ $setting->tahun_ajaran ?? '2026/2027' }}</p>
            </div>
            <a href="{{ route('admin.spmb.index') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <div>
                <p class="font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Form Pengaturan -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
            <h3 class="text-lg font-medium text-gray-900">Pengaturan Sistem SPMB</h3>
            <p class="text-sm text-gray-600">Atur jadwal dan parameter pendaftaran</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.spmb.updatePengaturan') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Informasi Umum -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Informasi Umum</h4>
                            <p class="text-sm text-gray-600">Informasi dasar SPMB</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun Ajaran -->
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran *
                            </label>
                            <input type="text" 
                                   id="tahun_ajaran"
                                   name="tahun_ajaran" 
                                   value="{{ old('tahun_ajaran', $setting->tahun_ajaran ?? '2026/2027') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Gelombang -->
                        <div>
                            <label for="gelombang" class="block text-sm font-medium text-gray-700 mb-2">
                                Gelombang
                            </label>
                            <select id="gelombang" 
                                    name="gelombang" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="1" {{ (old('gelombang', $setting->gelombang ?? 1) == 1) ? 'selected' : '' }}>Gelombang 1</option>
                                <option value="2" {{ (old('gelombang', $setting->gelombang ?? 1) == 2) ? 'selected' : '' }}>Gelombang 2</option>
                                <option value="3" {{ (old('gelombang', $setting->gelombang ?? 1) == 3) ? 'selected' : '' }}>Gelombang 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Pendaftaran -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Jadwal Pendaftaran</h4>
                            <p class="text-sm text-gray-600">Atur periode pendaftaran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pendaftaran Mulai -->
                        <div>
                            <label for="pendaftaran_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendaftaran Mulai *
                            </label>
                            <input type="datetime-local" 
                                   id="pendaftaran_mulai"
                                   name="pendaftaran_mulai" 
                                   value="{{ old('pendaftaran_mulai', isset($setting->pendaftaran_mulai) ? $setting->pendaftaran_mulai->format('Y-m-d\TH:i') : '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pendaftaran Selesai -->
                        <div>
                            <label for="pendaftaran_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Pendaftaran Selesai *
                            </label>
                            <input type="datetime-local" 
                                   id="pendaftaran_selesai"
                                   name="pendaftaran_selesai" 
                                   value="{{ old('pendaftaran_selesai', isset($setting->pendaftaran_selesai) ? $setting->pendaftaran_selesai->format('Y-m-d\TH:i') : '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Jadwal Pengumuman -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullhorn text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Jadwal Pengumuman</h4>
                            <p class="text-sm text-gray-600">Atur periode pengumuman hasil</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pengumuman Mulai -->
                        <div>
                            <label for="pengumuman_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengumuman Mulai *
                            </label>
                            <input type="datetime-local" 
                                   id="pengumuman_mulai"
                                   name="pengumuman_mulai" 
                                   value="{{ old('pengumuman_mulai', isset($setting->pengumuman_mulai) ? $setting->pengumuman_mulai->format('Y-m-d\TH:i') : '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Pengumuman Selesai -->
                        <div>
                            <label for="pengumuman_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengumuman Selesai *
                            </label>
                            <input type="datetime-local" 
                                   id="pengumuman_selesai"
                                   name="pengumuman_selesai" 
                                   value="{{ old('pengumuman_selesai', isset($setting->pengumuman_selesai) ? $setting->pengumuman_selesai->format('Y-m-d\TH:i') : '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Status Pengumuman -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status_pengumuman" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Pengumuman
                            </label>
                            <select id="status_pengumuman" 
                                    name="status_pengumuman" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="draft" {{ (old('status_pengumuman', $setting->status_pengumuman ?? 'draft') == 'draft') ? 'selected' : '' }}>Draft</option>
                                <option value="ready" {{ (old('status_pengumuman', $setting->status_pengumuman ?? 'draft') == 'ready') ? 'selected' : '' }}>Siap</option>
                            </select>
                        </div>

                        <!-- Publish Status -->
                        <div>
                            <div class="flex items-center h-full">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="is_published"
                                           name="is_published" 
                                           value="1"
                                           {{ old('is_published', $setting->is_published ?? false) ? 'checked' : '' }}
                                           class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                    <label for="is_published" class="ml-2 text-sm font-medium text-gray-700">
                                        Publikasikan Pengumuman
                                    </label>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Centang untuk membuka akses pengumuman ke publik
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kuota Jalur -->
                <div class="space-y-6 pt-8 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">Kuota Jalur</h4>
                            <p class="text-sm text-gray-600">Atur persentase kuota per jalur</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Zonasi -->
                        <div>
                            <label for="kuota_zonasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Kuota Zonasi (%)
                            </label>
                            <input type="number" 
                                   id="kuota_zonasi"
                                   name="kuota_zonasi" 
                                   min="0" max="100"
                                   value="{{ old('kuota_zonasi', $setting->kuota_zonasi ?? 50) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Minimal 50%</p>
                        </div>

                        <!-- Afirmasi -->
                        <div>
                            <label for="kuota_afirmasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Kuota Afirmasi (%)
                            </label>
                            <input type="number" 
                                   id="kuota_afirmasi"
                                   name="kuota_afirmasi" 
                                   min="0" max="100"
                                   value="{{ old('kuota_afirmasi', $setting->kuota_afirmasi ?? 15) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Minimal 15%</p>
                        </div>

                        <!-- Prestasi -->
                        <div>
                            <label for="kuota_prestasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Kuota Prestasi (%)
                            </label>
                            <input type="number" 
                                   id="kuota_prestasi"
                                   name="kuota_prestasi" 
                                   min="0" max="100"
                                   value="{{ old('kuota_prestasi', $