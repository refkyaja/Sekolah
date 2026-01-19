@extends('layouts.guest')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h1>
            <p class="text-gray-600">Tahun Ajaran 2024/2025</p>
            <div class="w-24 h-1 bg-yellow-500 mx-auto mt-4"></div>
        </div>

        <!-- Info Pendaftaran -->
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 mb-8">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-yellow-600 text-xl mt-1 mr-3"></i>
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Informasi Penting</h3>
                    <ul class="text-gray-700 space-y-1">
                        <li>• Pendaftaran dibuka: 1 Januari - 30 Juni 2024</li>
                        <li>• Kuota terbatas: 30 siswa per kelas</li>
                        <li>• Tes masuk: 1-5 Juli 2024</li>
                        <li>• Pengumuman: 10 Juli 2024</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Pendaftaran -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Formulir Pendaftaran</h2>
            
            <form action="{{ route('ppdb.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Data Calon Siswa -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Calon Siswa</h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required 
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Tempat Lahir *</label>
                            <input type="text" name="tempat_lahir" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Tanggal Lahir *</label>
                            <input type="date" name="tanggal_lahir" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua</h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Nama Ayah *</label>
                            <input type="text" name="nama_ayah" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Nama Ibu *</label>
                            <input type="text" name="nama_ibu" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-2">Alamat Lengkap *</label>
                        <textarea name="alamat" rows="3" required 
                                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-2">Nomor Telepon/WhatsApp *</label>
                        <input type="tel" name="telepon" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Kelas yang Dipilih -->
                <div class="pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilihan Kelas</h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Program yang Dipilih *</label>
                            <select name="program" required 
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Program</option>
                                <option value="kelompok-bermain">Kelompok Bermain (3-4 tahun)</option>
                                <option value="tk-a">TK A (4-5 tahun)</option>
                                <option value="tk-b">TK B (5-6 tahun)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Tahun Ajaran *</label>
                            <select name="tahun_ajaran" required 
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="2024/2025">2024/2025</option>
                                <option value="2025/2026">2025/2026</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-4 px-6 rounded-lg transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i> Kirim Pendaftaran
                    </button>
                    
                    <a href="{{ route('home') }}" 
                       class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-4 px-6 rounded-lg text-center transition duration-300">
                        Kembali ke Beranda
                    </a>
                </div>
                
                <p class="text-gray-600 text-sm mt-4">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Data yang Anda kirim akan kami proses maksimal 3x24 jam.
                </p>
            </form>
        </div>

        <!-- Kontak Bantuan -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp
                </a>
                <a href="tel:+622212345678"
                   class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    <i class="fas fa-phone mr-2"></i> Telepon: (022) 1234-5678
                </a>
            </div>
        </div>
    </div>
</div>
@endsection