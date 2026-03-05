<!DOCTYPE html>
<html lang="id" class="light" x-data>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Playful Kids School | Learning with Joy')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&family=Nunito:wght@400;600;700;800&family=Material+Icons&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS with custom config -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
            extend: {
                colors: {
                primary: "#114B5F", // Dark teal from the "Enroll Now" button
                "background-light": "#FFFFFF",
                "background-dark": "#0F172A",
                accent: {
                    yellow: "#FBED8B",
                    pink: "#FBC3D9",
                    purple: "#D3C4F3",
                    blue: "#CCF0F5"
                }
                },
                fontFamily: {
                display: ["Fredoka", "sans-serif"],
                body: ["Nunito", "sans-serif"],
                },
                borderRadius: {
                DEFAULT: "1rem",
                'xl': '1.5rem',
                '2xl': '2rem',
                },
            },
            },
        };
    </script>
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Fredoka', sans-serif; }
        .wavy-bg {
            border-bottom-left-radius: 50% 10%;
            border-bottom-right-radius: 50% 10%;
        }
        .bubble-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 transition-colors duration-300">
    
    @include('layouts.front-navbar')
    
    <!-- Content -->
    <main>
        @yield('content')
    </main>
    
    @include('layouts.front-footer')
    
    @stack('scripts')
</body>
</html>