@extends('layouts.operator')

@section('title', 'Profil Saya')
@section('breadcrumb', 'Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-6">Profil Saya</h2>
        
        <div class="flex items-start gap-6">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
                <div class="relative">
                    @if($user->foto)
                    <img src="{{ Storage::url($user->foto) }}" 
                         alt="{{ $user->name }}" 
                         class="w-24 h-24 rounded-2xl object-cover shadow-sm ring-4 ring-red-100 dark:ring-red-900/30">
                    @else
                    <div class="w-24 h-24 rounded-2xl bg-red-600 flex items-center justify-center text-3xl font-bold text-white shadow-sm ring-4 ring-red-100 dark:ring-red-900/30">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    @endif
                    
                    <!-- Upload Photo Button -->
                    <form action="{{ route('operator.profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="absolute -bottom-2 -right-2">
                        @csrf
                        <label for="foto" class="block w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-red-700 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-sm">camera_alt</span>
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*" onchange="this.form.submit()">
                    </form>
                </div>
            </div>
            
            <!-- Basic Info -->
            <div class="flex-1">
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ $user->name }}</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-4">{{ $user->email }}</p>
                
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-semibold rounded-full">
                        Operator
                    </span>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                        {{ $user->jenis_kelamin }}
                    </span>
                    @if($user->no_telepon)
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                        {{ $user->no_telepon }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-6">Edit Profil</h3>
        
        <form action="{{ route('operator.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Nama Lengkap
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                           required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                           required>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- No Telepon -->
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        No. Telepon
                    </label>
                    <input type="tel" 
                           id="no_telepon" 
                           name="no_telepon" 
                           value="{{ old('no_telepon', $user->no_telepon) }}" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors">
                    @error('no_telepon')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Jenis Kelamin
                    </label>
                    <select id="jenis_kelamin" 
                            name="jenis_kelamin" 
                            class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                            required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Alamat -->
            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    Alamat
                </label>
                <textarea id="alamat" 
                          name="alamat" 
                          rows="3" 
                          class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <!-- Change Password -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-100 dark:border-slate-700">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-6">Ubah Password</h3>
        
        <form action="{{ route('operator.profile.change-password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Password Saat Ini
                    </label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                           required>
                    @error('current_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Password Baru
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                           required>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Konfirmasi Password
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white transition-colors"
                           required>
                    @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
