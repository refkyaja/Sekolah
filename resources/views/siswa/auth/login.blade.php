@extends('layouts.auth')

@section('title', 'Login PPDB - Portal Penerimaan')

@section('content')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
        <main class="flex flex-1 items-center justify-center p-6 lg:p-20 relative">
            <div class="absolute inset-0 z-0 opacity-10 pointer-events-none overflow-hidden">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-primary blur-[120px]"></div>
            </div>
            <div class="layout-content-container flex flex-col w-full max-w-[1100px] bg-white dark:bg-background-dark/80 rounded-xl overflow-hidden shadow-2xl border border-primary/10 z-10 lg:flex-row">
                <div class="hidden lg:flex flex-1 relative min-h-[500px] bg-primary/5">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary to-primary/60 mix-blend-multiply opacity-20"></div>
                    <div class="relative z-10 flex flex-col justify-center p-12 text-slate-900 dark:text-slate-100">
                        <h1 class="text-4xl font-black mb-6 leading-tight">Mulai Perjalanan Akademikmu Disini.</h1>
                        <p class="text-lg opacity-80 mb-8">Bergabunglah dengan ribuan calon siswa lainnya dan raih masa depan gemilang bersama institusi kami.</p>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                                <span>Pendaftaran Online yang Mudah</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                                <span>Pantau Status Seleksi Real-time</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary font-bold">check_circle</span>
                                <span>Pusat Bantuan Calon Siswa 24/7</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 w-full h-full opacity-10 pointer-events-none bg-no-repeat bg-right-bottom" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAXaOVCdZy-n6N7cuEccK6oo-YJUF_K_WcaExus2-mCHnL4NrqAraY9Yz2Z8PoUvzoNZ7rEyiXqN3HXOAWk8DFsyvTqp-IYTNr1102Ggkryjv_wqF-VzwriN8ttcB_EmOPixmsefMtNS34KYHLgQq_FpSxSozeQsGWOht03jUzc-4DxQyY1KyLkxWpS8mAmQ5WyQu8F13AwpXSa3cfmie4NJmOC38Y6miuPDIyL3JVXVS0tvaOaqzSBZUPzM9f3I1x8yhWukgvOgg4');">
                    </div>
                </div>
                <div class="flex-1 flex flex-col p-8 lg:p-12 justify-center relative">
                    <div class="mb-8">
                        <a href="{{ route('ppdb.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold mb-6 hover:opacity-80 transition-opacity">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            <span>Kembali</span>
                        </a>
                        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Login Calon Siswa</h2>
                        <p class="text-slate-500 dark:text-slate-400">Silakan masuk ke akun pendaftaran Anda</p>
                    </div>

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
                    </div>
                    @endif

                    <form class="flex flex-col gap-5" method="POST" action="{{ route('siswa.authenticate') }}">
                        @csrf
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">person</span>
                                <input name="email" value="{{ old('email') }}" class="w-full pl-12 pr-4 py-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="name@example.com" type="email" required/>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Kata Sandi</label>
                                
                            </div>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-4 text-slate-400">lock</span>
                                <input name="password" class="w-full pl-12 pr-12 py-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" placeholder="Masukkan kata sandi" type="password" required/>
                            </div><a class="text-xs font-bold text-primary hover:underline mt-2 self-end tracking-tight" href="{{ route('siswa.password.request') }}">
                                Lupa Password?
                            </a>
                        </div>
                        <button class="w-full py-4 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all mt-2" type="submit">
                            Masuk ke Portal
                        </button>
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-background-dark text-slate-500">Atau masuk dengan</span>
                            </div>
                        </div>
                        <a href="{{ route('siswa.login.google') }}" class="w-full py-3 px-4 border border-slate-200 dark:border-slate-700 rounded-xl flex items-center justify-center gap-3 bg-white dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200 font-medium">
                            <svg class="w-5 h-5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                            </svg>
                            Google
                        </a>
                    </form>
                    <div class="mt-8 text-center">
                        <p class="text-slate-600 dark:text-slate-400">
                            Belum punya akun? 
                            <a class="text-primary font-bold hover:underline" href="{{ route('siswa.register') }}">Daftar Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </main>
        <footer class="p-8 text-center text-slate-400 text-sm">
            <p>© {{ date('Y') }} Portal Penerimaan Siswa. Hak Cipta Dilindungi.</p>
        </footer>
    </div>
</div>
@endsection
