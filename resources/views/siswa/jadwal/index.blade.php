@extends('layouts.student')

@section('title', 'Jadwal Pelajaran')
@section('header_title', 'Jadwal Mingguan')

@section('content')
<!-- Page Title & Filters -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-2">Jadwal Pelajaran</h1>
        <div class="flex items-center gap-4 text-slate-500">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                <p class="text-sm font-medium">{{ $ta->tahun_ajaran ?? '-' }} ({{ $ta->semester ?? '-' }})</p>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <p class="text-sm">Gedung Utama, TK Harapan Bangsa 2</p>
            </div>
        </div>
    </div>
    <div class="flex gap-3">
        <button class="size-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-all">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <a href="{{ route('siswa.jadwal.download-pdf') }}" class="px-4 py-2 flex items-center gap-2 rounded-xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-transform active:scale-95">
            <span class="material-symbols-outlined text-[20px]">download</span>
            <span>Download PDF</span>
        </a>
    </div>
</div>

<!-- Schedule Table Tabs -->
<div class="flex border-b border-slate-200 dark:border-slate-800 mb-6 gap-8">
    <button onclick="switchTab('A')" class="tab-btn px-4 py-2 text-sm {{ $studentKelompok == 'A' ? 'font-bold text-primary border-b-2 border-primary' : 'font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }} transition-colors" id="tab-a">
        Kelompok A
    </button>
    <button onclick="switchTab('B')" class="tab-btn px-4 py-2 text-sm {{ $studentKelompok == 'B' ? 'font-bold text-primary border-b-2 border-primary' : 'font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200' }} transition-colors" id="tab-b">
        Kelompok B
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
