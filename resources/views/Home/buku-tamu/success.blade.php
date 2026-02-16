<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center">
            <!-- Success Icon -->
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            
            <!-- Success Message -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Berhasil! 🎉</h2>
            <p class="text-gray-600 mb-6">
                {{ session('success', 'Data berhasil disimpan!') }}
            </p>
            
            <!-- Testing Info -->
            <div class="mb-6 p-3 bg-yellow-50 rounded-lg">
                <p class="text-sm text-yellow-700">
                    <strong>💻 TESTING MODE:</strong> Data tersimpan di database local.
                </p>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('buku-tamu.index') }}" 
                   class="block w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    ➕ Tambah Data Lagi
                </a>
                <a href="/admin/bukutamu" 
                   class="block w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    👨‍💼 Lihat di Admin
                </a>
                <a href="/" 
                   class="block w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    🏠 Kembali ke Home
                </a>
            </div>
            
            <!-- Quick Debug Info -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-xs text-gray-500">
                <p>URL: {{ url()->current() }}</p>
                <p>Session: {{ session('success') ? '✅' : '❌' }}</p>
            </div>
        </div>
    </div>
    
</body>
</html>