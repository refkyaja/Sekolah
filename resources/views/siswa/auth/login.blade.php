<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Siswa - TK Harapan Bangsa 2</title>
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
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
<div class="flex min-h-screen flex-col lg:flex-row">
    <!-- Illustration Side (Visible on large screens) -->
    <div class="hidden lg:flex lg:w-1/2 bg-primary/10 items-center justify-center p-12 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 bg-primary/20 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/20 rounded-full translate-x-1/4 translate-y-1/4"></div>
        <div class="relative z-10 flex flex-col items-center text-center max-w-lg">
            <div class="w-full aspect-square rounded-xl bg-white shadow-xl mb-10 overflow-hidden" data-alt="Friendly illustration of happy children playing in a school garden">
                <img alt="Happy Children" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuACVV_hDmgPEnNf0KAKZAqIfF1kMOJhtIjn424Ma-D-SZqQMeXvA5RFYb5qvNacY4T9I3RFe50hJG8l6cCx55RLfYKcMl4cIHsqaINdk2vNGGhdzERQ3ctA6gtnVg7vZgLhSwN_uIDDADx5E7r0rFEPHQ4KHpsb77tpQ95hImThEqxTg6EsTo39Jcf7GLGCuG8W2_2OYuB5AFKKLdT_hQZyU1LXkAs8ICn7tC_5AHVw18zM8QSQv9i_Kkzntrj6Cyf461sh8Ag70Zk"/>
            </div>
            <h1 class="text-4xl font-black text-slate-900 mb-4">Welcome to TK Harapan Bangsa 1</h1>
            <p class="text-lg text-slate-600 font-medium leading-relaxed">Join our community of happy learners and bright futures. We're excited to see you today!</p>
        </div>
    </div>
    
    <!-- Login Form Side -->
    <div class="flex flex-1 flex-col justify-center px-6 py-12 lg:px-24 bg-white dark:bg-background-dark">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Mobile Logo and Name -->
            <div class="flex items-center gap-3 mb-10">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-slate-100">TK Harapan Bangsa 1</h2>
            </div>
            
            <div class="mb-8">
                <h3 class="text-3xl font-black text-slate-900 dark:text-white leading-tight">Login Orang Tua</h3>
                <p class="mt-2 text-base text-slate-500 dark:text-slate-400">Please login to your account to continue</p>
            </div>
            
            <div class="space-y-6">
                <!-- Social Login -->
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('siswa.login.google') }}" class="flex w-full items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus-visible:ring-primary focus-visible:outline-none transition-all">
                        <svg class="h-5 w-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                        </svg>
                        <span class="text-sm leading-6">Sign in with Google</span>
                    </a>
                </div>

                <div class="relative">
                    <div aria-hidden="true" class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                    </div>
                    <div class="relative flex justify-center text-sm font-medium leading-6">
                        <span class="bg-white dark:bg-background-dark px-4 text-slate-500">Or continue with username</span>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm font-medium border border-red-100">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email Login Form -->
                <form action="{{ route('siswa.authenticate') }}" class="space-y-5" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold leading-6 text-slate-900 dark:text-slate-100 mb-2" for="email">Email</label>
                        <input autocomplete="email" class="block w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 transition-all" id="email" name="email" placeholder="Masukkan email" required type="email" value="{{ old('email') }}"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold leading-6 text-slate-900 dark:text-slate-100 mb-2" for="password">Password</label>
                        <div class="relative">
                            <input autocomplete="current-password" class="block w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 pr-12 text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 transition-all" id="password" name="password" placeholder="Enter your password" required type="password"/>
                            <button class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600" type="button" onclick="const pass=document.getElementById('password'); pass.type=pass.type==='password'?'text':'password';">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary" id="remember-me" name="remember-me" type="checkbox"/>
                            <label class="ml-3 block text-sm font-medium leading-6 text-slate-600 dark:text-slate-400" for="remember-me">Remember me</label>
                        </div>
                    </div>
                    
                    <div>
                        <button class="flex w-full justify-center rounded-xl bg-primary px-4 py-4 text-sm font-bold leading-6 text-white shadow-lg hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all active:scale-[0.98]" type="submit">
                            Login to Account
                        </button>
                    </div>
                </form>
                
                <div class="mt-10 border-t border-slate-100 dark:border-slate-800 pt-8 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Belum punya akun? <a href="{{ route('siswa.register') }}" class="text-primary font-bold hover:underline">Daftar di sini</a> atau registrasi instan dengan Google di atas.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer Small -->
        <div class="mt-auto pt-10 text-center">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} TK Harapan Bangsa 1. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
