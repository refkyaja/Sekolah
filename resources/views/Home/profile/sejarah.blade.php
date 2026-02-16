@extends('layouts.guest')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $title }}</h1>
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    {{ $content }}
                </p>
                <p class="text-gray-700 leading-relaxed">
                    TK Ceria Bangsa terus berkembang dengan fasilitas yang lengkap dan guru-guru yang berpengalaman...
                </p>
            </div>
        </div>
    </div>
</div>
@endsection