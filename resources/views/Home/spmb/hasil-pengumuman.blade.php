@extends('layouts.ppdb')

@section('title', 'Hasil Seleksi - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6 flex items-center justify-center">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200 overflow-hidden border border-stone-50">
            <!-- Header -->
            <div class="{{ $spmb->status_pendaftaran === 'Lulus' ? 'bg-brand-primary' : 'bg-brand-dark' }} p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 -mr-32 -mt-32 rounded-full"></div>
                <div class="relative z-10 text-center sm:text-left">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-80 mb-4 block">Hasil Seleksi PPDB</span>
                    <h2 class="text-4xl font-extrabold tracking-tight uppercase">STATUS<br>PENDAFTARAN</h2>
                </div>
            </div>

            <div class="p-12">
                <!-- Applicant Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 mb-16 pb-12 border-b border-stone-100">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-2 block">Nama Calon Siswa</span>
                        <div class="text-2xl font-extrabold text-brand-dark uppercase tracking-tighter">{{ $spmb->nama_anak }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-stone-400 mb-2 block">Nomor Pendaftaran</span>
                        <div class="text-2xl font-extrabold text-brand-dark tracking-tighter">{{ $spmb->no_pendaftaran }}</div>
                    </div>
                </div>

                <!-- Status Result -->
                <div class="text-center py-12 px-8 rounded-[2.5rem] {{ $spmb->status_pendaftaran === 'Lulus' ? 'bg-brand-soft border-2 border-brand-primary/20' : 'bg-stone-50 border border-stone-100' }} mb-16">
                    @if($spmb->status_pendaftaran === 'Lulus')
                        <div class="w-20 h-20 bg-brand-primary text-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-brand-primary/20 rotate-3">
                            <span class="material-symbols-outlined text-4xl">celebration</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-brand-dark uppercase tracking-tight mb-4">SELAMAT! ANDA DINYATAKAN LULUS</h3>
                        <p class="text-stone-500 font-medium leading-relaxed max-w-md mx-auto">
                            Selamat bergabung dengan keluarga besar Harapan Bangsa 1. Silakan lakukan pendaftaran ulang sesuai jadwal yang ditentukan.
                        </p>
                    @elseif($spmb->status_pendaftaran === 'Tidak Lulus')
                        <div class="w-20 h-20 bg-stone-200 text-stone-400 rounded-3xl flex items-center justify-center mx-auto mb-8">
                            <span class="material-symbols-outlined text-4xl">sentiment_dissatisfied</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-stone-400 uppercase tracking-tight mb-4">MOHON MAAF</h3>
                        <p class="text-stone-500 font-medium leading-relaxed max-w-md mx-auto">
                            Anda belum berhasil lulus seleksi pada periode ini. Teruslah semangat dan jangan berkecil hati.
                        </p>
                    @else
                        <div class="w-20 h-20 bg-stone-100 text-stone-300 rounded-3xl flex items-center justify-center mx-auto mb-8">
                            <span class="material-symbols-outlined text-4xl">hourglass_top</span>
                        </div>
                        <h3 class="text-4xl font-extrabold text-brand-dark uppercase tracking-tight mb-4">DALAM PROSES</h3>
                        <p class="text-stone-500 font-medium leading-relaxed max-w-md mx-auto">
                            Status pendaftaran Anda saat ini masih dalam tahap peninjauan oleh tim seleksi.
                        </p>
                    @endif
                </div>

                <!-- Next Steps / Info -->
                @if($spmb->status_pendaftaran === 'Lulus')
                    <div class="bg-white rounded-3xl p-10 border border-stone-100 shadow-sm mb-12">
                        <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-primary text-lg">info</span>
                            Langkah Selanjutnya
                        </h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-brand-soft text-brand-primary flex items-center justify-center text-[10px] font-bold flex-shrink-0">1</div>
                                <p class="text-[11px] font-bold text-stone-500 uppercase tracking-tight">Unduh surat keterangan kelulusan melalui link di bawah.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-brand-soft text-brand-primary flex items-center justify-center text-[10px] font-bold flex-shrink-0">2</div>
                                <p class="text-[11px] font-bold text-stone-500 uppercase tracking-tight">Siapkan dokumen asli untuk verifikasi fisik di sekolah.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-brand-soft text-brand-primary flex items-center justify-center text-[10px] font-bold flex-shrink-0">3</div>
                                <p class="text-[11px] font-bold text-stone-500 uppercase tracking-tight">Lakukan pembayaran biaya masuk sebelum 15 Juli 2026.</p>
                            </li>
                        </ul>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center pt-8">
                    @if($spmb->status_pendaftaran === 'Lulus')
                        <button class="bg-brand-primary text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-dark shadow-2xl shadow-brand-primary/20">
                            Unduh Surat Keterangan
                        </button>
                    @endif
                    
                    <a href="{{ route('spmb.index') }}" 
                       class="border-2 border-stone-200 text-brand-dark font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-white hover:border-brand-primary text-center">
                        Tutup Halaman
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center">
            <p class="text-[10px] font-bold text-stone-300 uppercase tracking-[0.25em]">Harapan Bangsa 1 — Timeless Education</p>
        </div>
    </div>
</div>
@endsection
