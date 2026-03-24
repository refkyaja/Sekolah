@extends('layouts.siswa')

@section('title', 'Unggah Dokumen - ' . config('app.name'))

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(0.25rem);
    }
</style>
@endpush

@section('content')
@php
    $readOnly = $readOnly ?? false;
@endphp
<!-- Header & Breadcrumbs -->
<header class="mb-6">
    <nav class="flex text-sm text-slate-500 dark:text-slate-400 mb-4 items-center gap-2">
        <a class="hover:text-primary transition-colors" href="{{ route('siswa.dashboard') }}">Beranda</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">Unggah Dokumen</span>
    </nav>
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-slate-50 tracking-tight">Unggah Dokumen</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Pastikan dokumen yang diunggah sesuai dengan format dan ukuran yang ditentukan.</p>
        </div>
        @if($setting && $setting->pendaftaran_selesai)
        <div class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-lg">
            <span class="material-symbols-outlined text-lg">info</span>
            <span class="text-sm font-medium">Batas akhir: {{ \Carbon\Carbon::parse($setting->pendaftaran_selesai)->translatedFormat('d F Y') }}</span>
        </div>
        @endif
    </div>
</header>

@if(($spmb->status_pendaftaran == 'Revisi Dokumen' || $spmb->status_pendaftaran == 'Menunggu Verifikasi') && $spmb->catatan_admin)
<!-- Admin Feedback Section -->
<section class="mb-8 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-xl flex gap-4">
    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
        <span class="material-symbols-outlined">feedback</span>
    </div>
    <div>
        <h4 class="font-bold text-amber-800 dark:text-amber-300">Catatan Admin</h4>
        <p class="text-amber-700 dark:text-amber-400 text-sm mt-1">{{ $spmb->catatan_admin }}</p>
    </div>
</section>
@endif

<!-- Document List Section -->
<section class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
        <h3 class="font-bold text-lg">Daftar Dokumen Wajib</h3>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">4 Dokumen Diperlukan</span>
    </div>
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
        @php
            $requiredDocs = [
                [
                    'id' => 'akte_kelahiran',
                    'title' => 'Akta Kelahiran',
                    'desc' => 'Format: JPG, PNG, atau PDF. Ukuran maks. 5MB.',
                    'icon' => 'child_care',
                    'verif_field' => 'verifikasi_akte'
                ],
                [
                    'id' => 'kartu_keluarga',
                    'title' => 'Kartu Keluarga',
                    'desc' => 'Scan dokumen asli. Format PDF disukai. Maks. 5MB.',
                    'icon' => 'family_restroom',
                    'verif_field' => 'verifikasi_kk'
                ],
                [
                    'id' => 'ktp_orang_tua',
                    'title' => 'KTP Orang Tua (Ayah/Ibu)',
                    'desc' => 'Format: JPG atau PNG. Ukuran maks. 5MB.',
                    'icon' => 'badge',
                    'verif_field' => 'verifikasi_ktp'
                ],
                [
                    'id' => 'bukti_pembayaran',
                    'title' => 'Bukti Pembayaran',
                    'desc' => 'Bukti transfer biaya pendaftaran. Format JPG, PNG, atau PDF. Maks. 5MB.',
                    'icon' => 'receipt_long',
                    'verif_field' => 'verifikasi_bukti_transfer'
                ]
            ];
        @endphp

        @foreach($requiredDocs as $doc)
            @php
                $existingDoc = $docs[$doc['id']] ?? null;
                $isVerified = $spmb->{$doc['verif_field']};
                $needsRevision = ($spmb->status_pendaftaran == 'Revisi Dokumen' && !$isVerified && $existingDoc);
                $isPending = (!$isVerified && $existingDoc && !$needsRevision);
            @endphp
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">{{ $doc['icon'] }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-slate-100">{{ $doc['title'] }}</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $doc['desc'] }}</p>
                        <div class="mt-2 flex items-center gap-2 flex-wrap">
                            @if($isVerified)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700">Verified</span>
                            @elseif($needsRevision)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">Perlu Revisi</span>
                            @elseif($isPending)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-700">Menunggu Verifikasi</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">Belum Diunggah</span>
                            @endif

                            @if($existingDoc)
                                <span class="text-xs text-slate-400 italic">{{ $existingDoc->nama_file }} ({{ $existingDoc->ukuran_formatted }})</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($existingDoc)
                        <a href="{{ $existingDoc->url }}" target="_blank" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg font-semibold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            Lihat
                        </a>
                    @endif

                    @if(!$readOnly && !$isVerified)
                        <form action="{{ route('siswa.dokumen.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                            @csrf
                            <input type="hidden" name="jenis_dokumen" value="{{ $doc['id'] }}">
                            <input type="file" name="file_dokumen" id="file_{{ $doc['id'] }}" class="hidden" onchange="this.form.submit()">
                            
                            <button type="button" onclick="document.getElementById('file_{{ $doc['id'] }}').click()"
                                class="px-6 py-2 {{ $existingDoc ? 'bg-amber-500 hover:bg-amber-600' : 'bg-primary hover:bg-primary/90' }} text-white rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">{{ $existingDoc ? 'sync' : 'upload' }}</span>
                                {{ $existingDoc ? 'Ubah' : 'Unggah' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Bottom Actions -->
<div class="mt-10 flex flex-col items-center gap-4">
    <p class="text-slate-500 dark:text-slate-400 text-sm text-center max-w-lg">
        Dengan menekan tombol di bawah, Anda menyatakan bahwa semua dokumen yang diunggah adalah benar dan asli.
    </p>
    
    @if(!$readOnly)
    <form action="{{ route('siswa.dokumen.submit') }}" method="POST" class="w-full md:w-auto">
        @csrf
        <button type="submit" class="w-full md:w-auto px-12 py-4 bg-primary text-white rounded-xl font-bold text-lg shadow-xl shadow-primary/30 hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3 group">
            Selesai & Kirim Dokumen
            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
        </button>
    </form>
    @else
    <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl flex items-center gap-4">
        <div class="size-12 bg-green-500/10 rounded-full flex items-center justify-center text-green-500">
            <span class="material-symbols-outlined">verified</span>
        </div>
        <div>
            <h4 class="font-bold text-slate-900 dark:text-white">Dokumen Telah Dikirim</h4>
            <p class="text-sm text-slate-500">Berkas Anda telah terkunci dan sedang dalam tahap verifikasi oleh admin.</p>
        </div>
    </div>
    @endif
</div>

<!-- Quick Status -->
<div class="fixed bottom-6 right-6 flex flex-col gap-2 pointer-events-none lg:pointer-events-auto">
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 rounded-xl shadow-2xl flex items-center gap-4">
        @php
            $countUploaded = $spmb->dokumen->whereIn('jenis_dokumen', ['akte_kelahiran', 'kartu_keluarga', 'ktp_orang_tua', 'bukti_pembayaran'])->count();
        @endphp
        <div class="w-2 h-2 rounded-full bg-primary {{ $countUploaded < 4 ? 'animate-pulse' : '' }}"></div>
        <p class="text-sm font-medium">Progress: {{ $countUploaded }}/4 Dokumen Terunggah</p>
    </div>
</div>
@endsection
