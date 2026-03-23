<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KegiatanController as PublicKegiatanController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\DashboardController as BaseDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\GuruAccountController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\AbsensiGuruController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SpmbController as AdminSpmbController;
use App\Http\Controllers\Admin\SpmbSettingController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\BukuTamuController as AdminBukuTamuController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\MateriKbmController;
use App\Http\Controllers\Admin\JadwalPelajaranController as AdminJadwalPelajaranController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\KalenderAkademikController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum');
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::post('/ppdb', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [BeritaController::class, 'show'])->name('show');
});

Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/{slug}', [GaleriController::class, 'show'])->name('show');
});

Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
    Route::get('/', [PublicKegiatanController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicKegiatanController::class, 'show'])->name('show');
});

// Buku Tamu Routes
Route::prefix('buku-tamu')->name('buku-tamu.')->group(function () {
    Route::get('/', [BukuTamuController::class, 'index'])->name('index');
    Route::post('/', [HomeController::class, 'storeBukuTamu'])->name('store');
    Route::get('/success', [BukuTamuController::class, 'success'])->name('success');
});

// ==================== ROUTES ADMIN (HANYA ADMIN) ====================

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'active', 'admin'])->group(function () {
    
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('index');
        Route::get('/settings', [App\Http\Controllers\Admin\ProfileController::class, 'settings'])->name('settings');
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
    
    // Kelola Akun Guru - Commented out, controller doesn't exist
    // Route::prefix('guru-accounts')->name('guru-accounts.')->group(function () {
    //     Route::post('/bulk-delete', [GuruAccountController::class, 'bulkDelete'])->name('bulk-delete');
    //     Route::post('/bulk-generate', [GuruAccountController::class, 'bulkGenerateAccounts'])->name('bulk-generate');
    //     Route::get('/export', [GuruAccountController::class, 'export'])->name('export');
    //     Route::get('/create', [GuruAccountController::class, 'create'])->name('create');
    //     Route::get('/', [GuruAccountController::class, 'index'])->name('index');
    //     Route::post('/', [GuruAccountController::class, 'store'])->name('store');
    //     Route::get('/{user}', [GuruAccountController::class, 'show'])->name('show');
    //     Route::get('/{user}/edit', [GuruAccountController::class, 'edit'])->name('edit');
    //     Route::put('/{user}', [GuruAccountController::class, 'update'])->name('update');
    //     Route::delete('/{user}', [GuruAccountController::class, 'destroy'])->name('destroy');
    //     Route::post('/{user}/reset-password', [GuruAccountController::class, 'resetPassword'])->name('reset-password');
    //     Route::post('/{user}/generate', [GuruAccountController::class, 'generateAccount'])->name('generate');
    // });
    
    // Absensi
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::get('/rekap', [AbsensiController::class, 'rekap'])->name('rekap');
        Route::get('/export', [AbsensiController::class, 'export'])->name('export');
        Route::post('/bulk-delete', [AbsensiController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/{id}/edit', [AbsensiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AbsensiController::class, 'update'])->name('update');
        Route::delete('/{id}', [AbsensiController::class, 'destroy'])->name('destroy');
        Route::get('/detail', [AbsensiController::class, 'detail'])->name('detail');
        Route::get('/fill', [AbsensiController::class, 'fill'])->name('fill');
        Route::post('/store-batch', [AbsensiController::class, 'storeBatch'])->name('store-batch');
    });

    // Absensi Guru
    Route::prefix('absensi-guru')->name('absensi-guru.')->group(function () {
        Route::get('/', [AbsensiGuruController::class, 'index'])->name('index');
        Route::get('/rekap', [AbsensiGuruController::class, 'rekap'])->name('rekap');
        Route::get('/rekap/export', [AbsensiGuruController::class, 'rekapExport'])->name('rekap.export');
        Route::get('/fill', [AbsensiGuruController::class, 'fill'])->name('fill');
        Route::post('/store-batch', [AbsensiGuruController::class, 'storeBatch'])->name('store-batch');
        Route::get('/detail', [AbsensiGuruController::class, 'detail'])->name('detail');
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
        Route::get('/export', [AdminSpmbController::class, 'exportIndex'])->name('export');
        Route::get('/export/data', [AdminSpmbController::class, 'export'])->name('exportData');
        Route::get('/export/all', [AdminSpmbController::class, 'exportAll'])->name('exportAll');
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
        Route::patch('/{spmb}/update-status', [AdminSpmbController::class, 'updateStatus'])->name('updateStatusPatch');
        Route::post('/{spmb}/catatan', [AdminSpmbController::class, 'tambahCatatan'])->name('catatan');
        Route::post('/{spmb}/verifikasi-dokumen', [AdminSpmbController::class, 'verifikasiDokumen'])->name('verifikasiDokumen');
        Route::post('/{spmb}/approve-kepsek', [AdminSpmbController::class, 'approveKepsek'])->name('approveKepsek');
        Route::post('/{spmb}/assign-kelas', [AdminSpmbController::class, 'assignKelas'])->name('assignKelas');
        Route::post('/{spmb}/konversi', [AdminSpmbController::class, 'konversiKeSiswa'])->name('konversiKeSiswa');
        Route::put('/{spmb}/update-all', [AdminSpmbController::class, 'updateAll'])->name('updateAll');

        // Bulk Actions
        Route::post('/bulk-lulus', [AdminSpmbController::class, 'bulkLulus'])->name('bulk.lulus');
        Route::post('/bulk-delete', [AdminSpmbController::class, 'bulkDelete'])->name('bulk.delete');

        // ✅ ROUTE DOKUMEN (PREFIX BARU, TANPA 'spmb' LAGI) - DISABLED
        // Route::prefix('{spmb}/dokumen')->name('dokumen.')->group(function () {
        //     Route::get('/', [SpmbDokumenController::class, 'index'])->name('index');
        //     Route::post('/', [SpmbDokumenController::class, 'store'])->name('store');
        //     Route::delete('{dokumen}', [SpmbDokumenController::class, 'destroy'])->name('destroy');
        //     Route::get('{dokumen}/download', [SpmbDokumenController::class, 'download'])->name('download');
        // });
        
        // ✅ ROUTE BUKTI TRANSFER (TANPA NESTED PREFIX BERLEBIH) - DISABLED
        // Route::prefix('bukti-transfer')->name('bukti-transfer.')->group(function () {
        //     Route::get('/', [SpmbBuktiTransferController::class, 'index'])->name('index');
        //     Route::get('{buktiTransfer}', [SpmbBuktiTransferController::class, 'show'])->name('show');
        //     Route::post('{buktiTransfer}/verifikasi', [SpmbBuktiTransferController::class, 'verifikasi'])->name('verifikasi');
        //     Route::post('{buktiTransfer}/tolak', [SpmbBuktiTransferController::class, 'tolak'])->name('tolak');
        //     Route::get('{buktiTransfer}/download', [SpmbBuktiTransferController::class, 'download'])->name('download');
        //     Route::delete('{buktiTransfer}', [SpmbBuktiTransferController::class, 'destroy'])->name('destroy');
        // });
        
        // ✅ ROUTE UPLOAD BUKTI TRANSFER DARI HALAMAN DETAIL - DISABLED
        // Route::post('{spmb}/upload-bukti-transfer', [SpmbBuktiTransferController::class, 'store'])->name('upload-bukti-transfer');
    });

    // SPMB Settings
    Route::prefix('spmb-settings')->name('spmb-settings.')->group(function () {
        Route::get('/', [SpmbSettingController::class, 'edit'])->name('index');
        Route::put('/', [SpmbSettingController::class, 'update'])->name('update');
        Route::get('/pendaftaran', [SpmbSettingController::class, 'pendaftaran'])->name('pendaftaran');
        Route::put('/pendaftaran/update', [SpmbSettingController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::get('/pengumuman', [SpmbSettingController::class, 'pengumuman'])->name('pengumuman');
        Route::put('/pengumuman/update', [SpmbSettingController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::get('/sistem', [SpmbSettingController::class, 'sistem'])->name('sistem');
        Route::post('/sistem/update', [SpmbSettingController::class, 'updateSistem'])->name('sistem.update');
        Route::post('/publish', [SpmbSettingController::class, 'publish'])->name('publish');
        Route::post('/unpublish', [SpmbSettingController::class, 'unpublish'])->name('unpublish');
    });

    // PPDB Routes (Alias for SPMB)
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/dashboard', [AdminSpmbController::class, 'dashboard'])->name('dashboard');
        Route::get('/export', [AdminSpmbController::class, 'export'])->name('export');
        Route::post('/export-selected', [AdminSpmbController::class, 'exportSelected'])->name('exportSelected');
        Route::post('/batch-action', [AdminSpmbController::class, 'batchAction'])->name('batchAction');
        Route::get('/create', [AdminSpmbController::class, 'create'])->name('create');
        Route::post('/', [AdminSpmbController::class, 'store'])->name('store');
        Route::get('/pengaturan', [AdminSpmbController::class, 'pengaturan'])->name('pengaturan');
        Route::post('/pengaturan', [AdminSpmbController::class, 'updatePengaturan'])->name('updatePengaturan');
        Route::get('/pengumuman', [AdminSpmbController::class, 'pengumuman'])->name('pengumuman');
        Route::post('/pengumuman/publish', [AdminSpmbController::class, 'publishPengumuman'])->name('pengumuman.publish');
        Route::get('/riwayat', [AdminSpmbController::class, 'riwayat'])->name('riwayat');
        Route::get('/riwayat/{tahunAjaran}', [AdminSpmbController::class, 'riwayatShow'])->name('riwayat.show')->where('tahunAjaran', '.*');
        Route::get('/', [AdminSpmbController::class, 'index'])->name('index');
        Route::get('/{spmb}', [AdminSpmbController::class, 'show'])->name('show');
        Route::get('/{spmb}/edit', [AdminSpmbController::class, 'edit'])->name('edit');
        Route::put('/{spmb}', [AdminSpmbController::class, 'update'])->name('update');
        Route::delete('/{spmb}', [AdminSpmbController::class, 'destroy'])->name('destroy');
        Route::put('/{spmb}/status', [AdminSpmbController::class, 'updateStatus'])->name('updateStatus');
        Route::patch('/{spmb}/update-status', [AdminSpmbController::class, 'updateStatus'])->name('updateStatusPatch');
        Route::post('/{spmb}/catatan', [AdminSpmbController::class, 'tambahCatatan'])->name('catatan');
        Route::post('/{spmb}/verifikasi-dokumen', [AdminSpmbController::class, 'verifikasiDokumen'])->name('verifikasiDokumen');
        Route::post('/{spmb}/approve-kepsek', [AdminSpmbController::class, 'approveKepsek'])->name('approveKepsek');
        Route::post('/{spmb}/assign-kelas', [AdminSpmbController::class, 'assignKelas'])->name('assignKelas');
        Route::post('/{spmb}/konversi', [AdminSpmbController::class, 'konversiKeSiswa'])->name('konversiKeSiswa');
        Route::put('/{spmb}/update-all', [AdminSpmbController::class, 'updateAll'])->name('updateAll');
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
    
    // Kegiatan Sekolah
    Route::resource('kegiatan', App\Http\Controllers\Admin\KegiatanController::class);
    Route::patch('kegiatan/{kegiatan}/toggle-publish', [App\Http\Controllers\Admin\KegiatanController::class, 'togglePublish'])->name('kegiatan.toggle-publish');

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
    // Activity Log
    Route::resource('activity-log', ActivityLogController::class)->only(['index', 'destroy']);

    // Widgets
    Route::get('/widgets/spmb-statistics', [AdminDashboardController::class, 'getSpmbStatistics'])->name('widgets.spmb-statistics');
    Route::get('/widgets/bukutamu-statistics', [AdminDashboardController::class, 'getBukuTamuStatistics'])->name('widgets.bukutamu-statistics');
    Route::get('/widgets/recent-registrations', [AdminDashboardController::class, 'getRecentRegistrations'])->name('widgets.recent-registrations');
    Route::get('/widgets/spmb-statistics-year/{year?}', [AdminDashboardController::class, 'getSpmbStatisticsByYear'])->name('widgets.spmb-statistics-year');
    Route::get('/widgets/recent-konversi', [AdminDashboardController::class, 'getRecentKonversi'])->name('widgets.recent-konversi');
    
    // Cache Management
    Route::post('/dashboard/clear-cache', [AdminDashboardController::class, 'clearDashboardCache'])->name('dashboard.clear-cache');

    Route::resource('accounts', App\Http\Controllers\Admin\AccountController::class);
    Route::patch('accounts/{account}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])->name('accounts.toggle-status');
    Route::post('accounts/{account}/reset-password', [App\Http\Controllers\Admin\AccountController::class, 'resetPassword'])->name('accounts.reset-password');
    Route::post('accounts/bulk-action', [App\Http\Controllers\Admin\AccountController::class, 'bulkAction'])->name('accounts.bulk-action');
}); // <--- PENUTUP GROUP ADMIN PINDAH KE SINI

// ==================== ROUTES OPERATOR ====================

Route::prefix('operator')->name('operator.')->middleware(['auth', 'verified', 'active', 'operator'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Operator\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Operator\ProfileController::class, 'index'])->name('index');
        Route::get('/settings', [App\Http\Controllers\Operator\ProfileController::class, 'settings'])->name('settings');
        Route::put('/update', [App\Http\Controllers\Operator\ProfileController::class, 'update'])->name('update');
        Route::post('/update-photo', [App\Http\Controllers\Operator\ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::put('/change-password', [App\Http\Controllers\Operator\ProfileController::class, 'changePassword'])->name('change-password');
    });
    
    // Siswa Routes (Read-only)
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/siswa-aktif', [App\Http\Controllers\Admin\SiswaController::class, 'indexAktif'])->name('siswa-aktif.index');
        Route::get('/siswa-aktif/{siswa}', [App\Http\Controllers\Admin\SiswaController::class, 'showAktif'])->name('siswa-aktif.show');
    });
    
    // Tahun Ajaran Routes (Read-only)
    Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TahunAjaranController::class, 'index'])->name('index');
        Route::get('/{tahunAjaran}', [App\Http\Controllers\Admin\TahunAjaranController::class, 'show'])->name('show');
    });
    
    // Absensi Routes (Read-only)
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AbsensiController::class, 'edit'])->name('edit');
    });
    
    // Absensi Guru Routes (Read-only)
    Route::prefix('absensi-guru')->name('absensi-guru.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AbsensiGuruController::class, 'index'])->name('index');
    });
    
    // Materi KBM Routes (Read-only)
    Route::prefix('materi-kbm')->name('materi-kbm.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MateriKbmController::class, 'index'])->name('index');
        Route::get('/{materiKbm}', [App\Http\Controllers\Admin\MateriKbmController::class, 'show'])->name('show');
    });
    
    // Kalender Akademik Routes (Read-only)
    Route::prefix('kalender-akademik')->name('kalender-akademik.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'index'])->name('index');
        Route::get('/{kalenderAkademik}', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'show'])->name('show');
    });
    
    // Jadwal Pelajaran Routes (Read-only)
    Route::prefix('jadwal-pelajaran')->name('jadwal-pelajaran.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'index'])->name('index');
        Route::get('/{jadwalPelajaran}', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'show'])->name('show');
    });
    
    // PPDB Routes (Read-only)
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SpmbController::class, 'index'])->name('index');
        Route::get('/{spmb}', [App\Http\Controllers\Admin\SpmbController::class, 'show'])->name('show');
        Route::get('/pengaturan', [App\Http\Controllers\Admin\SpmbController::class, 'pengaturan'])->name('pengaturan');
        Route::get('/riwayat', [App\Http\Controllers\Admin\SpmbController::class, 'riwayat'])->name('riwayat');
        Route::get('/export', [App\Http\Controllers\Admin\SpmbController::class, 'export'])->name('export');
    });
    
    // Galeri Routes (Read-only)
    Route::prefix('galeri')->name('galeri.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('index');
        Route::get('/{galeri}', [App\Http\Controllers\Admin\GaleriController::class, 'show'])->name('show');
    });
    
    // Kegiatan Routes (Read-only)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KegiatanController::class, 'index'])->name('index');
        Route::get('/{kegiatan}', [App\Http\Controllers\Admin\KegiatanController::class, 'show'])->name('show');
    });
    
    // Buku Tamu Routes (Read-only)
    Route::prefix('bukutamu')->name('bukutamu.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BukuTamuController::class, 'index'])->name('index');
        Route::get('/{bukutamu}', [App\Http\Controllers\Admin\BukuTamuController::class, 'show'])->name('show');
    });
    
    // API Routes for AJAX
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/spmb-statistics', [App\Http\Controllers\Operator\DashboardController::class, 'getSpmbStatistics'])->name('spmb-statistics');
        Route::get('/recent-registrations', [App\Http\Controllers\Operator\DashboardController::class, 'getRecentRegistrations'])->name('recent-registrations');
    });
});

