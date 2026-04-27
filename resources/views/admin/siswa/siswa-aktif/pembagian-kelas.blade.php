@extends('layouts.admin')

@section('content')
<div
    x-data="pembagianKelas()"
    x-init="init()"
    class="space-y-6"
>
    @php
        $rolePrefix = auth()->check() ? (auth()->user()->role == 'admin' ? 'admin' : (auth()->user()->role == 'operator' ? 'operator' : 'kepala-sekolah')) : 'admin';
    @endphp
    
    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route($rolePrefix . '.siswa.siswa-aktif.index') }}"
                   class="text-slate-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </a>
                <h1 class="text-xl font-black text-slate-800 dark:text-white">Pembagian Kelompok</h1>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 ml-8">
                Total siswa aktif: <strong>{{ $totalSiswa }}</strong> siswa
            </p>
        </div>

        {{-- Tombol Bagi Otomatis --}}
        <form action="{{ route($rolePrefix . '.siswa.siswa-aktif.pembagian-kelas.auto') }}" method="POST">
            @csrf
            <button type="submit"
                onclick="return confirm('Bagi otomatis akan mengganti susunan saat ini. Lanjutkan?')"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-sm">
                <span class="material-symbols-outlined text-base">auto_awesome</span>
                Bagi Otomatis (Berdasarkan Umur)
            </button>
        </form>
    </div>

    {{-- ===== ALERTS ===== --}}
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base">check_circle</span>{{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base">info</span>{{ session('info') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-base">error</span>{{ session('error') }}
        </div>
    @endif

    {{-- ===== CAPACITY WARNING ===== --}}
    <div x-show="hasCapacityError()" x-transition
        class="bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 rounded-xl px-4 py-3 flex items-center gap-2 text-sm font-semibold">
        <span class="material-symbols-outlined text-base">warning</span>
        <span x-text="capacityWarningText()"></span>
    </div>
    <div x-show="hasSoftWarning() && !hasCapacityError()" x-transition
        class="bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 text-amber-700 dark:text-amber-300 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
        <span class="material-symbols-outlined text-base">warning</span>
        <span x-text="softWarningText()"></span>
    </div>

    {{-- ===== KELOMPOK BELUM ADA ===== --}}
    <div x-show="kelasBelum.length > 0" class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800 rounded-2xl shadow-sm p-5 mb-6" x-transition>
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-amber-500 text-3xl">person_off</span>
            <div>
                <h2 class="text-amber-800 dark:text-amber-400 font-black text-lg">Siswa Belum Memiliki Kelompok</h2>
                <p class="text-amber-700/70 dark:text-amber-500/70 text-sm">Ada <span class="font-bold" x-text="kelasBelum.length"></span> siswa yang belum dialokasikan kelompok. Silakan pindahkan ke Kelompok A atau B.</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 max-h-[400px] overflow-y-auto pr-2 pb-2">
            <template x-for="(siswa, index) in kelasBelum" :key="siswa.id">
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-3 flex flex-col gap-3 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-slate-200 dark:border-slate-600" x-text="initials(siswa.nama_lengkap)"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-slate-800 dark:text-white truncate" x-text="siswa.nama_lengkap"></p>
                                <template x-if="siswa.spmb_id">
                                    <span class="px-1.5 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[9px] font-black uppercase tracking-wider leading-none">Baru</span>
                                </template>
                            </div>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">
                                <span x-text="formatTanggal(siswa.tanggal_lahir)"></span> &bull; <span x-text="hitungUsia(siswa.tanggal_lahir)"></span>
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2 w-full mt-auto pt-2 border-t border-slate-100 dark:border-slate-700/50">
                        <button type="button" @click="dariBelumKeA(index)" :disabled="kelasA.length >= 27" class="flex-1 py-1.5 rounded-lg text-xs font-bold transition-all bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 disabled:opacity-40 border border-blue-100 dark:border-blue-800 border-dashed flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">add_circle</span> Ke A
                        </button>
                        <button type="button" @click="dariBelumKeB(index)" :disabled="kelasB.length >= 27" class="flex-1 py-1.5 rounded-lg text-xs font-bold transition-all bg-purple-50 text-purple-600 hover:bg-purple-100 hover:text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 dark:hover:bg-purple-900/50 disabled:opacity-40 border border-purple-100 dark:border-purple-800 border-dashed flex items-center justify-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">add_circle</span> Ke B
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- ===== 2-COLUMN LAYOUT ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ===== KELOMPOK A ===== --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            {{-- Header A --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-base">groups</span>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-base">Kelompok A</h2>
                        <p class="text-blue-100 text-[11px]">Siswa Termuda</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-black text-white" x-text="kelasA.length"></span>
                    <p class="text-blue-100 text-[11px]">siswa</p>
                </div>
            </div>

            {{-- Capacity bar A --}}
            <div class="px-5 py-2 bg-blue-50 dark:bg-blue-900/10 border-b border-blue-100 dark:border-blue-900/30">
                <div class="flex items-center justify-between text-[11px] mb-1">
                    <span class="text-slate-500 dark:text-slate-400">Kapasitas</span>
                    <span :class="kelasA.length > 27 ? 'text-red-600 font-bold' : kelasA.length > 25 ? 'text-amber-600 font-bold' : 'text-slate-500 dark:text-slate-400'"
                          x-text="kelasA.length + ' / 27'"></span>
                </div>
                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full transition-all duration-300"
                         :class="kelasA.length > 27 ? 'bg-red-500' : kelasA.length > 25 ? 'bg-amber-500' : 'bg-blue-500'"
                         :style="'width:' + Math.min((kelasA.length/27)*100, 100) + '%'"></div>
                </div>
            </div>

            {{-- List Kelompok A --}}
            <div class="divide-y divide-slate-50 dark:divide-slate-700/50 max-h-[520px] overflow-y-auto">
                <template x-for="(siswa, index) in kelasA" :key="siswa.id">
                    <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors group">
                        {{-- Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-[11px] flex-shrink-0"
                             x-text="initials(siswa.nama_lengkap)"></div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-slate-800 dark:text-white truncate" x-text="siswa.nama_lengkap"></p>
                                <template x-if="siswa.spmb_id">
                                    <span class="px-1.5 py-0.5 rounded-md bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 text-[9px] font-black uppercase tracking-wider leading-none">Baru</span>
                                </template>
                            </div>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">
                                <span x-text="formatTanggal(siswa.tanggal_lahir)"></span>
                                &bull; <span x-text="hitungUsia(siswa.tanggal_lahir)"></span>
                            </p>
                        </div>

                        <div class="flex items-center gap-1">
                            <button type="button"
                                    @click="dariAKeBelum(index)"
                                    class="flex-shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-md text-[10px] font-bold transition-all
                                           bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 hover:bg-slate-200 hover:text-slate-700 dark:hover:bg-slate-600 dark:hover:text-slate-200"
                                    title="Keluarkan dari kelompok">
                                <span class="material-symbols-outlined text-[14px]">person_off</span>
                            </button>
                            <button type="button"
                                    @click="pindahKeB(index)"
                                    :disabled="kelasB.length >= 27"
                                    class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold transition-all
                                           bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-100
                                           disabled:opacity-40 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                ke B
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="kelasA.length === 0">
                    <div class="py-10 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600">inbox</span>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">Tidak ada siswa di Kelompok A</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- ===== KELOMPOK B ===== --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            {{-- Header B --}}
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-base">groups</span>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-base">Kelompok B</h2>
                        <p class="text-purple-100 text-[11px]">Siswa Tertua</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-black text-white" x-text="kelasB.length"></span>
                    <p class="text-purple-100 text-[11px]">siswa</p>
                </div>
            </div>

            {{-- Capacity bar B --}}
            <div class="px-5 py-2 bg-purple-50 dark:bg-purple-900/10 border-b border-purple-100 dark:border-purple-900/30">
                <div class="flex items-center justify-between text-[11px] mb-1">
                    <span class="text-slate-500 dark:text-slate-400">Kapasitas</span>
                    <span :class="kelasB.length > 27 ? 'text-red-600 font-bold' : kelasB.length > 25 ? 'text-amber-600 font-bold' : 'text-slate-500 dark:text-slate-400'"
                          x-text="kelasB.length + ' / 27'"></span>
                </div>
                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full transition-all duration-300"
                         :class="kelasB.length > 27 ? 'bg-red-500' : kelasB.length > 25 ? 'bg-amber-500' : 'bg-purple-500'"
                         :style="'width:' + Math.min((kelasB.length/27)*100, 100) + '%'"></div>
                </div>
            </div>

            {{-- List Kelompok B --}}
            <div class="divide-y divide-slate-50 dark:divide-slate-700/50 max-h-[520px] overflow-y-auto">
                <template x-for="(siswa, index) in kelasB" :key="siswa.id">
                    <div class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors group">
                        {{-- Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-[11px] flex-shrink-0"
                             x-text="initials(siswa.nama_lengkap)"></div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-slate-800 dark:text-white truncate" x-text="siswa.nama_lengkap"></p>
                                <template x-if="siswa.spmb_id">
                                    <span class="px-1.5 py-0.5 rounded-md bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 text-[9px] font-black uppercase tracking-wider leading-none">Baru</span>
                                </template>
                            </div>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">
                                <span x-text="formatTanggal(siswa.tanggal_lahir)"></span>
                                &bull; <span x-text="hitungUsia(siswa.tanggal_lahir)"></span>
                            </p>
                        </div>

                        <div class="flex items-center gap-1">
                            <button type="button"
                                    @click="dariBKeBelum(index)"
                                    class="flex-shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-md text-[10px] font-bold transition-all
                                           bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 hover:bg-slate-200 hover:text-slate-700 dark:hover:bg-slate-600 dark:hover:text-slate-200"
                                    title="Keluarkan dari kelompok">
                                <span class="material-symbols-outlined text-[14px]">person_off</span>
                            </button>
                            <button type="button"
                                    @click="pindahKeA(index)"
                                    :disabled="kelasA.length >= 27"
                                    class="flex-shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-bold transition-all
                                           bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 hover:bg-blue-100
                                           disabled:opacity-40 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined text-xs">arrow_back</span>
                                ke A
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="kelasB.length === 0">
                    <div class="py-10 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600">inbox</span>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">Tidak ada siswa di Kelompok B</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- ===== SAVE FORM ===== --}}
    <form id="simpan-form"
          action="{{ route($rolePrefix . '.siswa.siswa-aktif.pembagian-kelas.simpan') }}"
          method="POST">
        @csrf
        {{-- Hidden inputs will be injected by Alpine before submit --}}
        <div id="assignments-container"></div>
    </form>

    {{-- ===== FOOTER ACTIONS ===== --}}
    <div class="space-y-4">
        {{-- Section: Detailed Names (Expandable) --}}
        <div x-show="showNames" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
            <h3 class="text-sm font-black text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">list_alt</span>
                Rincian Siswa per Kelompok
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- List A -->
                <div class="space-y-2">
                    <h4 class="text-xs font-black text-blue-600 uppercase tracking-wider">Kelompok A (<span x-text="kelasA.length"></span>)</h4>
                    <div class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed max-h-[150px] overflow-y-auto p-3 bg-blue-50/50 dark:bg-blue-900/10 rounded-xl border border-blue-100/50 dark:border-blue-800/30">
                        <template x-for="(s, i) in kelasA" :key="s.id">
                            <span x-text="s.nama_lengkap + (i < kelasA.length - 1 ? ', ' : '')"></span>
                        </template>
                        <template x-if="kelasA.length === 0">
                            <span class="italic opacity-50">Belum ada siswa</span>
                        </template>
                    </div>
                </div>
                
                <!-- List B -->
                <div class="space-y-2">
                    <h4 class="text-xs font-black text-purple-600 uppercase tracking-wider">Kelompok B (<span x-text="kelasB.length"></span>)</h4>
                    <div class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed max-h-[150px] overflow-y-auto p-3 bg-purple-50/50 dark:bg-purple-900/10 rounded-xl border border-purple-100/50 dark:border-purple-800/30">
                        <template x-for="(s, i) in kelasB" :key="s.id">
                            <span x-text="s.nama_lengkap + (i < kelasB.length - 1 ? ', ' : '')"></span>
                        </template>
                        <template x-if="kelasB.length === 0">
                            <span class="italic opacity-50">Belum ada siswa</span>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-slate-500 dark:text-slate-400">
                <span class="font-bold text-slate-700 dark:text-slate-200">Ringkasan:</span>
                Kelompok A = <span class="font-bold text-blue-600" x-text="kelasA.length"></span> siswa &nbsp;|&nbsp;
                Kelompok B = <span class="font-bold text-purple-600" x-text="kelasB.length"></span> siswa
                <span x-show="hasUnsaved" class="ml-2 text-amber-500 text-[11px] font-semibold">● Ada perubahan belum disimpan</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route($rolePrefix . '.siswa.siswa-aktif.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">
                    Batal
                </a>
                <button type="button"
                        @click="simpan()"
                        :disabled="hasCapacityError() || kelasBelum.length > 0"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-xl font-bold text-sm transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-base">save</span>
                    Simpan Pembagian Kelompok
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function pembagianKelas() {
    return {
        kelasA: @php
            $jsA = $kelasA->map(function($s) {
                $arr = is_array($s) ? $s : $s->toArray();
                $tgl = $arr['tanggal_lahir'] ?? null;
                if ($tgl && is_array($tgl)) $tgl = null; // safety
                if ($tgl) $tgl = is_string($tgl) ? substr($tgl, 0, 10) : substr((string)$tgl, 0, 10);
                return ['id' => $arr['id'], 'nama_lengkap' => $arr['nama_lengkap'] ?? '', 'tanggal_lahir' => $tgl, 'spmb_id' => $arr['spmb_id'] ?? null];
            })->values();
            echo json_encode($jsA);
        @endphp,
        kelasB: @php
            $jsB = $kelasB->map(function($s) {
                $arr = is_array($s) ? $s : $s->toArray();
                $tgl = $arr['tanggal_lahir'] ?? null;
                if ($tgl && is_array($tgl)) $tgl = null;
                if ($tgl) $tgl = is_string($tgl) ? substr($tgl, 0, 10) : substr((string)$tgl, 0, 10);
                return ['id' => $arr['id'], 'nama_lengkap' => $arr['nama_lengkap'] ?? '', 'tanggal_lahir' => $tgl, 'spmb_id' => $arr['spmb_id'] ?? null];
            })->values();
            echo json_encode($jsB);
        @endphp,
        kelasBelum: @php
            $jsBelum = $kelasBelum->map(function($s) {
                $arr = is_array($s) ? $s : $s->toArray();
                $tgl = $arr['tanggal_lahir'] ?? null;
                if ($tgl && is_array($tgl)) $tgl = null;
                if ($tgl) $tgl = is_string($tgl) ? substr($tgl, 0, 10) : substr((string)$tgl, 0, 10);
                return ['id' => $arr['id'], 'nama_lengkap' => $arr['nama_lengkap'] ?? '', 'tanggal_lahir' => $tgl, 'spmb_id' => $arr['spmb_id'] ?? null];
            })->values();
            echo json_encode($jsBelum);
        @endphp,
        hasUnsaved: false,
        showNames: false,

        init() {},

        initials(nama) {
            if (!nama) return '??';
            const parts = nama.trim().split(' ');
            return parts.length >= 2
                ? (parts[0][0] + parts[1][0]).toUpperCase()
                : nama.substring(0, 2).toUpperCase();
        },

        formatTanggal(tgl) {
            if (!tgl) return '-';
            const d = new Date(tgl);
            if (isNaN(d)) return tgl;
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        },

        hitungUsia(tgl) {
            if (!tgl) return '-';
            const lahir = new Date(tgl);
            if (isNaN(lahir)) return '-';
            const now = new Date();
            let tahun = now.getFullYear() - lahir.getFullYear();
            let bulan = now.getMonth() - lahir.getMonth();
            if (bulan < 0) { tahun--; bulan += 12; }
            return `${tahun} thn ${bulan} bln`;
        },

        pindahKeB(index) {
            if (this.kelasB.length >= 27) { alert('Kelas B sudah penuh (maks. 27 siswa)!'); return; }
            const [siswa] = this.kelasA.splice(index, 1);
            this.kelasB.push(siswa);
            this.hasUnsaved = true;
        },

        pindahKeA(index) {
            if (this.kelasA.length >= 27) { alert('Kelas A sudah penuh (maks. 27 siswa)!'); return; }
            const [siswa] = this.kelasB.splice(index, 1);
            this.kelasA.push(siswa);
            this.hasUnsaved = true;
        },

        dariAKeBelum(index) {
            const [siswa] = this.kelasA.splice(index, 1);
            this.kelasBelum.push(siswa);
            this.hasUnsaved = true;
        },

        dariBKeBelum(index) {
            const [siswa] = this.kelasB.splice(index, 1);
            this.kelasBelum.push(siswa);
            this.hasUnsaved = true;
        },

        dariBelumKeA(index) {
            if (this.kelasA.length >= 27) { alert('Kelas A sudah penuh (maks. 27 siswa)!'); return; }
            const [siswa] = this.kelasBelum.splice(index, 1);
            this.kelasA.push(siswa);
            this.hasUnsaved = true;
        },

        dariBelumKeB(index) {
            if (this.kelasB.length >= 27) { alert('Kelas B sudah penuh (maks. 27 siswa)!'); return; }
            const [siswa] = this.kelasBelum.splice(index, 1);
            this.kelasB.push(siswa);
            this.hasUnsaved = true;
        },

        hasCapacityError() { return this.kelasA.length > 27 || this.kelasB.length > 27; },
        hasSoftWarning()   { return this.kelasA.length > 25 || this.kelasB.length > 25; },

        capacityWarningText() {
            const msgs = [];
            if (this.kelasA.length > 27) msgs.push(`Kelas A melebihi batas (${this.kelasA.length}/27)`);
            if (this.kelasB.length > 27) msgs.push(`Kelas B melebihi batas (${this.kelasB.length}/27)`);
            return '⚠ ' + msgs.join(' · ') + '. Harap pindahkan siswa sebelum menyimpan.';
        },

        softWarningText() {
            const msgs = [];
            if (this.kelasA.length > 25 && this.kelasA.length <= 27) msgs.push(`Kelompok A hampir penuh (${this.kelasA.length}/27)`);
            if (this.kelasB.length > 25 && this.kelasB.length <= 27) msgs.push(`Kelompok B hampir penuh (${this.kelasB.length}/27)`);
            return msgs.join(' · ');
        },

        simpan() {
            if (this.hasCapacityError()) { alert('Tidak bisa menyimpan: jumlah siswa melebihi batas 27 per kelas.'); return; }
            if (this.kelasBelum.length > 0) { alert('Tidak bisa menyimpan: masih ada siswa yang belum mendapatkan kelompok.'); return; }
            if (!confirm('Simpan pembagian kelas ini ke database?')) return;

            const container = document.getElementById('assignments-container');
            container.innerHTML = '';
            const addInput = (name, value) => {
                const el = document.createElement('input');
                el.type = 'hidden'; el.name = name; el.value = value;
                container.appendChild(el);
            };
            this.kelasA.forEach((s, i) => { addInput(`assignments[${i}][id]`, s.id); addInput(`assignments[${i}][kelompok]`, 'A'); });
            let offset = this.kelasA.length;
            this.kelasB.forEach((s, i) => { addInput(`assignments[${offset+i}][id]`, s.id); addInput(`assignments[${offset+i}][kelompok]`, 'B'); });
            offset += this.kelasB.length;
            this.kelasBelum.forEach((s, i) => { addInput(`assignments[${offset+i}][id]`, s.id); addInput(`assignments[${offset+i}][kelompok]`, ''); });
            document.getElementById('simpan-form').submit();
        },
    };
}
</script>
@endpush
@endsection

