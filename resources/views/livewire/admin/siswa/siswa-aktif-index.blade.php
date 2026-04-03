<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-4 rounded-xl border border-slate-100 dark:border-slate-700 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Total Aktif</p>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 dark:text-white mt-1">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">groups</span>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-4 rounded-xl border border-slate-100 dark:border-slate-700 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kelompok A/B</p>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 dark:text-white mt-1">{{ $stats['kelompok_a'] }}/{{ $stats['kelompok_b'] }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500">class</span>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-4 rounded-xl border border-slate-100 dark:border-slate-700 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Laki-Laki</p>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 dark:text-white mt-1">{{ $stats['laki_laki'] }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-cyan-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-cyan-500">male</span>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-4 rounded-xl border border-slate-100 dark:border-slate-700 dark:border-slate-700 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Perempuan</p>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 dark:text-white mt-1">{{ $stats['perempuan'] }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-pink-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-pink-500">female</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-6 border border-slate-100 dark:border-slate-700 dark:border-slate-700 shadow-sm flex flex-wrap items-center gap-3 sm:gap-4">
        <div class="flex-1 min-w-[200px] sm:min-w-[250px] relative">
            <span class="material-symbols-outlined absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-lg sm:text-xl">search</span>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 border-none rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary/20 text-xs sm:text-sm transition-all"
                placeholder="Cari NIS atau Nama Lengkap..." />
        </div>

        <div class="w-full sm:w-40 md:w-48">
            <select wire:model.live="kelompok" class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 border-none rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary/20 text-xs sm:text-sm text-slate-600 dark:text-slate-400 dark:text-slate-300 transition-all cursor-pointer">
                <option value="">Semua Kelompok</option>
                <option value="A">Kelompok A</option>
                <option value="B">Kelompok B</option>
            </select>
        </div>

        <div class="w-full sm:w-40 md:w-48">
            <select wire:model.live="sort" class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 border-none rounded-lg sm:rounded-xl focus:ring-2 focus:ring-primary/20 text-xs sm:text-sm text-slate-600 dark:text-slate-400 dark:text-slate-300 transition-all cursor-pointer">
                <option value="terbaru">Terbaru</option>
                <option value="terlama">Terlama</option>
                <option value="nama_asc">Nama A-Z</option>
                <option value="nama_desc">Nama Z-A</option>
            </select>
        </div>

        @if(!empty($selectedIds))
        <div class="w-full sm:w-48 md:w-56" x-data="{ open: false }">
            <div class="relative">
                <button type="button" @click="open = !open" class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-primary text-white rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm flex items-center justify-between transition-all">
                    <span>Aksi ({{ count($selectedIds) }})</span>
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 w-full mt-2 bg-white dark:bg-slate-800 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden">
                    <button type="button" onclick="confirm('Hapus {{ count($selectedIds) }} siswa?') && @this.deleteSelected()" class="w-full px-4 py-2 text-left text-xs sm:text-sm text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 dark:hover:bg-red-900/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">delete</span> Hapus Terpilih
                    </button>
                    <hr class="border-slate-100 dark:border-slate-700 dark:border-slate-700">
                    <button type="button" onclick="confirm('Set status LULUS untuk {{ count($selectedIds) }} siswa?') && @this.updateStatusSelected('lulus')" class="w-full px-4 py-2 text-left text-xs sm:text-sm text-slate-600 dark:text-slate-400 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">school</span> Set Lulus
                    </button>
                    <button type="button" onclick="confirm('Set status PINDAH untuk {{ count($selectedIds) }} siswa?') && @this.updateStatusSelected('pindah')" class="w-full px-4 py-2 text-left text-xs sm:text-sm text-slate-600 dark:text-slate-400 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">logout</span> Set Pindah
                    </button>
                    <hr class="border-slate-100 dark:border-slate-700 dark:border-slate-700">
                    <button type="button" onclick="confirm('Pindahkan {{ count($selectedIds) }} siswa ke Kelompok B?') && @this.updateKelompokSelected('B')" class="w-full px-4 py-2 text-left text-xs sm:text-sm text-blue-600 dark:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">swap_horiz</span> Pindah Kelompok B
                    </button>
                </div>
            </div>
        </div>
        @endif

        @php
            $rolePrefix = match(auth()->user()->role) {
                'kepala_sekolah' => 'kepala-sekolah',
                'operator'       => 'operator',
                default          => 'admin'
            };
        @endphp

        <div x-data="pembagianKelompokModal()">
            <!-- Trigger Button -->
            <button type="button" @click="openModal()"
                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                <span class="material-symbols-outlined text-sm">grid_view</span>
                Bagi Kelompok
            </button>

            <!-- Modal -->
            <template x-teleport="body">
                <div x-show="isOpen" 
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                    x-cloak>
                    <!-- Overlay -->
                    <div x-show="isOpen" 
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                        @click="closeModal()"></div>

                    <!-- Modal Content -->
                    <div x-show="isOpen"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative bg-white dark:bg-slate-900 w-full max-w-6xl max-h-[90vh] rounded-[2rem] shadow-2xl flex flex-col overflow-hidden border border-slate-100 dark:border-slate-800">
                        
                        <!-- Header -->
                        <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
                            <div>
                                <h2 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined text-indigo-600">grid_view</span>
                                    Pembagian Kelompok Siswa
                                </h2>
                                <p class="text-xs text-slate-500 mt-1">Atur pembagian siswa ke Kelompok A (4-5 thn) dan B (5-6 thn) secara interaktif.</p>
                            </div>
                            <button @click="closeModal()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                                <span class="material-symbols-outlined text-slate-400">close</span>
                            </button>
                        </div>

                        <!-- Main Content (Scrollable) -->
                        <div class="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6">
                            
                            <!-- Loading State -->
                            <div x-show="loading" class="py-12 flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined animate-spin text-4xl text-indigo-600 mb-4">progress_activity</span>
                                <p class="text-sm font-bold text-slate-500">Memuat data siswa...</p>
                            </div>

                            <!-- Interactive Grid -->
                            <div x-show="!loading" class="grid grid-cols-1 lg:grid-cols-2 gap-8" x-cloak>
                                
                                <!-- Column: Kelompok A -->
                                <div class="flex flex-col h-full bg-slate-50/30 dark:bg-slate-950/20 rounded-[1.5rem] border border-slate-100 dark:border-slate-800/50 overflow-hidden">
                                    <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                             <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">A</div>
                                             <div>
                                                 <h3 class="text-sm font-black text-white uppercase tracking-wider">Kelompok A</h3>
                                                 <p class="text-[10px] text-indigo-100 font-bold uppercase tracking-widest">Usia 4 - 5 Tahun</p>
                                             </div>
                                        </div>
                                        <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-black" x-text="kelompokA.length + ' Siswa'"></span>
                                    </div>

                                    <div class="p-4 space-y-3 overflow-y-auto max-h-[400px]">
                                        <template x-for="(siswa, index) in kelompokA" :key="siswa.id">
                                            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between group hover:shadow-md transition-all">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs" x-text="initials(siswa.nama)"></div>
                                                    <div>
                                                        <p class="text-sm font-black text-slate-800 dark:text-white" x-text="siswa.nama"></p>
                                                        <p class="text-[10px] text-slate-400 font-bold" x-text="siswa.usia_string + ' • ' + (siswa.usia >= 5 ? 'Promosi B ✅' : 'Kategori A')"></p> 
                                                    </div>
                                                </div>
                                                <button @click="moveToB(index)" class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl opacity-0 group-hover:opacity-100 transition-all hover:bg-indigo-600 hover:text-white">
                                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="kelompokA.length === 0">
                                            <div class="py-12 flex flex-col items-center justify-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2">group_off</span>
                                                <p class="text-xs font-bold uppercase tracking-widest">Kosong</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Column: Kelompok B -->
                                <div class="flex flex-col h-full bg-slate-50/30 dark:bg-slate-950/20 rounded-[1.5rem] border border-slate-100 dark:border-slate-800/50 overflow-hidden">
                                    <div class="bg-purple-600 px-6 py-4 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                             <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">B</div>
                                             <div>
                                                 <h3 class="text-sm font-black text-white uppercase tracking-wider">Kelompok B</h3>
                                                 <p class="text-[10px] text-purple-100 font-bold uppercase tracking-widest">Usia 5 - 6 Tahun</p>
                                             </div>
                                        </div>
                                        <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-black" x-text="kelompokB.length + ' Siswa'"></span>
                                    </div>

                                    <div class="p-4 space-y-3 overflow-y-auto max-h-[400px]">
                                        <template x-for="(siswa, index) in kelompokB" :key="siswa.id">
                                            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between group hover:shadow-md transition-all">
                                                <button @click="moveToA(index)" class="p-2 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl opacity-0 group-hover:opacity-100 transition-all hover:bg-purple-600 hover:text-white">
                                                    <span class="material-symbols-outlined text-base">arrow_back</span>
                                                </button>
                                                <div class="flex items-center gap-3 text-right">
                                                    <div>
                                                        <p class="text-sm font-black text-slate-800 dark:text-white" x-text="siswa.nama"></p>
                                                        <p class="text-[10px] text-slate-400 font-bold" x-text="siswa.usia_string + ' • ' + (siswa.usia < 5 ? 'Kategori A ⚠️' : 'Kategori B')"></p> 
                                                    </div>
                                                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-xs" x-text="initials(siswa.nama)"></div>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="kelompokB.length === 0">
                                            <div class="py-12 flex flex-col items-center justify-center text-slate-400">
                                                <span class="material-symbols-outlined text-4xl mb-2">group_off</span>
                                                <p class="text-xs font-bold uppercase tracking-widest">Kosong</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>

                            <!-- Balancing & Logic Info -->
                            <div x-show="!loading" class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                                <div class="flex items-center gap-3">
                                    <div :class="isBalanced() ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'" class="w-10 h-10 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xl" x-text="isBalanced() ? 'check_circle' : 'warning'"></span>
                                    </div>
                                    <p class="text-xs font-bold" :class="isBalanced() ? 'text-green-700' : 'text-amber-700'">
                                        <span x-text="isBalanced() ? 'Status: Jumlah siswa seimbang.' : 'Status: Selisih kelompok ' + Math.abs(kelompokA.length - kelompokB.length) + ' orang.'"></span>
                                    </p>
                                </div>
                                <button type="button" @click="autoCategorize()" 
                                    class="text-xs font-black text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-base">auto_awesome</span>
                                    Kategorikan Otomatis Berdasar Umur
                                </button>
                            </div>

                        </div>

                        <!-- Name Summary (Expandable) -->
                        <div x-show="showNames" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                             class="px-8 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800">
                             <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-1">Daftar Kelompok A</h4>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed max-h-[100px] overflow-y-auto">
                                        <template x-for="(s, i) in kelompokA" :key="s.id">
                                            <span x-text="s.nama + (i < kelompokA.length - 1 ? ', ' : '')"></span>
                                        </template>
                                        <template x-if="kelompokA.length === 0">
                                            <span class="italic opacity-50">Kosong</span>
                                        </template>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-purple-600 dark:text-purple-400 uppercase tracking-widest mb-1">Daftar Kelompok B</h4>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed max-h-[100px] overflow-y-auto">
                                        <template x-for="(s, i) in kelompokB" :key="s.id">
                                            <span x-text="s.nama + (i < kelompokB.length - 1 ? ', ' : '')"></span>
                                        </template>
                                        <template x-if="kelompokB.length === 0">
                                            <span class="italic opacity-50">Kosong</span>
                                        </template>
                                    </div>
                                </div>
                             </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
                            <button @click="showNames = !showNames" 
                                class="flex items-center gap-2 px-4 py-2 text-indigo-600 dark:text-indigo-400 font-black text-[10px] uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                                <span class="material-symbols-outlined text-sm" x-text="showNames ? 'visibility_off' : 'visibility'"></span>
                                <span x-text="showNames ? 'Sembunyikan Nama' : 'Tinjau Daftar Nama'"></span>
                            </button>

                            <div class="flex items-center gap-3">
                                <button @click="closeModal()" 
                                    class="px-6 py-3 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all">
                                    Batal
                                </button>
                                <button @click="saveGrouping()" 
                                    :disabled="saving"
                                    class="px-8 py-3 bg-indigo-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 disabled:opacity-50 flex items-center gap-2">
                                    <span x-show="saving" class="material-symbols-outlined animate-spin text-sm">progress_activity</span>
                                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Pembagian'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <button type="button" wire:click="resetFilters"
            class="px-4 sm:px-6 py-2 sm:py-3 bg-slate-100 dark:bg-slate-700 dark:bg-slate-700 text-slate-600 dark:text-slate-400 dark:text-slate-300 rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm hover:bg-slate-200 dark:hover:bg-slate-600 dark:hover:bg-slate-600 transition-all whitespace-nowrap">
            Reset Filter
        </button>
    </div>

    <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 rounded-xl sm:rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 dark:border-slate-700 overflow-hidden relative">
        <div wire:loading.delay class="absolute inset-0 bg-white/20 dark:bg-slate-800/20 z-10 flex items-center justify-center">
            <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 px-4 py-2 rounded-full shadow-lg flex items-center gap-2 border border-slate-100 dark:border-slate-700 dark:border-slate-700">
                <span class="material-symbols-outlined animate-spin text-primary text-xl">progress_activity</span>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 dark:text-slate-300">Memproses...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700 dark:border-slate-700">
                        <th class="pl-4 sm:pl-6 py-3 sm:py-4 w-10 sm:w-12">
                            <input type="checkbox" wire:model.live="selectAll" class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded border-slate-300 dark:border-slate-600 text-primary focus:ring-primary transition-all cursor-pointer">
                        </th>
                        <th class="px-2 sm:px-4 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider w-12 sm:w-16 text-center">No</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">NIS</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider hidden md:table-cell">Jenis Kelamin</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Kelompok</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-[10px] sm:text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50 dark:divide-slate-700">
                    @forelse($siswas as $index => $siswa)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="pl-4 sm:pl-6 py-3 sm:py-4">
                            <input type="checkbox" wire:model.live="selectedIds" value="{{ $siswa->id }}" class="w-3.5 h-3.5 sm:w-4 sm:h-4 rounded border-slate-300 dark:border-slate-600 text-primary focus:ring-primary transition-all cursor-pointer">
                        </td>
                        <td class="px-2 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm font-medium text-slate-400 dark:text-slate-500 text-center">
                            {{ $siswas->firstItem() + $index }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm font-medium text-slate-600 dark:text-slate-400 dark:text-slate-300">
                            {{ $siswa->nis ?? 'NIS-' . str_pad($siswa->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-lavender dark:bg-primary/20 text-primary dark:text-white flex items-center justify-center font-bold text-[10px] sm:text-xs">
                                    {{ strtoupper(substr($siswa->nama_lengkap ?? $siswa->name ?? 'NA', 0, 2)) }}
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 dark:text-white truncate max-w-[100px] sm:max-w-[150px] md:max-w-[200px]">
                                    {{ $siswa->nama_lengkap ?? $siswa->name ?? 'Nama Siswa' }}
                                </span>
                                @if($siswa->spmb_id)
                                    <span class="px-1.5 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[9px] font-black uppercase tracking-wider leading-none">Baru</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400 dark:text-slate-300 hidden md:table-cell">
                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            @if($siswa->kelompok)
                                <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold {{ $siswa->kelompok == 'A' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : 'bg-purple-100 text-primary dark:bg-purple-900/30 dark:text-purple-400' }}">
                                    Kelompok {{ $siswa->kelompok }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 italic">
                                    Belum Ada Kelompok
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="flex items-center justify-center gap-0.5 sm:gap-1">
                                <a href="{{ route('admin.siswa.siswa-aktif.show', $siswa->id) }}"
                                   class="p-1 sm:p-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 hover:bg-primary/10 text-slate-400 dark:text-slate-500 hover:text-primary rounded-lg transition-all"
                                   title="Detail">
                                    <span class="material-symbols-outlined text-sm sm:text-lg">visibility</span>
                                </a>
                                <a href="{{ route('admin.siswa.siswa-aktif.edit', $siswa->id) }}"
                                   class="p-1 sm:p-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 hover:bg-primary/10 text-slate-400 dark:text-slate-500 hover:text-primary rounded-lg transition-all"
                                   title="Edit">
                                    <span class="material-symbols-outlined text-sm sm:text-lg">edit</span>
                                </a>
                                <button type="button"
                                        @click="if(confirm('Hapus data siswa ini?')) { $wire.deleteSiswa({{ $siswa->id }}) }"
                                        class="p-1 sm:p-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-700 hover:bg-red-50 dark:hover:bg-red-900/20 dark:hover:bg-red-900/20 text-slate-400 dark:text-slate-500 hover:text-red-500 rounded-lg transition-all"
                                        title="Hapus">
                                    <span class="material-symbols-outlined text-sm sm:text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 sm:py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-4xl sm:text-5xl text-slate-300 dark:text-slate-600 mb-3">inbox</span>
                                <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400">Tidak ada data siswa ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-slate-50 dark:border-slate-700/50 dark:border-slate-700">
            {{ $siswas->links() }}
        </div>
    </div>
</div>
@push('scripts')
<script>
    function pembagianKelompokModal() {
        return {
            isOpen: false,
            loading: false,
            saving: false,
            showNames: false,
            students: [],
            kelompokA: [],
            kelompokB: [],

            async openModal() {
                this.isOpen = true;
                this.loading = true;
                try {
                    const response = await fetch('{{ route($rolePrefix . ".ppdb.get-grouping-data") }}');
                    const result = await response.json();
                    
                    if (result.success) {
                        this.students = result.students;
                        // Initial distribution based on existing 'kelompok' field or auto
                        this.kelompokA = this.students.filter(s => s.kelompok === 'A');
                        this.kelompokB = this.students.filter(s => s.kelompok === 'B');
                        
                        // If both are empty, suggest auto categorization
                        if (this.kelompokA.length === 0 && this.kelompokB.length === 0) {
                            this.autoCategorize();
                        }
                    } else {
                        alert('Gagal memuat data: ' + result.message);
                        this.closeModal();
                    }
                } catch (error) {
                    console.error('Error fetching students:', error);
                    alert('Terjadi kesalahan saat memuat data.');
                    this.closeModal();
                } finally {
                    this.loading = false;
                }
            },

            closeModal() {
                this.isOpen = false;
                this.students = [];
                this.kelompokA = [];
                this.kelompokB = [];
            },

            autoCategorize() {
                // Kelompok A: 4 - 5 years (usia < 5.5 roughly, or exactly as requested)
                // The prompt said: A: 4-5, B: 5-6
                // We'll use 5 as the threshold
                this.kelompokA = this.students.filter(s => s.usia < 5);
                this.kelompokB = this.students.filter(s => s.usia >= 5);
                
                // Sort by age descending (older first in both)
                this.kelompokA.sort((a,b) => b.usia - a.usia);
                this.kelompokB.sort((a,b) => b.usia - a.usia);
            },

            moveToB(index) {
                const s = this.kelompokA.splice(index, 1)[0];
                this.kelompokB.push(s);
            },

            moveToA(index) {
                const s = this.kelompokB.splice(index, 1)[0];
                this.kelompokA.push(s);
            },

            isBalanced() {
                const diff = Math.abs(this.kelompokA.length - this.kelompokB.length);
                return diff <= 1;
            },

            initials(name) {
                if (!name) return 'NA';
                return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
            },

            async saveGrouping() {
                this.saving = true;
                try {
                    const response = await fetch('{{ route($rolePrefix . ".ppdb.save-grouping") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            kelompok_a: this.kelompokA.map(s => s.id),
                            kelompok_b: this.kelompokB.map(s => s.id)
                        })
                    });

                    const result = await response.json();
                    if (result.success) {
                        alert(result.message);
                        this.closeModal();
                        window.location.reload(); // Refresh to see changes
                    } else {
                        alert('Gagal menyimpan: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error saving grouping:', error);
                    alert('Terjadi kesalahan saat menyimpan data.');
                } finally {
                    this.saving = false;
                }
            }
        }
    }
</script>
@endpush
