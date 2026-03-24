@extends('layouts.admin')

@section('title', 'Detail Akun Calon Siswa')
@section('breadcrumb', 'Detail Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.siswa-accounts.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-primary transition-colors text-sm font-medium">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.siswa-accounts.edit', $account) }}" class="inline-flex items-center gap-2 bg-amber-500 text-white px-4 py-2 rounded-xl font-semibold text-sm hover:bg-amber-600 transition-all shadow-sm">
                <span class="material-symbols-outlined text-lg">edit</span>
                Edit Akun
            </a>
            <form action="{{ route('admin.siswa-accounts.toggle-status', $account) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 {{ $account->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-xl font-semibold text-sm transition-all shadow-sm">
                    <span class="material-symbols-outlined text-lg">{{ $account->is_active ? 'block' : 'check_circle' }}</span>
                    {{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 text-center">
                <div class="relative inline-block mb-4">
                    <img src="{{ $account->foto_url }}" class="w-32 h-32 rounded-full object-cover border-4 border-slate-50 dark:border-slate-800 shadow-md">
                    <div class="absolute bottom-0 right-0">
                        @if($account->is_active)
                            <div class="w-8 h-8 bg-green-500 border-4 border-white dark:border-slate-900 rounded-full flex items-center justify-center shadow-sm" title="Akun Aktif">
                                <span class="material-symbols-outlined text-white text-[16px] font-bold">check</span>
                            </div>
                        @else
                            <div class="w-8 h-8 bg-red-500 border-4 border-white dark:border-slate-900 rounded-full flex items-center justify-center shadow-sm" title="Akun Nonaktif">
                                <span class="material-symbols-outlined text-white text-[16px] font-bold">close</span>
                            </div>
                        @endif
                    </div>
                </div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ $account->nama_lengkap }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $account->email }}</p>
                
                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Akun</p>
                            <span class="px-2 py-0.5 {{ $account->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} text-[10px] font-bold rounded-lg border border-current">
                                {{ $account->is_active ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status PPDB</p>
                            <span class="px-2 py-0.5 {{ $account->spmb ? 'bg-blue-50 text-blue-600' : 'bg-slate-50 text-slate-400' }} text-[10px] font-bold rounded-lg border border-current">
                                {{ $account->spmb ? 'SUDAH DAFTAR' : 'BELUM DAFTAR' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50/50 dark:bg-red-900/10 rounded-3xl p-6 border border-red-100 dark:border-red-900/30">
                <h3 class="text-sm font-bold text-red-800 dark:text-red-400 flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-lg">warning</span>
                    Area Berbahaya
                </h3>
                <form action="{{ route('admin.siswa-accounts.destroy', $account) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Semua data terkait mungkin akan terpengaruh.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white dark:bg-slate-900 text-red-600 border border-red-200 dark:border-red-800 py-2.5 rounded-xl font-bold text-sm hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus Akun Permanen
                    </button>
                </form>
            </div>
        </div>

        <!-- Detail Sections -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person</span>
                        Informasi Akun
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $account->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $account->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor HP / WhatsApp</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $account->no_hp_ortu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Metode Pendaftaran</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            {{ $account->provider ? 'Login Google (' . ucfirst($account->provider) . ')' : 'Email & Password' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dibuat Pada</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            {{ $account->created_at->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Terakhir Diperbarui</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            {{ $account->updated_at->translatedFormat('d F Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- PPDB Data Information -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">app_registration</span>
                        Data Pendaftaran PPDB
                    </h3>
                </div>
                <div class="p-6">
                    @if($account->spmb)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Pendaftaran</p>
                                <p class="text-sm font-bold text-primary">{{ $account->spmb->no_pendaftaran }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Seleksi</p>
                                <p class="text-sm font-semibold">
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold leading-none bg-blue-50 text-blue-600 border border-blue-100">
                                        {{ strtoupper($account->spmb->status_ppdb ?? 'MENUNGGU') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-4">
                            <a href="{{ route('admin.ppdb.show', $account->spmb->id) }}" class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-lg">open_in_new</span>
                                Lihat Data Lengkap Siswa
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">find_in_page</span>
                            <p class="text-sm text-slate-500">Akun ini belum mengisi formulir pendaftaran PPDB.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reset Password Section -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">lock_reset</span>
                        Reset Password Akun
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-xs text-slate-500 mb-6">Atur ulang kata sandi pengguna untuk memulihkan akses mereka.</p>
                    <form action="{{ route('admin.siswa-accounts.reset-password', $account) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Password Baru</label>
                            <input type="password" name="password" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 px-6 py-2.5 rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
