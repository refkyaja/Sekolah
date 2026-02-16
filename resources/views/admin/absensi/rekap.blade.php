<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard Admin</h1>
            <div class="flex items-center space-x-4">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white min-h-screen shadow-lg">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-blue-600">Menu Admin</h2>
                <ul class="mt-6 space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-4 py-2 rounded hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.siswa.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-gray-100">
                            <i class="fas fa-users mr-2"></i>Data Siswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.absensi.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-gray-100">
                            <i class="fas fa-clipboard-check mr-2"></i>Absensi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.absensi.rekap') }}" 
                           class="block px-4 py-2 rounded bg-blue-100 text-blue-700">
                            <i class="fas fa-chart-bar mr-2"></i>Rekap Absensi
                        </a>
                    </li>
                    <!-- Menu lainnya -->
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Rekap Absensi Siswa</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Total Absensi</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($statistik['total_absensi'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Hadir</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($statistik['hadir'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Izin</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ number_format($statistik['izin'] ?? 0) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Tidak Hadir</p>
                        <p class="text-3xl font-bold text-red-600">{{ number_format($statistik['tidak_hadir'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Data Rekap Absensi</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Siswa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kelompok
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guru Pengajar
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($rekap_data as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->siswa->nama ?? 'Tidak ditemukan' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $item->siswa->kelompok == 'A' ? 'bg-blue-100 text-blue-800' : 
                                           ($item->siswa->kelompok == 'B' ? 'bg-green-100 text-green-800' : 
                                           'bg-gray-100 text-gray-800') }}">
                                        {{ $item->siswa->kelompok ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'hadir')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Hadir
                                        </span>
                                    @elseif($item->status == 'izin')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Izin
                                        </span>
                                    @elseif($item->status == 'sakit')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                            Sakit
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Tidak Hadir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->guru->nama ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-clipboard-list text-3xl mb-2 text-gray-400"></i>
                                    <p>Belum ada data rekap absensi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($rekap_data->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $rekap_data->links() }}
                </div>
                @endif
            </div>
            
            <!-- Export Button -->
            <div class="mt-6">
                <a href="{{ route('admin.absensi.export') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-file-excel mr-2"></i>
                    Export ke Excel
                </a>
            </div>
        </div>
    </div>
</body>
</html>