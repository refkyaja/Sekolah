<!-- Card Total -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Guru</p>
            <p class="text-2xl font-semibold text-gray-900" id="stat-total">{{ $gurus->total() ?? 0 }}</p>
        </div>
    </div>
    <div class="mt-4 text-xs text-gray-500">
        <i class="fas fa-info-circle mr-1"></i> Semua guru & staff terdaftar
    </div>
</div>

<!-- Card Guru -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                <i class="fas fa-user-graduate text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Jumlah Guru</p>
            <p class="text-2xl font-semibold text-gray-900" id="stat-guru">
                {{ isset($gurus) ? $gurus->where('jabatan', 'guru')->count() : 0 }}
            </p>
        </div>
    </div>
    <div class="mt-4 text-xs text-gray-500">
        <i class="fas fa-info-circle mr-1"></i> Guru pengajar aktif
    </div>
</div>

<!-- Card Staff -->
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                <i class="fas fa-user-tie text-purple-600 text-xl"></i>
            </div>
        </div>
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Jumlah Staff</p>
            <p class="text-2xl font-semibold text-gray-900" id="stat-staff">
                {{ isset($gurus) ? $gurus->where('jabatan', 'staff')->count() : 0 }}
            </p>
        </div>
    </div>
    <div class="mt-4 text-xs text-gray-500">
        <i class="fas fa-info-circle mr-1"></i> Staff administrasi
    </div>
</div>