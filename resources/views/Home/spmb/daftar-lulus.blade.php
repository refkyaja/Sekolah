@extends('layouts.ppdb')

@section('title', 'Daftar Kelulusan - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200 overflow-hidden border border-stone-50">
            <!-- Header -->
            <div class="bg-brand-dark p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/10 -mr-32 -mt-32 rounded-full"></div>
                <div class="relative z-10">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4 block">Hasil Seleksi Resmi</span>
                    <h2 class="text-4xl font-extrabold tracking-tight uppercase">DAFTAR PESERTA<br>YANG DINYATAKAN LULUS</h2>
                    <p class="text-stone-400 text-[10px] font-bold uppercase tracking-widest mt-4">Tahun Ajaran {{ $setting->tahun_ajaran ?? '2026/2027' }}</p>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-12">
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <div class="bg-stone-50 rounded-[2rem] p-8 border border-stone-100">
                        <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mb-2 block">Total Lulus</span>
                        <div class="text-3xl font-extrabold text-brand-dark tracking-tighter">{{ $pesertaLulus->count() }} SISWA</div>
                    </div>
                    <div class="bg-brand-soft rounded-[2rem] p-8 border border-brand-primary/10">
                        <span class="text-[9px] font-bold text-brand-primary uppercase tracking-widest mb-2 block">Status Keputusan</span>
                        <div class="text-3xl font-extrabold text-brand-dark tracking-tighter">FINAL</div>
                    </div>
                    <div class="bg-stone-50 rounded-[2rem] p-8 border border-stone-100">
                        <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mb-2 block">Update Terakhir</span>
                        <div class="text-3xl font-extrabold text-brand-dark tracking-tighter uppercase">{{ now()->translatedFormat('d M Y') }}</div>
                    </div>
                </div>
                
                <!-- Participant List -->
                <div class="mb-16">
                    @if($pesertaLulus->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-b border-stone-100">
                                        <th class="px-6 py-6 text-left text-[10px] font-extrabold text-stone-400 uppercase tracking-[0.2em]">No</th>
                                        <th class="px-6 py-6 text-left text-[10px] font-extrabold text-stone-400 uppercase tracking-[0.2em]">No. Pendaftaran</th>
                                        <th class="px-6 py-6 text-left text-[10px] font-extrabold text-stone-400 uppercase tracking-[0.2em]">Nama Calon Siswa</th>
                                        <th class="px-6 py-6 text-left text-[10px] font-extrabold text-stone-400 uppercase tracking-[0.2em]">Jalur</th>
                                        <th class="px-6 py-6 text-right text-[10px] font-extrabold text-stone-400 uppercase tracking-[0.2em]">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-50">
                                    @foreach($pesertaLulus as $index => $peserta)
                                    <tr class="group hover:bg-stone-50/50 transition-colors">
                                        <td class="px-6 py-6 text-[11px] font-bold text-stone-400">{{ $index + 1 }}</td>
                                        <td class="px-6 py-6 text-[11px] font-extrabold text-brand-dark tracking-tight">{{ $peserta->no_pendaftaran }}</td>
                                        <td class="px-6 py-6 text-[11px] font-bold text-stone-600 uppercase">{{ $peserta->nama_calon_siswa }}</td>
                                        <td class="px-6 py-6">
                                            <span class="text-[9px] font-extrabold uppercase tracking-widest text-stone-400 group-hover:text-brand-primary transition-colors">{{ $peserta->jalur_pendaftaran }}</span>
                                        </td>
                                        <td class="px-6 py-6 text-right">
                                            <span class="inline-flex items-center gap-2 text-[9px] font-extrabold uppercase tracking-widest text-brand-primary">
                                                <span class="w-1.5 h-1.5 rounded-full bg-brand-primary animate-pulse"></span>
                                                Lulus
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($pesertaLulus->hasPages())
                        <div class="mt-12 pt-12 border-t border-stone-100">
                            {{ $pesertaLulus->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-24">
                            <span class="material-symbols-outlined text-stone-200 text-6xl mb-6 block">group_off</span>
                            <h4 class="text-[10px] font-extrabold uppercase tracking-[0.3em] text-stone-400">Belum Ada Pengumuman</h4>
                        </div>
                    @endif
                </div>
                
                <!-- Important Information -->
                <div class="bg-stone-50 rounded-[2.5rem] p-12 border border-stone-100 flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="material-symbols-outlined text-brand-primary">priority_high</span>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-2">Pemberitahuan Penting</h4>
                        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight leading-relaxed">
                            Bagi orang tua peserta yang dinyatakan lulus, diimbau untuk segera melakukan pendaftaran ulang di kantor sekretariat Harapan Bangsa 1 pada jam operasional kerja. Keputusan panitia adalah mutlak dan tidak dapat diganggu gugat.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                        <button onclick="window.print()" class="bg-brand-dark text-white font-extrabold py-5 px-8 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-xl">
                            Cetak Daftar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 text-center">
            <a href="{{ route('spmb.index') }}" 
               class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-brand-primary transition-colors">
                <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                Kembali ke Halaman PPDB
            </a>
            <p class="mt-12 text-[10px] font-bold text-stone-300 uppercase tracking-[0.25em]">Harapan Bangsa 1 — Timeless Education</p>
        </div>
    </div>
</div>

<style>
@media print {
    .bg-brand-soft, .bg-stone-50, .bg-brand-primary\/10 {
        background-color: white !important;
    }
    .shadow-2xl, .shadow-xl {
        box-shadow: none !important;
    }
    button, .material-symbols-outlined, a {
        display: none !important;
    }
    .bg-brand-dark {
        background-color: #1c1917 !important;
        color: white !important;
    }
    .max-w-6xl {
        max-width: 100% !important;
    }
    .py-20 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
}
</style>
@endsection