@extends('layouts.siswa')

@section('title', 'Hasil Seleksi PPDB')

@push('styles')
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
@endpush

@section('content')
<div class="p-4 lg:p-8 max-w-5xl mx-auto w-full">
        <div>
            <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white uppercase">Hasil Seleksi PPDB</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">Status pendaftaran dan hasil seleksi calon siswa.</p>
        </div>


    <!-- Status Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm mb-10 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            @php
                $statusColor = 'slate';
                $statusIcon = 'schedule';
                $statusPendaftaran = $spmb->status_pendaftaran ?? 'Menunggu Verifikasi';
                
                if($statusPendaftaran === 'Lulus') {
                    $statusColor = 'green';
                    $statusIcon = 'verified';
                } elseif($statusPendaftaran === 'Tidak Lulus') {
                    $statusColor = 'red';
                    $statusIcon = 'cancel';
                } elseif($statusPendaftaran === 'Menunggu Verifikasi' || $statusPendaftaran === 'Menunggu Pengumuman') {
                    $statusColor = 'amber';
                    $statusIcon = 'hourglass_empty';
                } elseif($statusPendaftaran === 'Revisi Dokumen') {
                    $statusColor = 'orange';
                    $statusIcon = 'history_edu';
                }
            @endphp
            
            <div class="w-24 h-24 rounded-3xl bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 flex items-center justify-center text-{{ $statusColor }}-600">
                <span class="material-symbols-outlined !text-5xl">{{ $statusIcon }}</span>
            </div>
            
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-700 dark:text-{{ $statusColor }}-400 text-xs font-bold uppercase tracking-widest mb-3">
                    Status: {{ $statusPendaftaran }}
                </div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2 uppercase">
                    @if($statusPendaftaran === 'Lulus')
                        Selamat! Anda Diterima
                    @elseif($statusPendaftaran === 'Tidak Lulus')
                        Mohon Maaf, Anda Belum Lulus
                    @elseif($statusPendaftaran === 'Menunggu Pengumuman')
                        Menunggu Pengumuman
                    @else
                        Data Sedang Diproses
                    @endif
                </h2>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                    @if($statusPendaftaran === 'Lulus')
                        Selamat bergabung di TK PGRI Harapan Bangsa 1. Anda telah dinyatakan lulus dalam proses seleksi tahun ajaran {{ $spmb->tahunAjaran->tahun_ajaran ?? '-' }}. Silakan lakukan daftar ulang sesuai jadwal yang ditentukan.
                    @elseif($statusPendaftaran === 'Tidak Lulus')
                        Kami menghargai minat Anda untuk bergabung. Namun, berdasarkan hasil seleksi yang dilakukan, saat ini kami belum dapat memproses pendaftaran Anda lebih lanjut. Tetap semangat!
                    @elseif($statusPendaftaran === 'Menunggu Verifikasi')
                        Pendaftaran Anda telah kami terima dengan baik. Saat ini tim panitia sedang melakukan verifikasi terhadap data dan dokumen yang Anda unggah. Mohon tunggu proses pemeriksaan.
                    @elseif($statusPendaftaran === 'Menunggu Pengumuman')
                        Proses verifikasi dokumen Anda telah selesai. Hasil seleksi akan segera diumumkan secara resmi melalui halaman ini. Mohon periksa kembali secara berkala.
                    @elseif($statusPendaftaran === 'Revisi Dokumen')
                        Terdapat beberapa dokumen yang membutuhkan perbaikan. Harap periksa email Anda atau hubungi admin untuk detail dokumen yang harus diunggah kembali.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Data Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-20">
        <div class="lg:col-span-2 space-y-8">
            <section class="bg-white dark:bg-slate-900 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <h3 class="font-bold text-lg mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Detail Pendaftaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nomor Pendaftaran</p>
                        <p class="font-bold text-slate-900 dark:text-white uppercase">#{{ str_pad($spmb->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_anak }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">NIK Anak</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_anak }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tahun Ajaran</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->tahunAjaran->tahun_ajaran ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jenis Daftar</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->jenis_daftar }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Daftar</p>
                        <p class="font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </section>

            @if($setting && $setting->keterangan_tambahan)
                <section class="bg-primary/5 p-8 rounded-2xl border border-primary/10">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined">campaign</span>
                        Pengumuman Panitia
                    </h3>
                    <div class="text-slate-600 dark:text-slate-400 leading-relaxed prose prose-slate max-w-none">
                        {!! nl2br(e($setting->keterangan_tambahan)) !!}
                    </div>
                </section>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <h4 class="font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">contact_support</span>
                    Bantuan Panitia
                </h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <div class="size-10 bg-green-500/10 text-green-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">call</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">WhatsApp</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200">0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <div class="size-10 bg-blue-500/10 text-blue-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Email</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-200">ppdb@sekolah.sch.id</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary to-indigo-600 p-6 rounded-2xl text-white shadow-lg overflow-hidden relative">
                <div class="absolute top-0 right-0 size-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-xl"></div>
                <h4 class="font-bold mb-2 relative z-10">Status Pendaftaran</h4>
                <p class="text-xs text-white/80 mb-6 relative z-10 leading-relaxed">Pantau terus halaman ini untuk mendapatkan informasi terbaru mengenai status pendaftaran Anda.</p>
                <div class="w-full flex items-center justify-center gap-2 py-3 bg-white/10 text-white rounded-xl font-bold text-sm relative z-10">
                    <span class="material-symbols-outlined text-sm">info</span>
                    {{ $statusPendaftaran }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
