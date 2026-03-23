{{-- resources/views/admin/ppdb/partials/stats.blade.php --}}
@if(isset($statistik))
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500 dark:text-gray-400">Total</div>
        <div class="text-2xl font-bold">{{ $statistik['total'] ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500 dark:text-gray-400">Lulus</div>
        <div class="text-2xl font-bold text-green-600 dark:text-green-500">{{ $statistik['diterima'] ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500 dark:text-gray-400">Dokumen Verified</div>
        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-500">{{ $statistik['diproses'] ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500 dark:text-gray-400">Tidak Lulus</div>
        <div class="text-2xl font-bold text-red-600 dark:text-red-500">{{ $statistik['ditolak'] ?? 0 }}</div>
    </div>
</div>
@endif