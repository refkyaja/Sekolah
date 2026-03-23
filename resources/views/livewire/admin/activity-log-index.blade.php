<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">history</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 dark:text-slate-400">Total Log</p>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 dark:text-slate-100">{{ $activities->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 dark:border-slate-700">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">search</span>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                        placeholder="Cari aktivitas, user, atau IP..." 
                        class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-slate-600 dark:text-slate-400 dark:text-slate-300">
                </div>
            </div>
            <div class="w-full md:w-48">
                <input type="date" wire:model.live="date" 
                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-slate-600 dark:text-slate-400 dark:text-slate-300" [color-scheme:light] dark:[color-scheme:dark]>
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="role" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-slate-600 dark:text-slate-400 dark:text-slate-300">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                    <option value="kepala_sekolah">Kepala Sekolah</option>
                    <option value="operator">Operator</option>
                </select>
            </div>
            <div class="w-full md:w-40">
                <select wire:model.live="sort" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-900 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-slate-600 dark:text-slate-400 dark:text-slate-300">
                    <option value="terbaru">Terbaru</option>
                    <option value="terlama">Terlama</option>
                </select>
            </div>
            @if($search || $date || $role || $sort !== 'terbaru')
                <button wire:click="resetFilters" class="px-6 py-2 bg-slate-100 dark:bg-slate-700 dark:bg-slate-700 text-slate-600 dark:text-slate-400 dark:text-slate-300 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 dark:hover:bg-slate-600 transition-all font-medium">
                    Reset
                </button>
            @endif
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-slate-800 dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto text-center">
            <div wire:loading class="absolute inset-0 bg-white/50 dark:bg-slate-800/50 flex items-center justify-center z-10">
                <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 dark:border-slate-700">
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">No</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">User</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">Role</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">Deskripsi Aktivitas</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-600 dark:text-slate-400 dark:text-slate-300">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 dark:text-slate-400">
                            {{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 dark:text-slate-400">
                            {{ $activity->created_at->translatedFormat('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-primary">
                                    {{ $activity->user ? strtoupper(substr($activity->user->name, 0, 1)) : 'S' }}
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 dark:text-slate-200">
                                    {{ $activity->user ? $activity->user->name : 'System' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $activity->user && $activity->user->role === 'admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                {{ $activity->user ? ucfirst($activity->user->role) : 'System' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600 dark:text-slate-400 dark:text-slate-400 max-w-xs truncate" title="{{ $activity->description }}">
                                {{ $activity->description }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 dark:text-slate-400">
                                <span class="material-symbols-outlined text-[16px]">public</span>
                                {{ $activity->ip_address ?? '-' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400 dark:text-slate-400">
                            <span class="material-symbols-outlined text-4xl mb-2">history</span>
                            <p>Tidak ada log aktivitas ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 dark:border-slate-700">
            {{ $activities->links() }}
        </div>
        @endif
    </div>
</div>
