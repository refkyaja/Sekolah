@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Rekap Absensi Guru</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Rekap per guru untuk bulan terpilih.</p>
        </div>
        <a href="{{ route('admin.absensi-guru.index') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl border border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all font-bold text-sm shadow-sm">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
            Kembali
        </a>
    </div>

    <form method="GET" class="p-6 sm:p-8 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row gap-3 sm:items-end">
        <div class="w-full sm:w-64">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bulan</label>
            <input type="month" name="bulan" value="{{ $bulan }}"
                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm" [color-scheme:light] dark:[color-scheme:dark]/>
        </div>
        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
            Tampilkan
        </button>
        <div class="relative group">
            <button type="button" class="px-6 py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition-all shadow-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">download</span>
                Export
                <span class="material-symbols-outlined text-lg">arrow_drop_down</span>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden z-10 hidden group-hover:block">
                <a href="{{ route('admin.absensi-guru.rekap.export', ['bulan' => $bulan, 'format' => 'pdf']) }}" class="w-full text-left px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="material-symbols-outlined text-red-500 text-lg">picture_as_pdf</span>
                    Export as PDF
                </a>
                <a href="{{ route('admin.absensi-guru.rekap.export', ['bulan' => $bulan, 'format' => 'excel']) }}" class="w-full text-left px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-500 text-lg">table_chart</span>
                    Export as Excel
                </a>
            </div>
        </div>
    </form>

    <div class="p-6 sm:p-8 overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Guru</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Hadir</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Sakit</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Izin</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Alpa</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                @foreach($rekap as $g)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $loop->iteration + ($rekap->currentPage()-1)*$rekap->perPage() }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $g->nama }}</span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">{{ $g->nip ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-green-700 dark:text-green-400">{{ (int) $g->hadir }}</td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-amber-700 dark:text-amber-400">{{ (int) $g->sakit }}</td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-blue-700 dark:text-blue-400">{{ (int) $g->izin }}</td>
                    <td class="px-4 py-3 text-center text-sm font-bold text-rose-700 dark:text-rose-400">{{ (int) $g->alpa }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pt-6">
            {{ $rekap->links() }}
        </div>
    </div>
</div>
@endsection

