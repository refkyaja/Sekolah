@extends('layouts.admin')

@section('title', 'Tambah Akun Baru')
@section('breadcrumb', 'Tambah Akun')

@section('content')
<div class="max-w-4xl mx-auto">
    @if($errors->any())
        <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl shadow-sm">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-amber-600">warning</span>
                <div class="flex-1">
                    <p class="text-sm font-bold text-amber-800">Terdapat kesalahan:</p>
                    <ul class="mt-1 text-sm text-amber-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-xl shadow-primary/5 border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-2xl">person_add</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Informasi Akun User</h3>
                    <p class="text-sm text-slate-500 font-medium">Lengkapi data profil dan otentikasi user.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.accounts.store') }}" class="p-8 space-y-8" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">badge</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="name"
                               name="name"
                               placeholder="Masukkan nama lengkap..."
                               type="text"
                               value="{{ old('name') }}"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="email">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="email"
                               name="email"
                               placeholder="example@school.id"
                               type="email"
                               value="{{ old('email') }}"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="password">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="password"
                               name="password"
                               placeholder="••••••••"
                               type="password"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="password_confirmation">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">lock_reset</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="••••••••"
                               type="password"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Jenis Kelamin</label>
                    <div class="flex gap-4 p-1 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-xl cursor-pointer hover:bg-white transition-all group has-[:checked]:bg-white has-[:checked]:shadow-sm has-[:checked]:text-primary">
                            <input class="hidden" name="jenis_kelamin" type="radio" value="Laki-laki" {{ old('jenis_kelamin', 'Laki-laki') === 'Laki-laki' ? 'checked' : '' }}/>
                            <span class="material-symbols-outlined text-xl group-has-[:checked]:text-primary text-slate-400">male</span>
                            <span class="text-sm font-semibold group-has-[:checked]:text-primary text-slate-600">Laki-laki</span>
                        </label>
                        <label class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-xl cursor-pointer hover:bg-white transition-all group has-[:checked]:bg-white has-[:checked]:shadow-sm has-[:checked]:text-primary">
                            <input class="hidden" name="jenis_kelamin" type="radio" value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }}/>
                            <span class="material-symbols-outlined text-xl group-has-[:checked]:text-primary text-slate-400">female</span>
                            <span class="text-sm font-semibold group-has-[:checked]:text-primary text-slate-600">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="tempat_lahir">Tempat Lahir</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">event</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="tempat_lahir"
                               name="tempat_lahir"
                               placeholder="Jakarta"
                               type="text"
                               value="{{ old('tempat_lahir') }}"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">calendar_today</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="tanggal_lahir"
                               name="tanggal_lahir"
                               type="date"
                               value="{{ old('tanggal_lahir') }}"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="no_telepon">No. Telepon</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">call</span>
                        <input class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                               id="no_telepon"
                               name="no_telepon"
                               placeholder="0812XXXXXXXX"
                               type="text"
                               value="{{ old('no_telepon') }}"/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="role">Role Akses</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">manage_accounts</span>
                        <select class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm font-semibold text-slate-600 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none appearance-none cursor-pointer"
                                id="role"
                                name="role">
                            <option value="">Pilih Role...</option>
                            <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kepala_sekolah" {{ old('role') === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="alamat">Alamat</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400 text-xl">location_on</span>
                        <textarea class="w-full pl-12 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl text-sm transition-all focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                  id="alamat"
                                  name="alamat"
                                  placeholder="Alamat lengkap"
                                  rows="3">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                <a class="w-full sm:w-auto px-8 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all text-center" href="{{ route('admin.accounts.index') }}">
                    Batal
                </a>
                <button class="w-full sm:w-auto flex items-center justify-center gap-2 px-10 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary/25" type="submit">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan User
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 flex items-start gap-4 p-4 bg-primary/5 rounded-2xl border border-primary/10">
        <span class="material-symbols-outlined text-primary">info</span>
        <div class="text-xs text-slate-500 leading-relaxed">
            <p class="font-bold text-slate-700 mb-1">Catatan Penting:</p>
            User yang baru ditambahkan akan secara otomatis memiliki status <span class="text-green-600 font-bold uppercase">Aktif</span>.
            Pastikan email yang didaftarkan sudah benar.
        </div>
    </div>
</div>
@endsection