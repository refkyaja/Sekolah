@extends('layouts.student')

@section('title', 'Jadwal Pelajaran')
@section('header_title', 'Jadwal Mingguan')

@section('content')
<!-- Page Title & Filters -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
    <div>
        <span class="text-[9px] font-extrabold uppercase tracking-[.3em] text-brand-primary mb-2 block">Akademik</span>
        <h1 class="text-4xl font-extrabold text-brand-dark uppercase tracking-tighter leading-none mb-4">Jadwal Pelajaran</h1>
        <div class="flex items-center gap-6 text-stone-300">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base">calendar_today</span>
                <p class="text-[10px] font-extrabold uppercase tracking-widest">{{ $ta->tahun_ajaran ?? '-' }} ({{ $ta->semester ?? '-' }})</p>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <p class="text-sm">Gedung Utama, TK Harapan Bangsa 2</p>
            </div>
        </div>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('siswa.jadwal.download-pdf') }}" class="px-8 py-4 flex items-center gap-3 rounded-[2rem] bg-brand-dark text-white font-extrabold text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-brand-dark/10 hover:bg-brand-primary transition-all active:scale-95">
            <span class="material-symbols-outlined text-xl">download</span>
            <span>Download PDF</span>
        </a>
    </div>
</div>

<!-- Schedule Table Tabs -->
<div class="flex border-b border-stone-100 mb-10 gap-12">
    <button onclick="switchTab('A')" class="tab-btn px-4 py-4 text-[10px] uppercase font-extrabold tracking-[0.2em] transition-all relative {{ $studentKelompok == 'A' ? 'text-brand-primary' : 'text-stone-300 hover:text-stone-500' }}" id="tab-a">
        Kelompok A
        @if($studentKelompok == 'A')
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-brand-primary rounded-full transition-all" id="indicator-a"></div>
        @else
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-brand-primary rounded-full opacity-0 transition-all" id="indicator-a"></div>
        @endif
    </button>
    <button onclick="switchTab('B')" class="tab-btn px-4 py-4 text-[10px] uppercase font-extrabold tracking-[0.2em] transition-all relative {{ $studentKelompok == 'B' ? 'text-brand-primary' : 'text-stone-300 hover:text-stone-500' }}" id="tab-b">
        Kelompok B
        @if($studentKelompok == 'B')
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-brand-primary rounded-full transition-all" id="indicator-b"></div>
        @else
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-brand-primary rounded-full opacity-0 transition-all" id="indicator-b"></div>
        @endif
    </button>
</div>

<!-- Content Kelompok A -->
<div id="content-a" class="tab-content {{ $studentKelompok == 'B' ? 'hidden' : '' }}">
    @include('siswa.jadwal._table', ['jadwal' => $jadwalA, 'slots' => $slots, 'hariList' => $hariList])
</div>

<!-- Content Kelompok B -->
<div id="content-b" class="tab-content {{ $studentKelompok == 'A' ? 'hidden' : '' }}">
    @include('siswa.jadwal._table', ['jadwal' => $jadwalB, 'slots' => $slots, 'hariList' => $hariList])
</div>

<!-- Footer Summary -->
<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-blue-50 dark:bg-blue-900/10 p-4 rounded-xl border border-blue-100 dark:border-blue-800/30 flex items-center gap-3">
        <div class="size-8 rounded-lg bg-blue-400 flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-sm">school</span>
        </div>
        <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase">Akademik</p>
            <p class="text-sm font-bold">Variasi Sesi / Minggu</p>
        </div>
    </div>
    <div class="bg-amber-50 dark:bg-amber-900/10 p-4 rounded-xl border border-amber-100 dark:border-amber-800/30 flex items-center gap-3">
        <div class="size-8 rounded-lg bg-amber-400 flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-sm">palette</span>
        </div>
        <div>
            <p class="text-[10px] font-bold text-slate-500 uppercase">Kesenian</p>
            <p class="text-sm font-bold">Variasi Sesi / Minggu</p>
        </div>
    </div>
</div>

<script>
    function switchTab(kelompok) {
        // Toggle Buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-primary', 'font-bold', 'border-primary', 'border-b-2');
            btn.classList.add('text-slate-500', 'font-medium');
        });
        
        const activeBtn = document.getElementById('tab-' + kelompok.toLowerCase());
        activeBtn.classList.remove('text-slate-500', 'font-medium');
        activeBtn.classList.add('text-primary', 'font-bold', 'border-primary', 'border-b-2');

        // Toggle Content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById('content-' + kelompok.toLowerCase()).classList.remove('hidden');
    }
</script>
@endsection
