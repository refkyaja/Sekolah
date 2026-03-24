@extends('layouts.admin')

@section('title', 'Edit Akun Calon Siswa')
@section('breadcrumb', 'Edit Akun')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 pb-12">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.siswa-accounts.show', $account) }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition-colors text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Detail
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 border-b border-slate-100 dark:border-slate-800">
            <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-500">edit_note</span>
                Formulir Edit Akun
            </h3>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi dasar akun pendaftar PPDB.</p>
        </div>

        <form action="{{ route('admin.siswa-accounts.update', $account) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap Siswa</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $account->nama_lengkap) }}" required 
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100 placeholder:text-slate-400">
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Akun</label>
                    <input type="email" name="email" value="{{ old('email', $account->email) }}" required 
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100 placeholder:text-slate-400">
                    <p class="text-[10px] text-slate-400 mt-1.5 italic">* Email digunakan untuk login ke portal PPDB.</p>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor HP / WhatsApp</label>
                    <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $account->no_hp_ortu) }}" 
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100 placeholder:text-slate-400"
                           placeholder="Contoh: 08123456789">
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Login</label>
                    <div class="flex items-center gap-4 mt-1">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $account->is_active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            <span class="ml-3 text-sm font-medium text-slate-600 dark:text-slate-300">Izinkan Login (Aktif)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
                <button type="submit" class="flex-1 bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-md shadow-primary/20">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.siswa-accounts.show', $account) }}" class="px-8 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