// ==================== ROUTES KEPALA SEKOLAH ====================

Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->middleware(['auth', 'verified', 'active', 'kepala_sekolah'])->group(function () {
    Route::get('/dashboard', fn() => view('kepala-sekolah.dashboard'))->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\KepalaSekolah\ProfileController::class, 'index'])->name('index');
        Route::get('/settings', [App\Http\Controllers\KepalaSekolah\ProfileController::class, 'settings'])->name('settings');
        Route::put('/update', [App\Http\Controllers\KepalaSekolah\ProfileController::class, 'update'])->name('update');
        Route::post('/update-photo', [App\Http\Controllers\KepalaSekolah\ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::put('/change-password', [App\Http\Controllers\KepalaSekolah\ProfileController::class, 'changePassword'])->name('change-password');
    });
    
    // Siswa Routes (Read-only)
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/siswa-aktif', [App\Http\Controllers\Admin\SiswaController::class, 'indexAktif'])->name('siswa-aktif.index');
        Route::get('/siswa-aktif/{siswa}', [App\Http\Controllers\Admin\SiswaController::class, 'showAktif'])->name('siswa-aktif.show');
    });
    
    // Guru Routes (Read-only)
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GuruController::class, 'index'])->name('index');
        Route::get('/{guru}', [App\Http\Controllers\Admin\GuruController::class, 'show'])->name('show');
    });
    
    // Tahun Ajaran Routes (Read-only)
    Route::prefix('tahun-ajaran')->name('tahun-ajaran.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TahunAjaranController::class, 'index'])->name('index');
        Route::get('/{tahunAjaran}', [App\Http\Controllers\Admin\TahunAjaranController::class, 'show'])->name('show');
    });
    
    // Absensi Routes (Read-only)
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AbsensiController::class, 'edit'])->name('edit');
    });
    
    // Absensi Guru Routes (Read-only)
    Route::prefix('absensi-guru')->name('absensi-guru.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AbsensiGuruController::class, 'index'])->name('index');
    });
    
    // Materi KBM Routes (Read-only)
    Route::prefix('materi-kbm')->name('materi-kbm.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MateriKbmController::class, 'index'])->name('index');
        Route::get('/{materiKbm}', [App\Http\Controllers\Admin\MateriKbmController::class, 'show'])->name('show');
    });
    
    // Kalender Akademik Routes (Read-only)
    Route::prefix('kalender-akademik')->name('kalender-akademik.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'index'])->name('index');
        Route::get('/{kalenderAkademik}', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'show'])->name('show');
    });
    
    // Jadwal Pelajaran Routes (Read-only)
    Route::prefix('jadwal-pelajaran')->name('jadwal-pelajaran.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'index'])->name('index');
        Route::get('/{jadwalPelajaran}', [App\Http\Controllers\Admin\JadwalPelajaranController::class, 'show'])->name('show');
    });
    
    // PPDB Routes (Read-only)
    Route::prefix('ppdb')->name('ppdb.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SpmbController::class, 'index'])->name('index');
        Route::get('/{spmb}', [App\Http\Controllers\Admin\SpmbController::class, 'show'])->name('show');
        Route::get('/pengaturan', [App\Http\Controllers\Admin\SpmbController::class, 'pengaturan'])->name('pengaturan');
        Route::get('/riwayat', [App\Http\Controllers\Admin\SpmbController::class, 'riwayat'])->name('riwayat');
        Route::get('/export', [App\Http\Controllers\Admin\SpmbController::class, 'export'])->name('export');
    });
    
    // Galeri Routes (Read-only)
    Route::prefix('galeri')->name('galeri.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('index');
        Route::get('/{galeri}', [App\Http\Controllers\Admin\GaleriController::class, 'show'])->name('show');
    });
    
    // Kegiatan Routes (Read-only)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KegiatanController::class, 'index'])->name('index');
        Route::get('/{kegiatan}', [App\Http\Controllers\Admin\KegiatanController::class, 'show'])->name('show');
    });
    
    // Buku Tamu Routes (Read-only)
    Route::prefix('bukutamu')->name('bukutamu.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BukuTamuController::class, 'index'])->name('index');
        Route::get('/{bukutamu}', [App\Http\Controllers\Admin\BukuTamuController::class, 'show'])->name('show');
    });
});

