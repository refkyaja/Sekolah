@extends('layouts.admin')

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    #sidebar-toggle:checked ~ aside {
        width: 80px;
    }
    #sidebar-toggle:checked ~ aside .logo-text,
    #sidebar-toggle:checked ~ aside .nav-text,
    #sidebar-toggle:checked ~ aside .nav-section-title,
    #sidebar-toggle:checked ~ aside .system-status {
        display: none;
    }
    #sidebar-toggle:checked ~ aside .nav-item {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }
    #sidebar-toggle:checked ~ aside .nav-section-divider {
        display: block;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 1rem 0.5rem;
    }
    .nav-section-divider {
        display: none;
    }
    aside {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .data-table th {
        white-space: nowrap;
    }
    .data-table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="#">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Pendaftaran</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pendaftaran PPDB</h1>
        <p class="text-sm text-slate-500 mt-1">Manajemen pendaftaran calon siswa baru dengan fitur filter dan aksi massal.</p>
    </div>
    <a href="{{ route('admin.ppdb.create') }}" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
        <span class="material-symbols-outlined text-lg">add</span>
        Tambah Data PPDB
    </a>
</div>

<livewire:admin.ppdb-index />

<div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm">
    <div class="flex items-center gap-2 mb-8">
        <span class="material-symbols-outlined text-primary">info</span>
        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Status Information</h3>
    </div>
    <div class="space-y-6 max-w-4xl">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-orange-100 text-orange-700 uppercase tracking-widest min-w-[130px]">Menunggu Verifikasi</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Menunggu Verifikasi</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Pendaftaran baru masuk dan perlu diperiksa.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-yellow-100 text-yellow-700 uppercase tracking-widest min-w-[130px]">Revisi Dokumen</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Revisi Dokumen</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Menunggu perbaikan berkas dari orang tua.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-blue-100 text-blue-700 uppercase tracking-widest min-w-[130px]">Dokumen Verified</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Dokumen Verified</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Berkas lengkap dan valid.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-green-100 text-green-700 uppercase tracking-widest min-w-[130px]">Lulus</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Lulus</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Calon siswa diterima.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-red-100 text-red-700 uppercase tracking-widest min-w-[130px]">Tidak Lulus</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Tidak Lulus</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Calon siswa tidak diterima.</p>
            </div>
        </div>
    </div>
</div>
@endsection
