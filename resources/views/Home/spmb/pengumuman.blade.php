@extends('layouts.app')

@section('title', 'Pengumuman SPMB - TK Ceria Bangsa')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-blue-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $setting = App\Models\SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
            $now = now();
            $isPengumumanOpen = $setting && $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);
            $isPublished = $setting && $setting->is_published;
        @endphp

        @if(!$isPengumumanOpen || !$isPublished)
            <!-- Waiting for Announcement -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="inline-flex items-center justify-center p-6 bg-yellow-100 rounded-full mb-6">
                    <i class="fas fa-hourglass-half text-yellow-600 text-4xl"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Pengumuman Belum Dibuka</h2>
                
                @if($setting && $now->lt($setting->pengumuman_mulai))
                    <p class="text-gray-600 mb-6">
                        Pengumuman hasil seleksi akan dibuka pada
                    </p>
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl p-6 inline-block mb-6">
                        <div class="text-3xl font-bold mb-2">
                            {{ $setting->pengumuman_mulai->translatedFormat('d F Y') }}
                        </div>
                        <div class="text-lg">
                            Pukul {{ $setting->pengumuman_mulai->translatedFormat('H:i') }} WIB
                        </div>
                    </div>
                @elseif($isPengumumanOpen && !$isPublished)
                    <p class="text-gray-600 mb-6">
                        Pengumuman sedang dipersiapkan
                    </p>
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl p-6 inline-block mb-6">
                        <div class="text-3xl font-bold mb-2">
                            Segera
                        </div>
                        <div class="text-lg">
                            Menunggu rilis dari admin
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 mb-6">
                        Periode pengumuman telah berakhir
                    </p>
                @endif
                
                <div class="bg-gray-100 rounded-lg p-6 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-gray-600 mt-1 mr-3"></i>
                        <div class="text-left">
                            <h4 class="font-medium text-gray-900 mb-2">Informasi Pengumuman</h4>
                            <ul class="text-gray-700 text-sm space-y-2">
                                <li>• Hasil seleksi akan diumumkan sesuai jadwal</li>
                                <li>• Pengumuman hanya dapat diakses dengan No. Pendaftaran dan NIK</li>
                                <li>• Hasil bersifat final dan tidak dapat diganggu gugat</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('spmb.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Kembali ke Halaman Utama SPMB
                    </a>
                </div>
            </div>
        @else
            <!-- Announcement Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Cek Hasil Seleksi SPMB</h2>
                            <p class="text-green-100 mt-1">Masukkan data untuk melihat pengumuman</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="px-4 py-2 bg-green-500 bg-opacity-30 rounded-lg">
                                <p class="text-white text-sm">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Periode: {{ $setting->pengumuman_mulai->translatedFormat('d M Y') }} - {{ $setting->pengumuman_selesai->translatedFormat('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('spmb.cek-pengumuman') }}" method="POST" class="space-y-6" id="formPengumuman">
                        @csrf
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-blue-800">Keamanan Data</h4>
                                    <p class="text-sm text-blue-700">Data Anda aman dan hanya dapat diakses oleh pemilik data</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    No. Pendaftaran
                                </label>
                                <input type="text" name="no_pendaftaran" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Contoh: SPMB-2026-00123">
                                <p class="text-xs text-gray-500 mt-1">Nomor yang didapat saat mendaftar</p>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-medium mb-2 required">
                                    NIK Calon Siswa
                                </label>
                                <input type="text" name="nik" required 
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="16 digit NIK">
                                <p class="text-xs text-gray-500 mt-1">Nomor Induk Kependudukan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <input type="checkbox" id="agreePrivacy" required 
                                   class="mt-1 mr-3 h-5 w-5 text-green-600 rounded focus:ring-green-500">
                            <label for="agreePrivacy" class="text-sm text-gray-700">
                                Saya menyetujui bahwa data yang saya masukkan adalah data pribadi saya sendiri.
                                Saya bertanggung jawab penuh atas keaslian data tersebut.
                            </label>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-search mr-3"></i>
                                Cek Hasil Seleksi
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="font-bold text-gray-900 mb-4">Informasi Tambahan</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-phone-alt text-gray-600 mr-3"></i>
                                    <h5 class="font-medium text-gray-900">Kontak Panitia</h5>
                                </div>
                                <p class="text-sm text-gray-700">Hubungi panitia jika mengalami kendala teknis</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-clock text-gray-600 mr-3"></i>
                                    <h5 class="font-medium text-gray-900">Batas Waktu</h5>
                                </div>
                                <p class="text-sm text-gray-700">Pengumuman dapat diakses hingga {{ $setting->pengumuman_selesai->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('spmb.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Halaman Utama SPMB
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPengumuman');
    if (form) {
        form.addEventListener('submit', function(e) {
            const agreePrivacy = document.getElementById('agreePrivacy');
            if (!agreePrivacy.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui pernyataan privasi terlebih dahulu');
                return false;
            }
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Memproses...';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endpush