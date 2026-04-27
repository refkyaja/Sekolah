@extends('layouts.admin')

@section('title', 'Edit Data Buku Tamu')
@section('breadcrumb', 'Buku Tamu / Edit')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-700/50">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-lavender flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">edit_note</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">Ubah Data Kunjungan</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui informasi kunjungan tamu di bawah ini.</p>
                </div>
            </div>

            <form action="{{ route('admin.bukutamu.update', $bukutamu) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="nama">Nama Pengunjung <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">person</span>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $bukutamu->nama) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    {{-- No HP --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="telepon">No. HP/Kontak <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">call</span>
                            <input type="tel" name="telepon" id="telepon" value="{{ old('telepon', $bukutamu->telepon) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="tanggal_kunjungan">Tanggal Datang <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">calendar_today</span>
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $bukutamu->tanggal_kunjungan->format('Y-m-d')) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" [color-scheme:light] dark:[color-scheme:dark]>
                        </div>
                    </div>

                    {{-- Jabatan --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="jabatan">Jabatan <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">badge</span>
                            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $bukutamu->jabatan) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="Contoh: Orang Tua / Staff Dinas">
                        </div>
                    </div>

                    {{-- Instansi --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="instansi">Instansi/Lembaga <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">corporate_fare</span>
                            <input type="text" name="instansi" id="instansi" value="{{ old('instansi', $bukutamu->instansi) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="Nama sekolah/instansi asal">
                        </div>
                    </div>

                    {{-- Maksud & Tujuan --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="tujuan_kunjungan">Maksud & Tujuan <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">flag</span>
                            <input type="text" name="tujuan_kunjungan" id="tujuan_kunjungan" value="{{ old('tujuan_kunjungan', $bukutamu->tujuan_kunjungan) }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="Contoh: Konsultasi / Urusan PPDB">
                        </div>
                    </div>

                    {{-- Hidden Fields for Timestamp compatibility with controller --}}
                    <input type="hidden" name="jam_kunjungan" value="{{ $bukutamu->jam_kunjungan }}">
                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="email">Email (Opsional)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl">mail</span>
                            <input type="email" name="email" id="email" value="{{ old('email', $bukutamu->email) }}"
                                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all" 
                                   placeholder="alamat@email.com">
                        </div>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="pesan_kesan">Pesan & Kesan <span class="text-red-500 dark:text-red-400">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-4 text-slate-400 dark:text-slate-500 text-xl">description</span>
                            <textarea name="pesan_kesan" id="pesan_kesan" rows="4" required
                                      class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all min-h-[120px]" 
                                      placeholder="Tuliskan pesan atau kesan kunjungan...">{{ old('pesan_kesan', $bukutamu->pesan_kesan) }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="status">Status Kunjungan</label>
                        <select name="status" id="status" required
                                class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm transition-all">
                            <option value="pending" {{ old('status', $bukutamu->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $bukutamu->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="completed" {{ old('status', $bukutamu->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="rejected" {{ old('status', $bukutamu->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-lavender/20 rounded-xl border border-primary/10 self-end">
                        <div class="flex items-center gap-2">
                            <input type="hidden" name="is_verified" value="0">
                            <input type="checkbox" name="is_verified" id="is_verified" value="1" 
                                   {{ old('is_verified', $bukutamu->is_verified) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-slate-300 dark:border-slate-500 text-primary focus:ring-primary/20">
                            <label for="is_verified" class="text-sm font-bold text-slate-700 dark:text-slate-300">Verifikasi Identitas</label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('admin.bukutamu.index') }}" 
                       class="w-full sm:w-auto px-8 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all active:scale-[0.98] text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary/30 transition-all active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
