<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Test - Ngrok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Livewire Test untuk Ngrok</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Environment Info</h2>
            <div class="space-y-2">
                <p><strong>APP_URL:</strong> {{ config('app.url') }}</p>
                <p><strong>APP_ENV:</strong> {{ config('app.env') }}</p>
                <p><strong>APP_DEBUG:</strong> {{ config('app.debug') ? 'true' : 'false' }}</p>
                <p><strong>Current URL:</strong> {{ url()->current() }}</p>
                <p><strong>Ngrok URL:</strong> {{ request()->getHost() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Session Info</h2>
            <div class="space-y-2">
                <p><strong>Session Driver:</strong> {{ config('session.driver') }}</p>
                <p><strong>Session Lifetime:</strong> {{ config('session.lifetime') }} minutes</p>
                <p><strong>Session Secure:</strong> {{ config('session.secure') ? 'true' : 'false' }}</p>
                <p><strong>Session SameSite:</strong> {{ config('session.same_site') }}</p>
                <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
                <p><strong>Has Session:</strong> {{ session()->isStarted() ? 'true' : 'false' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Livewire Component Test</h2>
            @livewire('test-component')
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">CSRF Token Test</h2>
            <div class="space-y-2">
                <p><strong>CSRF Token Exists:</strong> {{ csrf_token() ? 'true' : 'false' }}</p>
                <p><strong>XSRF-TOKEN Cookie:</strong> {{ request()->cookie('XSRF-TOKEN') ? 'exists' : 'not found' }}</p>
                <p><strong>laravel_session Cookie:</strong> {{ request()->cookie('laravel_session') ? 'exists' : 'not found' }}</p>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
