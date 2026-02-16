@extends('layouts.guest')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Visi -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-eye text-blue-600 text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Visi</h2>
            </div>
            <p class="text-gray-700 text-lg leading-relaxed">{{ $visi }}</p>
        </div>

        <!-- Misi -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-bullseye text-green-600 text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Misi</h2>
            </div>
            
            <div class="space-y-4">
                @foreach($misi as $item)
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                    <p class="text-gray-700">{{ $item }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection