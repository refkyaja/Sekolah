<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-effect-dark {
            background: rgba(17, 25, 40, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }
        
        .animated-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .input-animation {
            transition: all 0.3s ease;
        }
        
        .input-animation:focus {
            transform: scale(1.02);
        }
        
        .btn-animation {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-animation:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        .btn-animation::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-animation:active::after {
            width: 300px;
            height: 300px;
        }

        .logo-container {
            /* background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 15px;
            display: inline-block;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2); */
        }

        .eye-button {
            transition: all 0.2s ease;
        }

        .eye-button:hover {
            transform: scale(1.1);
        }

        .eye-button:active {
            transform: scale(0.95);
        }

        /* Fix untuk input autofill */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
            box-shadow: inset 0 0 20px 20px rgba(255, 255, 255, 0.1);
            caret-color: white;
        }

        /* Fix untuk background input saat diisi */
        input {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }

        input:focus {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        /* Placeholder color */
        input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
            opacity: 1;
        }

        /* Untuk Firefox */
        input:-moz-autofill {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden animated-bg">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full opacity-10 floating"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white rounded-full opacity-10 floating" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/4 w-60 h-60 bg-white rounded-full opacity-10 floating" style="animation-delay: 2s;"></div>
        </div>

        <!-- Main Container -->
        <div class="relative w-full max-w-6xl mx-4 z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <!-- Left Side - Branding -->
                <div class="hidden lg:block text-white">
                    <div class="floating">
                        <!-- Logo Image -->
                        <div class="logo-container">
                            <img src="/images/logo.png" alt="Logo" class="w-24 h-24 object-contain">
                            <!-- Atau gunakan logo dari internet untuk contoh -->
                            <!-- <img src="https://placehold.co/200x200/4f46e5/white?text=LOGO" alt="Logo" class="w-24 h-24"> -->
                        </div>
                    </div>
                    
                    <h1 class="text-5xl font-bold mb-4">Dashboard Manajemen</h1>
                    <p class="text-xl text-white/80 mb-8">Satu pintu untuk mengelola data, memantau kemajuan, dan mengambil keputusan berbasis informasi yang valid.</p>
                    
                    Features
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-white/90">Akses aman dan terenkripsi</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-white/90">Real-time monitoring data siswa & guru</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <span class="text-white/90">Keamanan data terjamin</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full max-w-md mx-auto">
                    <div class="glass-effect-dark rounded-2xl p-8 shadow-2xl">
                        <!-- Logo for mobile -->
                        <div class="lg:hidden text-center mb-8">
                            <div class="logo-container inline-block mb-4">
                                <img src="/images/logo.png" alt="Logo" class="w-20 h-20 object-contain">
                                <!-- <img src="https://placehold.co/200x200/4f46e5/white?text=LOGO" alt="Logo" class="w-20 h-20"> -->
                            </div>
                            <h2 class="text-2xl font-bold text-white">Login to Your Account</h2>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-200">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-white/90 mb-2">
                                    {{ __('Email Address') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m12 0a4 4 0 01-4 4H8a4 4 0 01-4-4V8a4 4 0 014-4h8a4 4 0 014 4v4z"></path>
                                        </svg>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                        class="input-animation block w-full pl-10 pr-3 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-white/40 focus:ring-2 focus:ring-white/20"
                                        placeholder="your@email.com"
                                        style="background-color: rgba(255, 255, 255, 0.1) !important; color: white !important;">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password with Eye Icon -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-white/90 mb-2">
                                    {{ __('Password') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input id="password" type="password" name="password" required autocomplete="current-password"
                                        class="input-animation block w-full pl-10 pr-12 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-white/40 focus:ring-2 focus:ring-white/20"
                                        placeholder="••••••••"
                                        style="background-color: rgba(255, 255, 255, 0.1) !important; color: white !important;">
                                    <button type="button" onclick="togglePassword()" class="eye-button absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <!-- Eye Open Icon -->
                                        <svg id="eyeOpen" class="h-5 w-5 text-white/70 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <!-- Eye Closed Icon (Hidden by default) -->
                                        <svg id="eyeClosed" class="h-5 w-5 text-white/70 hover:text-white transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input type="checkbox" name="remember" class="rounded bg-white/10 border-white/20 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-0">
                                    <span class="ml-2 text-sm text-white/80">{{ __('Remember me') }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-white/80 hover:text-white transition-colors">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div>
                                <button type="submit" class="btn-animation w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent">
                                    {{ __('Log in') }}
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-white/60">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline">
                                        Sign up
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>