<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TK PGRI Harapan Bangsa 1 - Bandung')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/home-animations.css', 'resources/js/home-animations.js'])

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#308ce8",
                        "secondary": "#fbbf24",
                        "accent": "#f472b6",
                        "accent-blue":      "#e0f2fe",
                        "accent-yellow":    "#fef3c7",
                        "accent-pink":      "#fce7f3",
                        "accent-purple":    "#ede9fe",
                        "accent-green":     "#dcfce7",
                        "cta-pink":         "#e85d97",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg":      "1.5rem",
                        "xl":      "2.5rem",
                        "2xl":     "3rem",
                        "full":    "9999px",
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Lexend', sans-serif; }
        .hero-gradient {
            background: linear-gradient(180deg, #e0f7fa 0%, #fff 100%);
        }
        .blob-bg {
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }
        #mobile-menu { display: none; }
        #mobile-menu.active { display: block; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @stack('styles')
</head>
<body class="bg-background-light font-display text-slate-900 overflow-x-hidden">

    @include('layouts.partials.home-navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.home-footer')

    @stack('scripts')
</body>
</html>
