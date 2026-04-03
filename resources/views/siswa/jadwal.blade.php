@extends('layouts.siswa')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Jadwal Pelajaran @if($siswa->status_siswa === 'lulus') <span class="text-[10px] uppercase tracking-widest font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded ml-2 align-middle border border-slate-200 dark:border-slate-700">(ARSIP)</span> @endif</h1>
        <p class="text-slate-500 dark:text-slate-400">
            Tahun Ajaran: {{ $ta->tahun_ajaran ?? '-' }} | Semester: {{ $ta->semester ?? '-' }}
        </p>
    </div>

    <!-- Jadwal Grid -->
    <div class="space-y-8">
        @foreach($hariList as $hari)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h2 class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">calendar_today</span>
                        {{ $hari }}
                    </h2>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-white dark:bg-slate-700 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-600">
                        {{ count($jadwal[$hari] ?? []) }} Kegiatan
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 dark:bg-slate-800/30">
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 min-w-[120px]">Jam</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Mata Pelajaran / Kegiatan</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Guru / Pengajar</th>
                                <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @php $items = $jadwal[$hari] ?? []; @endphp
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-300">
                                            <span class="material-symbols-outlined text-xs text-slate-400">schedule</span>
                                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->mata_pelajaran }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase tracking-wider font-medium">{{ $item->kategori ?? 'Kegiatan Belajar' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                            <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-bold text-primary">
                                                {{ substr($item->guru ?? 'G', 0, 1) }}
                                            </div>
                                            {{ $item->guru ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                            <span class="material-symbols-outlined text-xs text-slate-400">location_on</span>
                                            {{ $item->lokasi ?? 'Ruang Kelompok' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500 text-sm italic">
                                        Tidak ada jadwal kegiatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