// ==================== ROUTES GURU ====================

Route::prefix('guru')->name('guru.')->middleware(['auth', 'verified', 'active', 'guru'])->group(function () {
    Route::get('/dashboard', fn() => view('guru.dashboard'))->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Guru\ProfileController::class, 'index'])->name('index');
        Route::get('/settings', [App\Http\Controllers\Guru\ProfileController::class, 'settings'])->name('settings');
        Route::put('/update', [App\Http\Controllers\Guru\ProfileController::class, 'update'])->name('update');
        Route::post('/update-photo', [App\Http\Controllers\Guru\ProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::put('/change-password', [App\Http\Controllers\Guru\ProfileController::class, 'changePassword'])->name('change-password');
    });
    
    // Siswa Routes (Read-only)
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/siswa-aktif', [App\Http\Controllers\Admin\SiswaController::class, 'indexAktif'])->name('siswa-aktif.index');
        Route::get('/siswa-aktif/{siswa}', [App\Http\Controllers\Admin\SiswaController::class, 'showAktif'])->name('siswa-aktif.show');
    });
    
    // Absensi Routes (Read-only)
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AbsensiController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\AbsensiController::class, 'edit'])->name('edit');
    });
    
    // Kalender Akademik Routes (Read-only)
    Route::prefix('kalender-akademik')->name('kalender-akademik.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'index'])->name('index');
        Route::get('/{kalenderAkademik}', [App\Http\Controllers\Admin\KalenderAkademikController::class, 'show'])->name('show');
    });
    
    // Galeri Routes (Read-only)
    Route::prefix('galeri')->name('galeri.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GaleriController::class, 'index'])->name('index');
        Route::get('/{galeri}', [App\Http\Controllers\Admin\GaleriController::class, 'show'])->name('show');
    });
    
    // Kegiatan Routes (Read-only)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\KegiatanController::class, 'index'])->name('index');
        Route::get('/{kegiatan}', [App\Http\Controllers\Admin\KegiatanController::class, 'show'])->name('show');
    });
    
    // Buku Tamu Routes (Read-only)
    Route::prefix('bukutamu')->name('bukutamu.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\BukuTamuController::class, 'index'])->name('index');
        Route::get('/{bukutamu}', [App\Http\Controllers\Admin\BukuTamuController::class, 'show'])->name('show');
    });
});

