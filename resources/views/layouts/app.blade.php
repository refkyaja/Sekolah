<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - TK Contoh</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Konten --}}
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

</body>
</html>