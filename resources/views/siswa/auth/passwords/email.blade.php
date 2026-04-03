@extends('layouts.auth')

@section('title', 'Lupa Password - Portal Siswa')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-display">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center px-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-8 group">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-white">school</span>
            </div>
            <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-none">TK HARAPAN BANGSA 1</span>
        </a>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Lupa Password?</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            Masukkan email yang terdaftar untuk mendapatkan kode verifikasi.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white dark:bg-slate-900 py-10 px-8 shadow-2xl shadow-slate-200/50 dark:shadow-none sm:rounded-[3rem] border border-slate-100 dark:border-slate-800">
            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 flex items-center gap-3 text-green-700 animate-fade-in">
                    <span class="material-symbols-outlined">check_circle</span>
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('siswa.password.otp') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all dark:text-white" 
                            placeholder="nama@email.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-primary/20 text-sm font-bold text-white bg-primary hover:bg-primary-dark hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all uppercase tracking-widest">
                        Dapatkan Kode
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">
                    Ingat password Anda? 
                    <a href="{{ route('siswa.login') }}" class="font-bold text-primary hover:underline transition-all">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
