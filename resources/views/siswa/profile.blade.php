@extends('layouts.siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end gap-6">
        <div class="relative group">
            <div class="w-32 h-32 rounded-3xl overflow-hidden border-4 border-white dark:border-slate-800 shadow-xl">
                @php
                    $fotoUrl = $siswa->foto_url;
                @endphp
                <img id="profilePhoto" src="{{ $fotoUrl }}" alt="Profile Picture" class="w-full h-full object-cover">
            </div>
            <button onclick="document.getElementById('photoInput').click()" class="absolute -bottom-2 -right-2 p-2 bg-primary text-white rounded-xl shadow-lg hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-sm">edit</span>
            </button>
            <input type="file" id="photoInput" accept="image/*" class="hidden">
        </div>
        
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ $siswa->nama_lengkap ?? 'Siswa' }}</h1>
            <div class="flex flex-wrap gap-3">
                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider">
                    TK PGRI Harapan Bangsa 1
                </span>
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-medium">
                    NIK: {{ $siswa->nik ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ 
        showPasswordModal: false, 
        loading: false, 
        errors: {},
        passwordForm: {
            current_password: '',
            new_password: '',
            new_password_confirmation: ''
        },
        resetForm() {
            this.passwordForm = { current_password: '', new_password: '', new_password_confirmation: '' };
            this.errors = {};
        },
        async submitPassword() {
            this.loading = true;
            this.errors = {};
            
            try {
                const response = await fetch('{{ route('siswa.profile.update-password') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.passwordForm)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#7f19e6'
                    });
                    this.showPasswordModal = false;
                    this.resetForm();
                } else {
                    if (response.status === 422 && data.errors) {
                        this.errors = data.errors;
                    } else {
                        Swal.fire('Error', data.message || 'Terjadi kesalahan', 'error');
                    }
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            } finally {
                this.loading = false;
            }
        }
    }">
        <!-- Personal Info -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <h3 class="text-lg font-bold">Informasi Pribadi</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Nama Lengkap</label>
                    <p class="font-medium">{{ $siswa->nama_lengkap ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Alamat Email</label>
                    <p class="font-medium text-slate-600 dark:text-slate-400">{{ $siswa->email ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Nomor WhatsApp</label>
                    <p class="font-medium">{{ $siswa->whatsapp ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">settings_account_box</span>
                </div>
                <h3 class="text-lg font-bold">Status Akun</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Bergabung Sejak</label>
                    <p class="font-medium">{{ $siswa->created_at->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Terakhir Update</label>
                    <p class="font-medium">{{ $siswa->updated_at->diffForHumans() }}</p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800">
                    @if($siswa->provider)
                        <div class="p-3 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800 flex items-center gap-3">
                            <span class="material-symbols-outlined text-amber-600">google</span>
                            <p class="text-xs text-amber-800 dark:text-amber-200">Akun terhubung dengan Google. Password dikelola secara eksternal.</p>
                        </div>
                    @else
                        <button 
                            @click="showPasswordModal = true"
                            class="w-full py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            Ganti Password
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Password Modal -->
        <template x-teleport="body">
            <div 
                x-show="showPasswordModal" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4" 
                x-cloak>
                
                <div 
                    @click.away="!loading && (showPasswordModal = false)"
                    class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 max-w-md w-full shadow-2xl border border-slate-100 dark:border-slate-800 relative overflow-hidden"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="scale-95 translate-y-4"
                    x-transition:enter-end="scale-100 translate-y-0"
                >
                    <!-- Background Decoration -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-primary/5 rounded-full blur-3xl"></div>
                    
                    <div class="flex justify-between items-center mb-6 relative">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined">lock_reset</span>
                            </div>
                            <h3 class="text-xl font-bold">Ganti Password</h3>
                        </div>
                        <button type="button" @click="showPasswordModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitPassword" class="space-y-4 relative">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 block">Password Saat Ini</label>
                            <input 
                                type="password" 
                                x-model="passwordForm.current_password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                placeholder="••••••••"
                                required
                            >
                            <p x-show="errors.current_password" x-text="errors.current_password?.[0]" class="mt-1 text-xs text-red-500 font-medium"></p>
                        </div>

                        <div class="pt-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 block">Password Baru</label>
                            <input 
                                type="password" 
                                x-model="passwordForm.new_password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                placeholder="Min. 8 karakter"
                                required
                            >
                            <p x-show="errors.new_password" x-text="errors.new_password?.[0]" class="mt-1 text-xs text-red-500 font-medium"></p>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 block">Konfirmasi Password Baru</label>
                            <input 
                                type="password" 
                                x-model="passwordForm.new_password_confirmation"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                placeholder="Ulangi password baru"
                                required
                            >
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button" 
                                @click="showPasswordModal = false" 
                                :disabled="loading"
                                class="flex-1 py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-200 transition-all disabled:opacity-50"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit" 
                                :disabled="loading"
                                class="flex-1 py-3.5 rounded-2xl bg-primary text-white font-bold hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 disabled:opacity-50"
                            >
                                <template x-if="!loading">
                                    <span>Simpan</span>
                                </template>
                                <template x-if="loading">
                                    <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                </template>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Cropper Modal -->
<div id="cropperModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 max-w-sm w-full mx-4 shadow-2xl border border-slate-100 dark:border-slate-800">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Sesuaikan Foto</h3>
            <button type="button" onclick="closeCropper()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="mb-4">
            <div class="relative w-full aspect-square bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden">
                <img id="cropperImage" src="" alt="Image to crop" class="max-w-full">
            </div>
        </div>
        
        <p class="text-xs text-slate-500 mb-6 text-center">Geser dan sesuaikan foto Anda agar pas.</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeCropper()" 
                    class="flex-1 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 transition-colors">
                Batal
            </button>
            <button type="button" onclick="cropAndUpload()" 
                    class="flex-1 py-3 rounded-2xl bg-primary text-white font-semibold hover:opacity-90 transition-opacity">
                Simpan
            </button>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let cropper;
let selectedFile;

document.getElementById('photoInput').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        selectedFile = e.target.files[0];
        
        if (!selectedFile.type.match('image.*')) {
            Swal.fire('Error', 'File harus berupa gambar', 'error');
            return;
        }
        
        if (selectedFile.size > 2 * 1024 * 1024) {
            Swal.fire('Error', 'Ukuran file maksimal 2MB', 'error');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('cropperImage').src = e.target.result;
            document.getElementById('cropperModal').classList.remove('hidden');
            document.getElementById('cropperModal').classList.add('flex');
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(document.getElementById('cropperImage'), {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                cropBoxMovable: false,
                cropBoxResizable: false,
                background: false,
            });
        };
        reader.readAsDataURL(selectedFile);
    }
});

function closeCropper() {
    document.getElementById('cropperModal').classList.add('hidden');
    document.getElementById('cropperModal').classList.remove('flex');
    if (cropper) {
        cropper.destroy();
    }
    document.getElementById('photoInput').value = '';
}

function cropAndUpload() {
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
    });
    
    canvas.toBlob(function(blob) {
        const formData = new FormData();
        formData.append('photo', blob, 'profile.jpg');
        formData.append('_token', '{{ csrf_token() }}');
        
        Swal.fire({
            title: 'Mengunggah...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('{{ route("siswa.profile.update-photo") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('profilePhoto').src = data.photo_url + '?t=' + new Date().getTime();
                Swal.fire('Sukses', data.message, 'success');
                closeCropper();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Terjadi kesalahan saat mengunggah foto', 'error');
        });
    }, 'image/jpeg', 0.9);
}
</script>
@endpush
@endsection
