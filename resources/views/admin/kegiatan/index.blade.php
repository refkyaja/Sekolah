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

@section('title', 'Kegiatan Sekolah')
@section('breadcrumb', 'Informasi Publik / Kegiatan Sekolah')

@section('content')
    <livewire:admin.kegiatan-index />

    <form id="delete-kegiatan-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    function confirmDeleteKegiatan(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
            const form = document.getElementById('delete-kegiatan-form');
            form.action = `{{ url($routePrefix . '/kegiatan') }}/${id}`;
            form.submit();
        }
    }
</script>
@endpush
