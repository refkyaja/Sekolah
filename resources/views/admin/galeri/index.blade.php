{{-- resources/views/admin/galeri/index.blade.php --}}
@php
    $role = auth()->user()->role;
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
@endphp

@extends($layout)
@section('title', 'Galeri Sekolah')

@section('content')
<livewire:admin.galeri-index />

{{-- Hidden Delete Form --}}
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus galeri ini? Semua gambar akan ikut terhapus.')) {
        const form = document.getElementById('delete-form');
        form.action = `{{ url($routePrefix . '/galeri') }}/${id}`;
        form.submit();
    }
}
</script>
@endpush
@endsection
