<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\SpmbController;
use App\Http\Controllers\BukuTamuController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\GuruAccountController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SpmbController as AdminSpmbController;
use App\Http\Controllers\Admin\SpmbSettingController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\BukuTamuController as AdminBukuTamuController;
use App\Http\Controllers\Admin\SpmbDokumenController;
use App\Http\Controllers\Admin\SpmbBuktiTransferController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\MateriKbmController;
use App\Http\Controllers\Admin\JadwalPelajaranController as AdminJadwalPelajaranController;

// ==================== ROUTES PUBLIK ====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/buku-tamu-home', [HomeController::class, 'storeBukuTamu'])->name('buku-tamu.home');
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [BeritaController::class, 'show'])->name('show');
});

Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/{slug}', [GaleriController::class, 'show'])->name('show');
});

Route::prefix('buku-tamu')->name('buku-tamu.')->group(function () {
    Route::get('/', [BukuTamuController::class, 'index'])->name('index');
    Route::post('/', [BukuTamuController::class, 'store'])->name('store');
    Route::get('/success', [BukuTamuController::class, 'success'])->name('success');
});

Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil.index');


Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/kurikulum', [App\Http\Controllers\KurikulumController::class, 'index'])->name('kurikulum');
    Route::get('/kegiatan', fn() => view('Home.akademik.kegiatan'))->name('kegiatan');
    Route::get('/prestasi', fn() => view('Home.akademik.prestasi'))->name('prestasi');
    Route::get('/ekstrakurikuler', fn() => view('Home.akademik.ekstrakurikuler'))->name('ekstrakurikuler');
    Route::get('/bahan-ajar', fn() => view('Home.akademik.bahan-ajar'))->name('bahan-ajar');
});

Route::prefix('sarana')->name('sarana.')->group(function () {
    Route::get('/infrastruktur', fn() => view('Home.sarana.infrastruktur'))->name('infrastruktur');
    Route::get('/pembelajaran', fn() => view('Home.sarana.pembelajaran'))->name('pembelajaran');
});

Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/buku-tamu', fn() => view('Home.buku-tamu.index'))->name('buku-tamu');
    Route::get('/kontak', fn() => view('Home.layanan.kontak'))->name('kontak');
});

