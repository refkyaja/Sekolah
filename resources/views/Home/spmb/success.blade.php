@extends('layouts.guest')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 flex items-center justify-center">
    <div class="max-w-md mx-auto px-4 text-center">
        <!-- Icon Success -->
        <div class="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-green-600 text-4xl"></i>
        </div>
        
        <!-- Message -->
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
        <p class="text-gray-700 mb-6">
            Terima kasih telah mendaftarkan putra/putri Anda di TK Ceria Bangsa.
            Data pendaftaran telah kami terima dan akan segera kami proses.
        </p>
        
        <!-- Info -->
        <div class="bg-blue-50 rounded-xl p-6 mb-8">
            <h3 class="font-bold text-gray-900 mb-3">Langkah Selanjutnya:</h3>
            <ul class="text-gray-700 text-left space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                    <span>Tim kami akan menghubungi Anda dalam 3x24 jam</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-calendar-alt text-blue-500 mt-1 mr-2"></i>
                    <span>Tes masuk akan dijadwalkan pada 1-5 Juli 2024</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-file-alt text-yellow-500 mt-1 mr-2"></i>
                    <span>Persiapkan dokumen: Akta Lahir, KK, dan Foto 3x4</span>
                </li>
            </ul>
        </div>
        
        <!-- Buttons -->
        <div class="space-y-4">
            <a href="{{ route('home') }}" 
               class="block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Kembali ke Beranda
            </a>
            
            <a href="https://wa.me/6281234567890" target="_blank"
               class="block border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-lg transition duration-300">
                <i class="fab fa-whatsapp mr-2"></i> Chat untuk Pertanyaan
            </a>
        </div>
        
        <!-- Note -->
        <p class="text-gray-600 text-sm mt-8">
            Nomor pendaftaran Anda: <span class="font-bold text-blue-600">PPDB-{{ date('Ymd') }}-{{ rand(1000, 9999) }}</span>
        </p>
    </div>
</div>
@endsection