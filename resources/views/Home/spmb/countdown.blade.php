@extends('layouts.nav-spmb')

@section('title', 'Countdown Pengumuman SPMB - TK Ceria Bangsa')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-purple-50 to-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $setting = App\Models\SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
        @endphp
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            @extends('layouts.nav-spmb')

            @section('title', 'Countdown Pengumuman SPMB - TK Ceria Bangsa')

            @section('content')
            <div class="min-h-screen bg-gradient-to-b from-purple-50 to-gray-50 py-8">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    @php
                        $setting = App\Models\SpmbSetting::where('tahun_ajaran', '2026/2027')->first();
                        $now = now();
                        $isPengumumanOpen = $setting && $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);
                        $isPublished = $setting && $setting->is_published;
                    @endphp
        
                    @if(!$isPengumumanOpen)
                    <!-- Jika belum waktunya pengumuman -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                        <div class="inline-flex items-center justify-center p-6 bg-yellow-100 rounded-full mb-6">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Belum Waktu Pengumuman</h2>
                        <p class="text-gray-600 mb-6">
                            Halaman ini hanya dapat diakses ketika waktu pengumuman sudah dimulai tetapi belum dipublikasikan.
                        </p>
                        <a href="{{ route('spmb.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Kembali ke Halaman Utama SPMB
                        </a>
                    </div>
                    @elseif($isPublished)
                    <!-- Jika sudah dipublikasikan -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                        <div class="inline-flex items-center justify-center p-6 bg-green-100 rounded-full mb-6">
                            <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Pengumuman Sudah Dibuka</h2>
                        <p class="text-gray-600 mb-6">
                            Hasil seleksi sudah dapat dilihat di halaman pengumuman.
                        </p>
                        <a href="{{ route('spmb.pengumuman') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-medium rounded-lg hover:from-green-700 hover:to-green-800 transition">
                            <i class="fas fa-bullhorn mr-3"></i>
                            Lihat Hasil Seleksi
                        </a>
                    </div>
                    @else
                    <!-- Countdown Content -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-purple-600 to-purple-800 px-8 py-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">Countdown Pengumuman</h2>
                                    <p class="opacity-90 mt-1">Tunggu sebentar, pengumuman akan segera ditampilkan</p>
                                </div>
                                <div class="hidden md:block">
                                    <div class="px-4 py-2 bg-purple-500 bg-opacity-30 rounded-lg">
                                        <p class="text-sm">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ now()->translatedFormat('d F Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Countdown Content -->
                        <div class="p-8 text-center">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center p-6 bg-purple-100 rounded-full mb-6">
                                <i class="fas fa-hourglass-half text-purple-600 text-4xl"></i>
                            </div>
                
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Pengumuman Segera Ditampilkan</h3>
                            <p class="text-gray-600 mb-8">
                                Hasil seleksi SPMB TK Ceria Bangsa Tahun Ajaran 2026/2027 akan ditampilkan dalam:
                            </p>
                
                            <!-- Countdown Timer -->
                            <div id="countdown" class="grid grid-cols-4 gap-4 max-w-md mx-auto mb-8">
                                <div class="text-center">
                                    <div class="bg-purple-600 text-white text-3xl font-bold py-4 rounded-lg" id="days">00</div>
                                    <div class="text-sm text-gray-600 mt-2">Hari</div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-purple-600 text-white text-3xl font-bold py-4 rounded-lg" id="hours">00</div>
                                    <div class="text-sm text-gray-600 mt-2">Jam</div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-purple-600 text-white text-3xl font-bold py-4 rounded-lg" id="minutes">00</div>
                                    <div class="text-sm text-gray-600 mt-2">Menit</div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-purple-600 text-white text-3xl font-bold py-4 rounded-lg" id="seconds">00</div>
                                    <div class="text-sm text-gray-600 mt-2">Detik</div>
                                </div>
                            </div>
                
                            <!-- Info -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                                <div class="flex items-center justify-center mb-4">
                                    <i class="fas fa-info-circle text-gray-600 mr-3"></i>
                                    <h4 class="font-bold text-gray-900">Informasi</h4>
                                </div>
                                <ul class="text-gray-700 text-left max-w-md mx-auto space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Pengumuman akan ditampilkan otomatis setelah countdown selesai</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Pastikan koneksi internet stabil</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Jika halaman tidak refresh otomatis, klik tombol dibawah</span>
                                    </li>
                                </ul>
                            </div>
                
                            <!-- Manual Refresh Button -->
                            <div class="mt-6">
                                <button onclick="window.location.reload()" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition mr-3">
                                    <i class="fas fa-redo mr-3"></i>
                                    Refresh Halaman
                                </button>
                    
                                <a href="{{ route('spmb.index') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                                    <i class="fas fa-arrow-left mr-3"></i>
                                    Kembali ke Halaman Utama
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($isPengumumanOpen && !$isPublished)
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil waktu pengumuman dari setting (UTC dari server)
                const setting = @json($setting);
    
                if (!setting || !setting.pengumuman_mulai) {
                    const countdownEl = document.getElementById('countdown');
                    if (countdownEl) {
                        countdownEl.innerHTML = `
                            <div class="col-span-4 text-center">
                                <div class="text-red-600 mb-4">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Data pengaturan tidak ditemukan
                                </div>
                            </div>
                        `;
                    }
                    return;
                }
    
                // Parse waktu UTC dari server
                const pengumumanMulaiUTC = new Date(setting.pengumuman_mulai);
                const nowUTC = new Date();
    
                // Hitung waktu berdasarkan UTC untuk menghindari timezone issues
                const targetTime = pengumumanMulaiUTC.getTime();
                const serverTime = nowUTC.getTime();
    
                function updateCountdown() {
                    const now = new Date().getTime();
                    const serverNow = serverTime + (now - Date.now()); // Sync dengan waktu server
        
                    const distance = targetTime - serverNow;
        
                    // Jika countdown selesai
                    if (distance <= 0) {
                        // Show success message
                        const countdownEl = document.getElementById('countdown');
                        if (countdownEl) {
                            countdownEl.innerHTML = `
                                <div class="col-span-4 text-center">
                                    <div class="text-3xl font-bold text-green-600 mb-4">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Waktu Pengumuman Telah Tiba!
                                    </div>
                                    <p class="text-gray-600 mb-4">Mengarahkan ke halaman pengumuman...</p>
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                                </div>
                            `;
                        }

                        // Redirect ke pengumuman setelah 2 detik
                        setTimeout(() => {
                            window.location.href = "{{ route('spmb.pengumuman') }}?_=" + new Date().getTime();
                        }, 2000);

                        return;
                    }
        
                    // Hitung waktu
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
                    // Update tampilan
                    const daysEl = document.getElementById('days');
                    const hoursEl = document.getElementById('hours');
                    const minutesEl = document.getElementById('minutes');
                    const secondsEl = document.getElementById('seconds');
                    if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                    if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                    if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                    if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
                }
    
                // Jalankan dan update setiap detik
                updateCountdown();
                const countdownInterval = setInterval(updateCountdown, 1000);

                // Cleanup interval on page unload
                window.addEventListener('beforeunload', () => {
                    clearInterval(countdownInterval);
                });
            });
            </script>
            @endif
            @endsection