Route::prefix('spmb')->name('spmb.')->group(function () {
    Route::get('/', [SpmbController::class, 'index'])->name('index');
    Route::get('/pendaftaran', [SpmbController::class, 'pendaftaran'])->name('pendaftaran');
    Route::post('/pendaftaran', [SpmbController::class, 'store'])->name('store');
    Route::get('/countdown', [SpmbController::class, 'countdown'])->name('countdown');
    Route::get('/pengumuman', [SpmbController::class, 'pengumuman'])->name('pengumuman');
    Route::post('/cek-pengumuman', [SpmbController::class, 'cekPengumuman'])->name('cekPengumuman');
    Route::get('/hasil-pengumuman', [SpmbController::class, 'hasilPengumuman'])->name('hasilPengumuman');
    Route::get('/success/{no_pendaftaran}', [SpmbController::class, 'success'])->name('success');
    Route::get('/informasi', fn() => view('Home.spmb.informasi'))->name('informasi');
    Route::get('/jadwal', fn() => view('Home.spmb.jadwal'))->name('jadwal');
    Route::get('/syarat', fn() => view('Home.spmb.syarat'))->name('syarat');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ==================== ROUTES ADMIN (HANYA ADMIN) ====================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('index');
        Route::put('/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update');
        Route::post('/update-photo', [App\Http\Controllers\Admin\ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::put('/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('change-password');
    });

    // Pastikan ini di dalam Route::prefix('admin')->name('admin.')->group(function () { ... })
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::prefix('siswa-aktif')->name('siswa-aktif.')->group(function () {
            Route::get('/', [SiswaController::class, 'indexAktif'])->name('index');
            Route::get('/create', [SiswaController::class, 'createAktif'])->name('create');
            Route::post('/', [SiswaController::class, 'storeAktif'])->name('store');
            Route::get('/{siswa}', [SiswaController::class, 'showAktif'])->name('show');
            Route::get('/{siswa}/edit', [SiswaController::class, 'editAktif'])->name('edit');
            Route::put('/{siswa}', [SiswaController::class, 'updateAktif'])->name('update');
            Route::delete('/{siswa}', [SiswaController::class, 'destroyAktif'])->name('destroy');
            Route::patch('/{siswa}/update-status', [SiswaController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/bulk-delete', [SiswaController::class, 'bulkDelete'])->name('bulk-delete');
            Route::post('/bulk-update', [SiswaController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
        });

        Route::prefix('siswa-lulus')->name('siswa-lulus.')->group(function () {
            Route::get('/', [SiswaController::class, 'rekapLulus'])->name('index');
            Route::get('/export', [SiswaController::class, 'exportRekapLulus'])->name('export');
            Route::get('/tahun/{tahun}', [SiswaController::class, 'siswaByTahunLulus'])->name('by-tahun')->where('tahun', '.*');
            Route::get('/{siswa}', [SiswaController::class, 'showLulus'])->name('show');
        });

        Route::get('/export', [SiswaController::class, 'export'])->name('export');
    });

    Route::resource('guru', GuruController::class);
    
    // Kelola Akun Guru
    Route::prefix('guru-accounts')->name('guru-accounts.')->group(function () {
        Route::post('/bulk-delete', [GuruAccountController::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-generate', [GuruAccountController::class, 'bulkGenerateAccounts'])->name('bulk-generate');
        Route::get('/export', [GuruAccountController::class, 'export'])->name('export');
        Route::get('/create', [GuruAccountController::class, 'create'])->name('create');
        Route::get('/', [GuruAccountController::class, 'index'])->name('index');
        Route::post('/', [GuruAccountController::class, 'store'])->name('store');
        Route::get('/{user}', [GuruAccountController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [GuruAccountController::class, 'edit'])->name('edit');
        Route::put('/{user}', [GuruAccountController::class, 'update'])->name('update');
        Route::delete('/{user}', [GuruAccountController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/reset-password', [GuruAccountController::class, 'resetPassword'])->name('reset-password');
        Route::post('/{user}/generate', [GuruAccountController::class, 'generateAccount'])->name('generate');
    });
    
    // Absensi
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');
        Route::get('/export', [AbsensiController::class, 'export'])->name('export');
        Route::post('/bulk-delete', [AbsensiController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{id}/edit', [AbsensiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AbsensiController::class, 'update'])->name('update');
        Route::delete('/{id}', [AbsensiController::class, 'destroy'])->name('destroy');
        Route::get('/fill', [AbsensiController::class, 'fill'])->name('fill');
        Route::post('/store-batch', [AbsensiController::class, 'storeBatch'])->name('store-batch');
    });

    Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
        Route::get('/', [TahunAjaranController::class, 'index'])->name('index');
        Route::get('/create', [TahunAjaranController::class, 'create'])->name('create');
        Route::post('/', [TahunAjaranController::class, 'store'])->name('store');
        Route::get('/{tahunAjaran}/edit', [TahunAjaranController::class, 'edit'])->name('edit');
        Route::put('/{tahunAjaran}', [TahunAjaranController::class, 'update'])->name('update');
        Route::put('/{tahunAjaran}/set-active', [TahunAjaranController::class, 'setActive'])->name('set-active');
        Route::delete('/{tahunAjaran}', [TahunAjaranController::class, 'destroy'])->name('destroy');
    });
    
    // SPMB Admin
    Route::prefix('spmb')->name('spmb.')->group(function () {
        // ✅ ROUTE TANPA PARAMETER (DI ATAS SEMUA)
        Route::get('/dashboard', [AdminSpmbController::class, 'dashboard'])->name('dashboard');
        Route::get('/export', [AdminSpmbController::class, 'export'])->name('export');
        Route::post('/export-selected', [AdminSpmbController::class, 'exportSelected'])->name('exportSelected');
        Route::post('/batch-action', [AdminSpmbController::class, 'batchAction'])->name('batchAction');
        Route::get('/create', [AdminSpmbController::class, 'create'])->name('create');
        Route::post('/', [AdminSpmbController::class, 'store'])->name('store');
        Route::get('/pengaturan', [AdminSpmbController::class, 'pengaturan'])->name('pengaturan');
        Route::post('/pengaturan', [AdminSpmbController::class, 'updatePengaturan'])->name('updatePengaturan');
        
        // ✅ ROUTE PEMBAGIAN KELAS
        Route::get('/class-division-preview', [AdminSpmbController::class, 'classDivisionPreview'])->name('classDivisionPreview');
        Route::post('/execute-class-division', [AdminSpmbController::class, 'executeClassDivision'])->name('executeClassDivision');
        
        // ✅ ROUTE INDEX (HARUS SETELAH ROUTE TANPA PARAMETER)
        Route::get('/', [AdminSpmbController::class, 'index'])->name('index');
        
        // ✅ ROUTE DENGAN PARAMETER {spmb}
        Route::get('/{spmb}', [AdminSpmbController::class, 'show'])->name('show');
        Route::get('/{spmb}/edit', [AdminSpmbController::class, 'edit'])->name('edit');
        Route::put('/{spmb}', [AdminSpmbController::class, 'update'])->name('update');
        Route::delete('/{spmb}', [AdminSpmbController::class, 'destroy'])->name('destroy');
        Route::put('/{spmb}/status', [AdminSpmbController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{spmb}/verifikasi-dokumen', [AdminSpmbController::class, 'verifikasiDokumen'])->name('verifikasiDokumen');
        Route::post('/{spmb}/approve-kepsek', [AdminSpmbController::class, 'approveKepsek'])->name('approveKepsek');
        Route::post('/{spmb}/assign-kelas', [AdminSpmbController::class, 'assignKelas'])->name('assignKelas');
        Route::post('/{spmb}/konversi', [AdminSpmbController::class, 'konversiKeSiswa'])->name('konversiKeSiswa');
        Route::put('/{spmb}/update-all', [AdminSpmbController::class, 'updateAll'])->name('updateAll');

        // ✅ ROUTE DOKUMEN (PREFIX BARU, TANPA 'spmb' LAGI)
        Route::prefix('{spmb}/dokumen')->name('dokumen.')->group(function () {
            Route::get('/', [SpmbDokumenController::class, 'index'])->name('index');
            Route::post('/', [SpmbDokumenController::class, 'store'])->name('store');
            Route::delete('{dokumen}', [SpmbDokumenController::class, 'destroy'])->name('destroy');
            Route::get('{dokumen}/download', [SpmbDokumenController::class, 'download'])->name('download');
        });
        
        // ✅ ROUTE BUKTI TRANSFER (TANPA NESTED PREFIX BERLEBIH)
        Route::prefix('bukti-transfer')->name('bukti-transfer.')->group(function () {
            Route::get('/', [SpmbBuktiTransferController::class, 'index'])->name('index');
            Route::get('{buktiTransfer}', [SpmbBuktiTransferController::class, 'show'])->name('show');
            Route::post('{buktiTransfer}/verifikasi', [SpmbBuktiTransferController::class, 'verifikasi'])->name('verifikasi');
            Route::post('{buktiTransfer}/tolak', [SpmbBuktiTransferController::class, 'tolak'])->name('tolak');
            Route::get('{buktiTransfer}/download', [SpmbBuktiTransferController::class, 'download'])->name('download');
            Route::delete('{buktiTransfer}', [SpmbBuktiTransferController::class, 'destroy'])->name('destroy');
        });
        
        // ✅ ROUTE UPLOAD BUKTI TRANSFER DARI HALAMAN DETAIL
        Route::post('{spmb}/upload-bukti-transfer', [SpmbBuktiTransferController::class, 'store'])->name('upload-bukti-transfer');
    });

    // SPMB Settings
    Route::prefix('spmb-settings')->name('spmb-settings.')->group(function () {
        Route::get('/', [SpmbSettingController::class, 'edit'])->name('index');
        Route::get('/pendaftaran', [SpmbSettingController::class, 'pendaftaran'])->name('pendaftaran');
        Route::put('/pendaftaran/update', [SpmbSettingController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::get('/pengumuman', [SpmbSettingController::class, 'pengumuman'])->name('pengumuman');
        Route::put('/pengumuman/update', [SpmbSettingController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::get('/sistem', [SpmbSettingController::class, 'sistem'])->name('sistem');
        Route::post('/sistem/update', [SpmbSettingController::class, 'updateSistem'])->name('sistem.update');
        Route::post('/publish', [SpmbSettingController::class, 'publish'])->name('publish');
        Route::post('/unpublish', [SpmbSettingController::class, 'unpublish'])->name('unpublish');
    });

    // Berita Management
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [AdminBeritaController::class, 'index'])->name('index');
        Route::get('/create', [AdminBeritaController::class, 'create'])->name('create');
        Route::post('/', [AdminBeritaController::class, 'store'])->name('store');
        Route::get('/{berita}', [AdminBeritaController::class, 'show'])->name('show');
        Route::get('/{berita}/edit', [AdminBeritaController::class, 'edit'])->name('edit');
        Route::put('/{berita}', [AdminBeritaController::class, 'update'])->name('update');
        Route::delete('/{berita}', [AdminBeritaController::class, 'destroy'])->name('destroy');
        Route::get('/{berita}/publish', [AdminBeritaController::class, 'publish'])->name('publish');
        Route::get('/{berita}/unpublish', [AdminBeritaController::class, 'unpublish'])->name('unpublish');
        Route::post('/bulk-delete', [AdminBeritaController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/export', [AdminBeritaController::class, 'export'])->name('export');
        Route::get('/cari', [AdminBeritaController::class, 'cari'])->name('cari');
    });
    
    // Galeri Management
    Route::resource('galeri', AdminGaleriController::class);
    Route::patch('galeri/{galeri}/toggle-publish', [AdminGaleriController::class, 'togglePublish'])->name('galeri.toggle-publish');
    Route::post('galeri/bulk-delete', [AdminGaleriController::class, 'bulkDelete'])->name('galeri.bulk-delete');
    Route::delete('galeri/gambar/{id}', [AdminGaleriController::class, 'destroyGambar'])->name('galeri.gambar.destroy');
    Route::post('galeri/{galeri}/update-urutan', [AdminGaleriController::class, 'updateUrutan'])->name('galeri.update-urutan');

    // Buku Tamu Management
    Route::resource('bukutamu', AdminBukuTamuController::class);
    Route::post('bukutamu/{bukutamu}/verify', [AdminBukuTamuController::class, 'verify'])->name('bukutamu.verify');
    Route::get('bukutamu/export', [AdminBukuTamuController::class, 'export'])->name('bukutamu.export');
    
    // Materi KBM
    Route::prefix('materi-kbm')->name('materi-kbm.')->group(function () {
        Route::get('/', [MateriKbmController::class, 'index'])->name('index');
        Route::get('/create', [MateriKbmController::class, 'create'])->name('create');
        Route::post('/', [MateriKbmController::class, 'store'])->name('store');
        Route::get('/{materiKbm}', [MateriKbmController::class, 'show'])->name('show');
        Route::get('/{materiKbm}/edit', [MateriKbmController::class, 'edit'])->name('edit');
        Route::put('/{materiKbm}', [MateriKbmController::class, 'update'])->name('update');
        Route::delete('/{materiKbm}', [MateriKbmController::class, 'destroy'])->name('destroy');
        Route::get('/{materiKbm}/download', [MateriKbmController::class, 'download'])->name('download');
    });

    // Kalender Akademik
    Route::resource('kalender-akademik', \App\Http\Controllers\Admin\KalenderAkademikController::class);

    // Jadwal Pelajaran
    Route::resource('jadwal-pelajaran', AdminJadwalPelajaranController::class);

    // Widgets
    Route::get('/widgets/spmb-statistics', [DashboardController::class, 'getSpmbStatistics'])->name('widgets.spmb-statistics');
    Route::get('/widgets/bukutamu-statistics', [DashboardController::class, 'getBukuTamuStatistics'])->name('widgets.bukutamu-statistics');

    Route::resource('accounts', App\Http\Controllers\Admin\AccountController::class);
    Route::patch('accounts/{account}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])->name('accounts.toggle-status');
    Route::post('accounts/{account}/reset-password', [App\Http\Controllers\Admin\AccountController::class, 'resetPassword'])->name('accounts.reset-password');
    Route::post('accounts/bulk-action', [App\Http\Controllers\Admin\AccountController::class, 'bulkAction'])->name('accounts.bulk-action');
}); // <--- PENUTUP GROUP ADMIN PINDAH KE SINI

// ==================== ROUTES GURU ====================

Route::prefix('guru')->name('guru.')->middleware(['auth', 'verified', 'guru'])->group(function () {
    Route::get('/dashboard', fn() => view('guru.dashboard'))->name('dashboard');
    Route::get('/absensi', fn() => view('guru.absensi.index'))->name('absensi.index');
    Route::get('/profile', fn() => view('guru.profile'))->name('profile');
});

// ==================== ROUTES SISWA ====================

Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Siswa\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Siswa\AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [\App\Http\Controllers\Siswa\AuthController::class, 'register'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Siswa\AuthController::class, 'storeRegister'])->name('storeRegister');
    Route::post('/logout', [\App\Http\Controllers\Siswa\AuthController::class, 'logout'])->name('logout');
    
    // Google Auth Routes
    Route::get('/login/google', [\App\Http\Controllers\Siswa\AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [\App\Http\Controllers\Siswa\AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');

    Route::middleware(['auth:siswa'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [\App\Http\Controllers\Siswa\JadwalPelajaranController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/download-pdf', [\App\Http\Controllers\Siswa\JadwalPelajaranController::class, 'downloadPdf'])->name('jadwal.download-pdf');
        Route::get('/kalender', [\App\Http\Controllers\Siswa\KalenderAkademikController::class, 'index'])->name('kalender.index');
        Route::get('/kalender/download-pdf', [\App\Http\Controllers\Siswa\KalenderAkademikController::class, 'downloadPdf'])->name('kalender.download-pdf');
        Route::get('/materi', [\App\Http\Controllers\Siswa\MateriKbmController::class, 'index'])->name('materi.index');
        Route::get('/materi/{materiKbm}/download', [\App\Http\Controllers\Siswa\MateriKbmController::class, 'download'])->name('materi.download');
    });
});

// ==================== AUTH & API ====================

require __DIR__.'/auth.php';

Route::prefix('api')->name('api.')->group(function () {
    Route::prefix('spmb')->name('spmb.')->group(function () {
        Route::get('/status', [SpmbController::class, 'getStatus'])->name('status');
        Route::post('/validate-nik', [SpmbController::class, 'validateNik'])->name('validateNik');
    });

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
        Route::prefix('bukutamu')->name('bukutamu.')->group(function () {
            Route::get('/statistics', [AdminBukuTamuController::class, 'getStatistics'])->name('statistics');
        });
    });
});

Route::fallback(function () {
    return response('<h1>404 - Halaman Tidak Ditemukan</h1>', 404);
});