// ==================== ROUTES SISWA ====================

// Public routes for siswa authentication (outside prefix)
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/login/google', [\App\Http\Controllers\Siswa\AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [\App\Http\Controllers\Siswa\AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');

    Route::get('/login', [\App\Http\Controllers\Siswa\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Siswa\AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/register', [\App\Http\Controllers\Siswa\AuthController::class, 'register'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Siswa\AuthController::class, 'storeRegister'])->name('storeRegister');
    Route::post('/logout', [\App\Http\Controllers\Siswa\AuthController::class, 'logout'])->name('logout');
    
    Route::middleware(['auth:siswa'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\Siswa\DashboardController::class, 'profile'])->name('profile');
        Route::get('/formulir', [\App\Http\Controllers\Siswa\DashboardController::class, 'formulir'])->name('formulir');
        Route::get('/dokumen', [\App\Http\Controllers\Siswa\DashboardController::class, 'dokumen'])->name('dokumen');
        Route::post('/dokumen/upload', [\App\Http\Controllers\Siswa\DashboardController::class, 'storeDokumen'])->name('dokumen.upload');
        Route::post('/dokumen/submit', [\App\Http\Controllers\Siswa\DashboardController::class, 'submitPendaftaran'])->name('dokumen.submit');
        Route::get('/pengumuman', [\App\Http\Controllers\Siswa\DashboardController::class, 'pengumuman'])->name('pengumuman');
        Route::get('/success', [\App\Http\Controllers\Siswa\DashboardController::class, 'success'])->name('success');
    });
});

// ==================== AUTH & API ====================

require __DIR__.'/auth.php';

Route::prefix('api')->name('api.')->group(function () {
    Route::prefix('spmb')->name('spmb.')->group(function () {
        Route::get('/status', fn() => response()->json(['error' => 'Not implemented']))->name('status');
        Route::post('/validate-nik', fn() => response()->json(['error' => 'Not implemented']))->name('validateNik');
    });

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
        Route::prefix('bukutamu')->name('bukutamu.')->group(function () {
            Route::get('/statistics', [AdminBukuTamuController::class, 'getStatistics'])->name('statistics');
        });
    });

    // ==================== ROUTES NOTIFIKASI (semua role authenticated) ====================
    Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
        Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('read');
        Route::post('/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('read-all');
    });
});

Route::get('/dashboard', [BaseDashboardController::class, 'index'])->name('dashboard');

Route::fallback(function () {
    return response('<h1>404 - Halaman Tidak Ditemukan</h1>', 404);
});
