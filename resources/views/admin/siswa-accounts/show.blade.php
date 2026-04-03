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
                    <div class="grid grid-cols-2 gap-4 pb-2">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Akun</p>
                            <span class="px-2 py-0.5 {{ $account->is_active ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200' }} text-[10px] font-bold rounded-lg border">
                                {{ $account->is_active ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kelulusan</p>
                            @if($account->status_siswa === 'aktif')
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border-emerald-200 text-[10px] font-bold rounded-lg border">SISWA AKTIF</span>
                            @elseif($account->status_siswa === 'lulus')
                                <span class="px-2 py-0.5 bg-sky-50 text-sky-600 border-sky-200 text-[10px] font-bold rounded-lg border">SISWA LULUS</span>
                            @else
                                <span class="px-2 py-0.5 bg-slate-50 text-slate-500 border-slate-200 text-[10px] font-bold rounded-lg border">{{ strtoupper($account->status_siswa ?? 'NONAKTIF') }}</span>
                            @endif
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status PPDB</p>
                            <span class="px-2 py-0.5 {{ $account->spmb ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-slate-50 text-slate-400 border-slate-200' }} text-[10px] font-bold rounded-lg border">
                                {{ $account->spmb ? 'SUDAH DAFTAR' : 'BELUM DAFTAR' }}
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Metode Login</p>
                            @if($account->provider === 'google')
                                <span class="px-2 py-0.5 bg-white text-slate-600 border-slate-200 text-[10px] font-bold rounded-lg border inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                    GOOGLE
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 border-slate-200 text-[10px] font-bold rounded-lg border inline-flex items-center gap-1">
                                    MANUAL
                                </span>
                            @endif
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
