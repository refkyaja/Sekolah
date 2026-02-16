<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Forgot Password</title>

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
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 15px;
            display: inline-block;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-link {
            transition: all 0.3s ease;
        }

        .back-link:hover {
            transform: translateX(-5px);
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
                        </div>
                    </div>
                    
                    <h1 class="text-5xl font-bold mb-4">Forgot Password?</h1>
                    <p class="text-xl text-white/80 mb-8">Jangan khawatir! Kami akan mengirimkan link reset password ke email Anda.</p>
                    
                    <!-- Steps -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">1</span>
                            </div>
                            <span class="text-white/90">Masukkan email Anda</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2</span>
                            </div>
                            <span class="text-white/90">Cek inbox email Anda</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">3</span>
                            </div>
                            <span class="text-white/90">Klik link reset password</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">4</span>
                            </div>
                            <span class="text-white/90">Buat password baru Anda</span>
                        </div>
                    </div>

                    <!-- Security Note -->
                    <div class="mt-8 p-4 bg-white/10 rounded-lg border border-white/20">
                        <p class="text-sm text-white/80 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Link reset password akan kadaluarsa dalam 60 menit
                        </p>
                    </div>
                </div>

                <!-- Right Side - Forgot Password Form -->
                <div class="w-full max-w-md mx-auto">
                    <div class="glass-effect-dark rounded-2xl p-8 shadow-2xl">
                        <!-- Logo for mobile -->
                        <div class="lg:hidden text-center mb-8">
                            <div class="logo-container inline-block mb-4">
                                <img src="/images/logo.png" alt="Logo" class="w-20 h-20 object-contain">
                            </div>
                            <h2 class="text-2xl font-bold text-white">Forgot Password?</h2>
                        </div>

                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-white hidden lg:block mb-2">Reset Password</h2>
                            <p class="text-white/70 text-sm">
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg">
                                <p class="text-green-200 text-sm flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ session('status') }}
                                </p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                                        class="input-animation block w-full pl-10 pr-3 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:border-white/40 focus:ring-2 focus:ring-white/20"
                                        placeholder="your@email.com">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <button type="submit" class="btn-animation w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-transparent">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ __('Email Password Reset Link') }}
                                    </span>
                                </button>

                                <!-- Back to Login -->
                                <a href="{{ route('login') }}" class="back-link w-full flex items-center justify-center text-white/70 hover:text-white transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    {{ __('Back to Login') }}
                                </a>
                            </div>
                        </form>

                        <!-- Additional Help -->
                        <div class="mt-6 pt-6 border-t border-white/10 text-center">
                            <p class="text-white/50 text-xs">
                                Tidak menerima email? Cek folder spam atau 
                                <button type="button" onclick="resendEmail()" class="text-indigo-300 hover:text-indigo-200 transition-colors">
                                    kirim ulang
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resendEmail() {
            // Optional: Add resend functionality
            alert('Silakan cek folder spam Anda. Jika tidak ada, tunggu beberapa menit dan coba lagi.');
        }
    </script>
</body>
</html>