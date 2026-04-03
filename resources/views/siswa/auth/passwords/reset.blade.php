@extends('layouts.auth')

@section('title', 'Atur Password Baru - Portal Siswa')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-display">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center px-4">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-8 group">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-white">school</span>
            </div>
            <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-none">TK HARAPAN BANGSA 1</span>
        </a>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Atur Password Baru</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            Silakan masukkan password baru untuk akun: 
            <span class="font-bold text-slate-900 dark:text-white">{{ session('reset_email') }}</span>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white dark:bg-slate-900 py-10 px-8 shadow-2xl shadow-slate-200/50 dark:shadow-none sm:rounded-[3rem] border border-slate-100 dark:border-slate-800">
            <form class="space-y-6" action="{{ route('siswa.password.update') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Password Baru</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                        <input id="password" name="password" type="password" required autofocus
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all dark:text-white" 
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Konfirmasi Password Baru</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all dark:text-white" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-primary/20 text-sm font-bold text-white bg-primary hover:bg-primary-dark hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all uppercase tracking-widest">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
