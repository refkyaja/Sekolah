<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pendaftaran Siswa Baru - TK Harapan Bangsa 1</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                colors: {
                  "primary": "#4c99e6",
                  "background-light": "#f6f7f8",
                  "background-dark": "#111921",
                },
                fontFamily: {
                  "display": ["Inter"]
                },
                borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
              },
            },
          }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center">
<div class="flex flex-col md:flex-row w-full min-h-screen overflow-hidden">
    <!-- Sidebar / Illustration -->
    <div class="hidden md:flex md:w-1/2 bg-primary/10 dark:bg-primary/5 flex-col justify-center items-center p-12 relative overflow-hidden">
        <div class="absolute top-10 left-10 flex items-center gap-2">
            <div class="size-8 bg-primary text-white rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined">school</span>
            </div>
            <h2 class="text-xl font-bold tracking-tight">TK Harapan Bangsa 1</h2>
        </div>
        <div class="relative z-10 text-center max-w-md">
            <div class="mb-8 rounded-xl overflow-hidden shadow-2xl rotate-2">
                <img alt="Happy Child" class="w-full h-80 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBwW1kA916TWZNMaUVvNBqwe8uKy51aGNd0sZqbX-gUz552BTVm9-Wcc8IVB4moQlwLY7SAv5XVD9XArJdOYxnJELc4LuYD4GBGL6VGOE7ic--FPxUeQNnrP2ycBnfjVYe0rwCeLQDMan20Tj_CwQItoYFF7acuNPlBv0_FSNkeWDG4xQGv26TdY2ssrM03SXw9laQjjuH3wsnTiU7VxJF5SpYtHgYh4qjhjL2jkAnfgEjiyhgZFp28MsWnqLwfRY4ENTp6EwLW0CE"/>
            </div>
            <h1 class="text-4xl font-black leading-tight mb-4 text-slate-900 dark:text-white">
                Bergabunglah dengan Keluarga Besar Kami!
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Mulai perjalanan pendidikan terbaik untuk buah hati Anda bersama kurikulum unggulan kami.
            </p>
        </div>
        <div class="absolute -bottom-20 -left-20 size-64 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute -top-20 -right-20 size-64 bg-primary/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Registration Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-16 bg-white dark:bg-background-dark">
        <div class="w-full max-w-md">
            <div class="md:hidden flex items-center gap-2 mb-8">
                <div class="size-8 bg-primary text-white rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight">TK Harapan Bangsa 1</h2>
            </div>
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Daftar Akun Baru</h2>
                <p class="text-slate-600 dark:text-slate-400">Lengkapi data di bawah ini untuk memulai pendaftaran siswa.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-500 rounded-xl text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.storeRegister') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap Orang Tua</label>
                        <input name="nama_ortu" value="{{ old('nama_ortu') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="Nama Orang Tua" type="text"/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Calon Siswa</label>
                        <input name="nama_siswa" value="{{ old('nama_siswa') }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="Nama Calon Siswa" type="text"/>
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Utama</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">alternate_email</span>
                        <input name="email" value="{{ old('email') }}" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="contoh@email.com" type="email"/>
                    </div>
                    <p class="text-[11px] text-slate-500">Email ini akan digunakan untuk login siswa.</p>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">call</span>
                        <input name="whatsapp" value="{{ old('whatsapp') }}" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="0812xxxxxx" type="tel"/>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                            <input name="password" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="••••••••" type="password"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">verified_user</span>
                            <input name="password_confirmation" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" placeholder="••••••••" type="password"/>
                        </div>
                    </div>
                </div>
                <button class="w-full py-3.5 bg-primary hover:bg-primary/90 text-white font-bold rounded-xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2 mt-2" type="submit">
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <div class="mt-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Atau</span>
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
            </div>

            <div class="mt-6 flex flex-col gap-3">
                <a href="{{ route('siswa.login.google') }}" class="w-full flex items-center justify-center gap-3 py-3 rounded-xl border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" viewbox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Daftar dengan Google</span>
                </a>
            </div>

            <p class="mt-8 text-center text-sm text-slate-600 dark:text-slate-400">
                Sudah punya akun? 
                <a class="text-primary font-bold hover:underline" href="{{ route('siswa.login') }}">Login di sini</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
