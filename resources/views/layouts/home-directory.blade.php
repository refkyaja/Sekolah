<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Direktori Informasi - TK PGRI Harapan Bangsa 1')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/home-animations.css', 'resources/js/home-animations.js'])

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#308ce8",
                        "accent-blue": "#e0f2fe",
                        "accent-yellow": "#fef3c7",
                        "accent-purple": "#ede9fe",
                        "background-light": "#f6f7f8",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                    },
                    borderRadius: {
                        "DEFAULT": "1rem",
                        "lg": "1.5rem",
                        "xl": "2.5rem",
                        "2xl": "3rem",
                        "full": "9999px",
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Lexend', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen overflow-x-hidden bg-background-light font-display text-slate-900">
    <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div class="flex items-center gap-3">
                <a href="@yield('back-url', route('informasi'))"
                   class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-x-0.5 hover:text-primary">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-primary">@yield('directory-eyebrow', 'Direktori')</p>
                    <h1 class="text-xl font-extrabold text-slate-900 md:text-2xl">@yield('directory-title')</h1>
                </div>
            </div>

            @hasSection('directory-controls')
                <div class="w-full lg:w-auto">
                    @yield('directory-controls')
                </div>
            @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
