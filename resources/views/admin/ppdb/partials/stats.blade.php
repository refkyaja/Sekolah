{{-- resources/views/admin/ppdb/partials/stats.blade.php --}}
@if(isset($statistik))
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500">Total</div>
        <div class="text-2xl font-bold">{{ $statistik['total'] ?? 0 }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500">Lulus</div>
        <div class="text-2xl font-bold text-green-600">{{ $statistik['diterima'] ?? 0 }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500">Dokumen Verified</div>
        <div class="text-2xl font-bold text-yellow-600">{{ $statistik['diproses'] ?? 0 }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-sm text-gray-500">Tidak Lulus</div>
        <div class="text-2xl font-bold text-red-600">{{ $statistik['ditolak'] ?? 0 }}</div>
    </div>
</div>
@endif